<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminCustomerController;
use App\Http\Controllers\AdminPemilikVillaController;
use App\Http\Controllers\AdminPetugasController;
use App\Http\Controllers\AdminTransactionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerVillaController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PemilikVillaController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VillaController;
use App\Http\Controllers\VillaTypeController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\RequestController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

// Login Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Register Routes
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/cities/{province_id}', [RegionController::class, 'getCities']);
Route::get('/districts/{regency_id}', [RegionController::class, 'getDistricts']);
Route::get('/villages/{district_id}', [RegionController::class, 'getVillages']);

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Auth::routes();

Route::middleware(['auth', 'user-access:customers'])->group(function () {
    Route::get('/requests/create', [RequestController::class, 'create'])->name('requests.create');
    Route::post('/requests', [RequestController::class, 'store'])->name('requests.store');

    // Route::get('/dashboard-customers', [HomeController::class, 'index'])->name('customers.dashboard');
    Route::get('/customers/dashboard', [HomeController::class, 'index'])->name('customers.dashboard');

    Route::get('/villas', [CustomerVillaController::class, 'index'])->name('customers.villas.index');
    Route::get('/villas/{id}', [CustomerVillaController::class, 'show'])->name('customers.villas.show');

    Route::post('/notifications/mark-as-read/{id}', [HomeController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::get('customers/profile', [PetugasController::class, 'userProfile'])->name('customers.profile');
    Route::get('/customers/transactions', [TransactionController::class, 'customerTransactions'])->name('customers.transactions.index');
    Route::get('/customers/transactions/{id}', [TransactionController::class, 'customerTransactionShow'])->name('customers.transactions.show');
    Route::put('/customers/transactions/payment/{id}', [TransactionController::class, 'updatePayment'])->name('transactions.updatePayment');
});

Route::middleware(['auth', 'user-access:customers,pemilik_villa'])->group(function () {
    Route::get('/requests/create', [RequestController::class, 'create'])->name('requests.create');
    Route::get('/customers/dashboard', [HomeController::class, 'index'])->name('customers.dashboard');
    Route::get('customers/profile', [PetugasController::class, 'userProfile'])->name('customers.profile');
});

// Route::middleware(['auth', 'user-access:pemilik_villa'])->group(function () {
Route::prefix('pemilik_villa')
    ->middleware(['auth', 'user-access:pemilik_villa'])
    ->group(function () {
        Route::get('/dashboard', [HomeController::class, 'pemilikDashboard'])->name('pemilik_villa.dashboard');
        Route::get('/profile', [PemilikVillaController::class, 'pemilikVillaProfile'])->name('pemilik_villa.profile');

        Route::resource('villas', PemilikVillaController::class)
            ->except(['show'])
            ->names('pemilik_villa.villas');
        Route::get('villas/{id}/facilities', [PemilikVillaController::class, 'getFacilities']);
        Route::get('villas/{id}/images', [PemilikVillaController::class, 'getImages']);
    });

Route::middleware(['auth', 'user-access:petugas'])->group(function () {
    // Route::get('/dashboard-petugas', [HomeController::class, 'petugasDashboard'])->name('petugas.dashboard');
    Route::get('/petugas/dashboard', [HomeController::class, 'petugasDashboard'])->name('petugas.dashboard');
    Route::get('petugas/profile', action: [PetugasController::class, 'profile'])->name('petugas.profile');
});

Route::prefix('admin')
    ->middleware(['auth', 'user-access:admin'])
    ->group(function () {
        // Route::middleware(['auth', 'user-access:admin'])->group(function () {
        Route::get('/requests', [AdminController::class, 'pendingRequests'])->name('admin.requests');

        Route::post('/requests/{id}/approve', [AdminController::class, 'approve'])->name('admin.approve');
        Route::post('/requests/{id}/reject', [AdminController::class, 'reject'])->name('admin.reject');
        Route::get('/requests/{id}/detail', [AdminController::class, 'getRequestDetail'])->name('admin.requests.detail');
        // Route::get('/dashboard-admin', [HomeController::class, 'adminDashboard'])->name('admin.dashboard');
        // Route::get('/dashboard', [HomeController::class, 'adminDashboard'])->name('admin.dashboard');
        // Route::get('/dashboard', [HomeController::class, 'adminDashboard'])->name('admin.dashboard');

        Route::get('/villas/{id}/detail', [AdminController::class, 'getVillaDetail'])->name('admin.villas.detail');
        Route::get('/pemilik_villa/{id}/detail', [AdminController::class, 'getOwnerDetail'])->name('admin.pemilik_villa.detail');

        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/dashboard/tab1', [AdminController::class, 'tab1'])->name('admin.dashboard.tab1');
        Route::get('/dashboard/tab2', [AdminController::class, 'tab2'])->name('admin.dashboard.tab2');
        Route::get('/dashboard/tab3', [AdminController::class, 'tab3'])->name('admin.dashboard.tab3');
        Route::get('/dashboard/tab4', [AdminController::class, 'tab4'])->name('admin.dashboard.tab4');

        Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile');
        Route::put('/profile/update/{field}', [ProfileController::class, 'update'])->name('profile.update');

        Route::resource('/pemilik_villa', AdminPemilikVillaController::class)->names('admin.pemilik_villa');
        Route::resource('/petugas', AdminPetugasController::class)->names('admin.petugas');
        Route::get('/petugas/check/{villa}', [AdminPetugasController::class, 'checkVillaPetugas']);

        Route::resource('/customers', AdminCustomerController::class)->names('admin.customers');
        Route::resource('/villa_types', VillaTypeController::class)->names('admin.villa_types');
        Route::resource('/facilities', FacilityController::class)->names('admin.facilities');
        Route::resource('/villas', VillaController::class)->names('admin.villas');
        Route::delete('admin/villa-image/{image}', [VillaController::class, 'deleteImage'])->name('admin.villa.image.delete');
        // Route::get('/villas', [VillaController::class,'index'])->name('villas');

        Route::resource('/transactions', AdminTransactionController::class)->names('admin.transactions');
        // Route::get('/transactions', [AdminTransactionController::class, 'index']);
    });
