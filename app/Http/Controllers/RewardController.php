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
            Storage::put('admin_logs.txt', $log);
        }

        else {
            if ($reward->stock > 0) {
                $reward->stock_temp = $reward->stock;
                $reward->stock = 0;
                $reward->is_aktive = 0;
            }
            $log = "[" . now()->format('Y-m-d H:i:s') . "] Admin melakukan off reward ". $reward->name. ' stok:' . $reward->stock;
            Storage::put('admin_logs.txt', $log);
        }

        $reward->save();

        return response()->json([
            "success" => true,
            "stock" => $reward->stock,
            "stock_temp" => $reward->stock_temp
        ]);
    }

    public function set()
    {
        $flagFile = storage_path('app/last_reward_reset.txt');
        $today = now('Asia/Makassar')->toDateString();

        // Cek apakah sudah reset hari ini
        if (file_exists($flagFile)) {
            $lastDate = trim(file_get_contents($flagFile));
            if ($lastDate === $today) {
                return "Reward sudah di-set hari ini ($today)";
            }
        }

        // TRUNCATE TABLE REWARD
        DB::table('rewards')->truncate();

        // DATA DEFAULT (dengan stock_temp & is_aktive)
        $defaultRewards = [
            [
                'name'        => 'Payung',
                'stock'       => 10,
                'stock_temp'  => 0,
                'is_aktive'   => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Indomie',
                'stock'       => 20,
                'stock_temp'  => 0,
                'is_aktive'   => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Minyak Goreng',
                'stock'       => 5,
                'stock_temp'  => 0,
                'is_aktive'   => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Gula',
                'stock'       => 5,
                'stock_temp'  => 0,
                'is_aktive'   => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Snack',
                'stock'       => 5,
                'stock_temp'  => 0,
                'is_aktive'   => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ];

        DB::table('rewards')->insert($defaultRewards);

        // Simpan tanggal hari ini
        file_put_contents($flagFile, $today);

        return response()->json([
            'success' => true,
            'message' => "Reward berhasil di-reset & diset ulang untuk tanggal $today"
        ]);

    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'stock' => 'required|integer|min:1',
        ]);

        Reward::create([
            'name' => $request->name,
            'stock' => $request->stock,
            'is_aktive' => 0,
        ]);

        $log = "[" . now()->format('Y-m-d H:i:s') . "] Admin melakukan tambah reward";
        Storage::put('admin_logs.txt', $log);

        return response()->json(['success' => true]);
    }

    public function show(Reward $reward)
    {
        return Reward::where('stock', '>', 0)->pluck('name');

    }

    public function edit(Request $request,Reward $reward)
    {
        $request->validate([
            'id'    => 'required|exists:rewards,id',
            'name'  => 'required|string|max:255',
            'stock' => 'required|integer|min:0'
        ]);

        // update reward
        Reward::where('id', $request->id)->update([
            'name'  => $request->name,
            'stock' => $request->stock,
        ]);

        $log = "[" . now()->format('Y-m-d H:i:s') . "] Admin melakukan edit reward " . $reward->name;
        Storage::put('admin_logs.txt', $log);

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
        // Cari reward berdasarkan name
        $reward = Reward::where('name', $request->reward)->first();

        if ($reward && $reward->stock > 0) {

            // Kurangi stok
            $reward->stock -= 1;
            $reward->save();

            // Tulis log ke file reward_logs.txt
            $log = "[" . now()->format('Y-m-d H:i:s') . "] "
            . "Anonimus: " . $reward->name . " x1 | Sisa stock: " . $reward->stock;

            Storage::put('reward_logs.txt', $log);
        }

        return response()->json(['success' => true]);
    }

    public function destroy(Reward $reward)
    {
        //
    }
}
