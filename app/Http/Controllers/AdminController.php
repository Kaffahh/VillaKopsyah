<?php

namespace App\Http\Controllers;

use App\Models\Request as VillaRequest;
use App\Models\User;
use App\Models\Villa;
// use Illuminate\Http\Request;
use App\Notifications\RequestStatusNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    // Konstanta untuk caching
    const CACHE_TTL = 3600; // 1 jam
    const PAGINATION_PER_PAGE = 10;

    public function dashboard()
    {
        // Count data
        $counts = [
            'totalRequests' => VillaRequest::count(),
            'approvedRequests' => VillaRequest::where('status', 'approved')->count(),
            'rejectedRequests' => VillaRequest::where('status', 'rejected')->count(),
            'totalUsers' => User::count(),
            'villaOwners' => User::where('role', 'pemilik_villa')->count(),
            'newVillaOwnersToday' => User::where('role', 'pemilik_villa')
                ->whereDate('created_at', today())
                ->count()
        ];

        // Request data
        $requests = [
            'pending' => VillaRequest::with('user')
                ->where('status', 'pending')
                ->latest()
                ->get(),
            'processed' => VillaRequest::with('user')
                ->whereIn('status', ['approved', 'rejected'])
                ->latest()
                ->get(),
            'all' => VillaRequest::with('user')->latest()->get()
        ];

        // Villa data
        $villaData = [
            'topVillas' => Villa::with(['user', 'transactions'])
                ->withCount('transactions')
                ->orderByDesc('transactions_count')
                ->limit(3)
                ->get(),
            'topOwners' => User::where('role', 'pemilik_villa')
                ->withCount('villas')
                ->orderByDesc('villas_count')
                ->limit(3)
                ->get()
        ];

        // Chart data
        $charts = [
            'owner' => [
                'weekly' => $this->getOwnerGrowthData('weekly'),
                'monthly' => $this->getOwnerGrowthData('monthly')
            ],
            'villa' => [
                'weekly' => $this->getVillaGrowthData('weekly'),
                'monthly' => $this->getVillaGrowthData('monthly')
            ]
        ];

        return view('admin.dashboard.index', array_merge(
            $counts,
            ['requests' => $requests['all']],
            $villaData,
            $charts,
            [
                'pendingRequests' => $requests['pending'],
                'processedRequests' => $requests['processed'],
                'ownerWeeklyData' => $charts['owner']['weekly'],
                'ownerMonthlyData' => $charts['owner']['monthly'],
                'weeklyData' => $charts['villa']['weekly'],
                'monthlyData' => $charts['villa']['monthly']
            ],
        ));
    }

    private function getOwnerGrowthData($type)
    {
        $data = [];
        $labels = [];
        $now = now();

        if ($type === 'weekly') {
            $labels = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];

            for ($i = 6; $i >= 0; $i--) {
                $date = $now->copy()->subDays($i);
                $data[] = User::where('role', 'pemilik_villa')
                    ->whereDate('created_at', $date)
                    ->count();
            }
        } else {
            for ($i = 11; $i >= 0; $i--) {
                $month = $now->copy()->subMonths($i);
                $labels[] = $month->translatedFormat('M');
                $data[] = User::where('role', 'pemilik_villa')
                    ->whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count();
            }
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }
    public function getVillaDetail($id)
    {
        $villa = Villa::with(['type', 'facilities', 'prices', 'capacities'])
            ->findOrFail($id);

        return response()->json([
            'id' => $villa->id,
            'name' => $villa->name,
            'type' => $villa->type,
            'image_url' => asset('storage/' . $villa->image),
            'latest_price' => number_format($villa->prices->last()->price_per_night, 0, ',', '.'),
            'latest_capacity' => $villa->capacities->last()->capacity,
            'status' => $villa->status,
            'location' => $villa->location,
            'facilities' => $villa->facilities
        ]);
    }

    public function getOwnerDetail($id)
    {
        $owner = User::with(['villas' => function ($query) {
            $query->select('id', 'user_id', 'name', 'image', 'location');
        }])->findOrFail($id);

        $villas = $owner->villas->map(function ($villa) {
            return [
                'id' => $villa->id,
                'name' => $villa->name,
                'image_url' => asset('storage/' . $villa->image),
                'location' => $villa->location
            ];
        });

        return response()->json([
            'id' => $owner->id,
            'name' => $owner->name,
            'email' => $owner->email,
            'villas' => $villas
        ]);
    }
    private function getVillaGrowthData($type)
    {
        $data = [];
        $labels = [];
        $now = now();

        if ($type === 'weekly') {
            $labels = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];

            for ($i = 6; $i >= 0; $i--) {
                $date = $now->copy()->subDays($i);
                $data[] = Villa::whereDate('created_at', $date)->count();
            }
        } else {
            for ($i = 11; $i >= 0; $i--) {
                $month = $now->copy()->subMonths($i);
                $labels[] = $month->translatedFormat('M');
                $data[] = Villa::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count();
            }
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    public function pendingRequests()
    {
        $requests = VillaRequest::with('user')
            ->pending()
            ->latest()
            ->paginate(self::PAGINATION_PER_PAGE);

        return view('admin.pending_requests', compact('requests'));
    }

    public function approve($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $request = VillaRequest::findOrFail($id);

                $request->update([
                    'status' => 'approved',
                    'expired_at' => null
                ]);

                $request->user()->update(['role' => 'pemilik_villa']);

                $this->sendNotification(
                    $request,
                    'approved',
                    'Pengajuan Anda telah disetujui. Sekarang Anda adalah pemilik villa.'
                );

                // Clear relevant cache
                Cache::forget('dashboard_counts');
            });

            return redirect()->route('admin.requests')
                ->with('success', 'Pengajuan telah disetujui.');
        } catch (\Exception $e) {
            Log::error('Approval failed: ' . $e->getMessage());
            return back()->with('error', 'Gagal menyetujui pengajuan.');
        }
    }

    public function reject($id)
    {
        try {
            $request = VillaRequest::findOrFail($id);

            $request->update(['status' => 'rejected']);

            $this->sendNotification(
                $request,
                'rejected',
                'Pengajuan Anda telah ditolak. Silakan periksa kembali dokumen Anda.'
            );

            Cache::forget('dashboard_counts');

            return redirect()->route('admin.requests')
                ->with('success', 'Pengajuan telah ditolak.');
        } catch (\Exception $e) {
            Log::error('Rejection failed: ' . $e->getMessage());
            return back()->with('error', 'Gagal menolak pengajuan.');
        }
    }

    /**
     * Helper method untuk data grafik
     */
    private function getChartData($type, $range)
    {
        $cacheKey = "chart_{$type}_{$range}";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($type, $range) {
            $data = [];
            $labels = [];
            $now = now();

            if ($range === 'weekly') {
                $labels = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];

                for ($i = 6; $i >= 0; $i--) {
                    $date = $now->copy()->subDays($i);
                    $data[] = $this->getCountForDate($type, $date);
                }
            } else {
                for ($i = 11; $i >= 0; $i--) {
                    $month = $now->copy()->subMonths($i);
                    $labels[] = $month->translatedFormat('M');
                    $data[] = $this->getCountForMonth($type, $month);
                }
            }

            return compact('labels', 'data');
        });
    }

    private function getCountForDate($type, $date)
    {
        return match ($type) {
            'owner' => User::villaOwners()
                ->whereDate('created_at', $date)
                ->count(),
            'villa' => Villa::whereDate('created_at', $date)->count(),
            default => 0
        };
    }

    private function getCountForMonth($type, $month)
    {
        return match ($type) {
            'owner' => User::villaOwners()
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count(),
            'villa' => Villa::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count(),
            default => 0
        };
    }

    /**
     * Helper method untuk notifikasi
     */
    private function sendNotification($request, $status, $message)
    {
        try {
            $request->user->notify(
                new RequestStatusNotification($status, $message)
            );
        } catch (\Exception $e) {
            Log::error('Notification failed: ' . $e->getMessage());
        }
    }
}
