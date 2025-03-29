<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegionController extends Controller
{
    public function getProvinces()
    {
        $provinces = Province::all(['id', 'code', 'name']);
        return view('register', compact('provinces'));
    }

    public function getCities($province_code)
    {
        $cities = DB::table('cities')->where('province_code', $province_code)->get();
        return response()->json($cities);
    }

    public function getDistricts($city_code)
    {
        $districts = DB::table('districts')->where('city_code', $city_code)->get();
        return response()->json($districts);
    }

    public function getVillages($district_code)
    {
        $villages = DB::table('villages')->where('district_code', $district_code)->get();
        return response()->json($villages);
    }
}
