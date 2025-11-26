<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Reward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        $rewards = Reward::all();

        $path = storage_path('app/last_reward_reset.txt');
        $sudahReset = file_exists($path);
        $tanggalReset = $sudahReset ? trim(file_get_contents($path)) : null;

        return view('admin', compact('rewards','sudahReset', 'tanggalReset'));
    }

    public function login()
    {
        return view('login');
    }

    public function logout(Request $request)
    {
        // hapus semua session
        $request->session()->flush();

        // redirect ke halaman login
        return redirect('/login')->with('success', 'Berhasil logout!');
    }


    public function proses(Request $request)
    {
        $credentials = $request->only('name', 'password');

        if (Auth::attempt($credentials)) {
            return response()->json(['success' => true, 'message' => 'Sukses']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal']);
        }
    }
}
