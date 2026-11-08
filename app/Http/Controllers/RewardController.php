<?php

namespace App\Http\Controllers;

use App\Models\Reward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RewardController extends Controller
{
    /**
    * Display a listing of the resource.
    */
    public function index()
    {
        $rewards = Reward::all();
        return view('reward', compact('rewards'));
    }

    public function add($id)
    {
        $reward = Reward::findOrFail($id);
        $reward->stock += 1;
        $reward->save();

        $log = "[" . now()->format('Y-m-d H:i:s') . "] Admin melakukan + stok ". $reward->name;
        Storage::put('admin_logs.txt', $log);

        return response()->json(['success' => true]);
    }

    public function minus($id)
    {
        $reward = Reward::findOrFail($id);
        if ($reward->stock > 0) {
            $reward->stock -= 1;
            $reward->save();
        }
        $log = "[" . now()->format('Y-m-d H:i:s') . "] Admin melakukan - stok ". $reward->name;
        Storage::put('admin_logs.txt', $log);

        return response()->json(['success' => true]);
    }

    public function toggle(Request $request)
    {
        $reward = Reward::findOrFail($request->id);

        if ($request->status == 1) {
            if ($reward->stock == 0 && $reward->stock_temp > 0) {
                $reward->stock = $reward->stock_temp;
                $reward->stock_temp = 0;
                $reward->is_aktive = 1;
            }
            $log = "[" . now()->format('Y-m-d H:i:s') . "] Admin melakukan on reward ". $reward->name . ' stok:' . $reward->stock;
            Storage::append('admin_logs.txt', $log);
        }

        else {
            if ($reward->stock > 0) {
                $reward->stock_temp = $reward->stock;
                $reward->stock = 0;
                $reward->is_aktive = 0;
            }
            $log = "[" . now()->format('Y-m-d H:i:s') . "] Admin melakukan off reward ". $reward->name. ' stok:' . $reward->stock;
            Storage::append('admin_logs.txt', $log);
        }

        $reward->save();

        return response()->json([
            "success" => true,
            "stock" => $reward->stock,
            "stock_temp" => $reward->stock_temp
        ]);
    }

    public function set(?Request $request = null)
    {
        $flagFile = storage_path('app/last_reward_reset.txt');

        $now   = now('Asia/Makassar');
        $today = $now->toDateString();
        $time  = $now->format('H:i');

        $count = Reward::count();

        if ($count === 0) {
            // Jika tabel reward kosong sama sekali, buat data reward default
            $defaultRewards = [
                ['name'=>'Payung', 'stock'=>1, 'default_stock'=>1, 'stock_temp'=>0, 'is_aktive'=>1],
                ['name'=>'Indomie', 'stock'=>8, 'default_stock'=>8, 'stock_temp'=>0, 'is_aktive'=>1],
                ['name'=>'Minyak Goreng', 'stock'=>3, 'default_stock'=>3, 'stock_temp'=>0, 'is_aktive'=>1],
                ['name'=>'Gula', 'stock'=>3, 'default_stock'=>3, 'stock_temp'=>0, 'is_aktive'=>1],
                ['name'=>'Snack', 'stock'=>10, 'default_stock'=>10, 'stock_temp'=>0, 'is_aktive'=>1],
                ['name'=>'Gantungan Kunci', 'stock'=>3, 'default_stock'=>3, 'stock_temp'=>0, 'is_aktive'=>1],
            ];

            foreach ($defaultRewards as &$r) {
                $r['created_at'] = $now;
                $r['updated_at'] = $now;
            }

            DB::table('rewards')->insert($defaultRewards);
        } else {
            // Kembalikan semua reward aktif ke nilai default_stock tanpa menghapus (truncate) data
            DB::table('rewards')
                ->where('is_aktive', 1)
                ->update([
                    'stock'      => DB::raw('CASE WHEN default_stock > 0 THEN default_stock ELSE stock END'),
                    'stock_temp' => 0,
                    'updated_at' => $now,
                ]);
        }

        // === SIMPAN LOG RESET ===
        file_put_contents($flagFile, $today . "|" . $time);

        $log = "[" . $now->format('Y-m-d H:i:s') . "] Reset stok reward harian dijalankan.";
        Storage::append('admin_logs.txt', $log);

        if ($request && ($request->expectsJson() || $request->ajax())) {
            return response()->json([
                'success' => true,
                'message' => "Stok reward berhasil di-reset pada " . $now->format('d/m/Y H:i'),
            ]);
        }

        return redirect()->route('admin.index')->with('success', "Stok reward berhasil di-reset pada " . $now->format('d/m/Y H:i'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'stock' => 'required|integer|min:1',
            'default_stock' => 'nullable|integer|min:1',
        ]);

        $defaultStock = $request->filled('default_stock') ? (int) $request->default_stock : (int) $request->stock;

        Reward::create([
            'name' => $request->name,
            'stock' => $request->stock,
            'default_stock' => $defaultStock,
            'stock_temp' => 0,
            'is_aktive' => 1,
        ]);

        $log = "[" . now()->format('Y-m-d H:i:s') . "] Admin melakukan tambah reward: " . $request->name;
        Storage::append('admin_logs.txt', $log);

        return response()->json(['success' => true]);
    }

    public function show(Reward $reward)
    {
        return Reward::where('stock', '>', 0)->pluck('name');

    }

    public function edit(Request $request)
    {
        $request->validate([
            'id'    => 'required|exists:rewards,id',
            'name'  => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'default_stock' => 'nullable|integer|min:0',
        ]);

        $reward = Reward::findOrFail($request->id);

        $defaultStock = $request->filled('default_stock')
            ? (int) $request->default_stock
            : (int) $request->stock;

        $reward->update([
            'name'          => $request->name,
            'stock'         => $request->stock,
            'default_stock' => $defaultStock,
        ]);

        $log = "[" . now()->format('Y-m-d H:i:s') . "] Admin melakukan edit reward " . $reward->name;
        Storage::append('admin_logs.txt', $log);

        return response()->json([
            'success' => true,
            'message' => 'Reward berhasil diubah'
        ]);
    }

    public function editReward(Request $request,Reward $reward)
    {
        return Reward::find($request->id);
    }

    public function update(Request $request, Reward $reward)
    {
        // Cek apakah peserta memiliki token klaim yang valid
        if (!$request->session()->has('reward_token')) {
            return response()->json([
                'success' => false,
                'message' => 'Akses tidak sah. Silakan jawab kuis terlebih dahulu.'
            ], 403);
        }

        // Cari reward berdasarkan name
        $reward = Reward::where('name', $request->reward)->first();

        if ($reward && $reward->stock > 0) {

            // Kurangi stok
            $reward->stock -= 1;
            $reward->save();

            // Tulis log ke file reward_logs.txt
            $log = "[" . now()->format('Y-m-d H:i:s') . "] "
            . "Anonimus: " . $reward->name . " x1 | Sisa stock: " . $reward->stock;

            Storage::append('reward_logs.txt', $log);
        }

        // Hapus token agar tidak bisa digunakan ulang
        $request->session()->forget('reward_token');

        return response()->json(['success' => true]);
    }

    public function destroy(Reward $reward)
    {
        //
    }
}
