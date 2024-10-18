<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\District;
use App\Models\Province;
use App\Models\Subdistrict;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('home');
    }

    public function getProvince()
    {
        $data = Province::where('name', 'LIKE', '%' . request('q') . '%')->paginate(10);

        return response()->json($data);
    }

    public function getCity($id)
    {
        $data = City::where('province_id', $id)->where('name', 'LIKE', '%' . request('q') . '%')->paginate(10);

        return response()->json($data);
    }

    public function getDistrict($id)
    {
        $data = District::where('regency_id', $id)->where('name', 'LIKE', '%' . request('q') . '%')->paginate(10);

        return response()->json($data);
    }

    public function getSubdistrict($id)
    {
        $data = Subdistrict::where('district_id', $id)->where('name', 'LIKE', '%' . request('q') . '%')->paginate(10);

        return response()->json($data);
    }

    public function storeSubscription(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|min:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'messages' => $validator->errors()->all(),
            ], 422);
        }

        $ip = $request->ip();
        // Simpan data ke database
        Subscription::create([
            'email' => $request->email,
            'IP' => $ip,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Subscription successful!',
        ]);
    }
}
