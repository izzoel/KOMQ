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

    public function set()
    {
        $flagFile = storage_path('app/last_reward_reset.txt');

        $now       = now('Asia/Makassar');
        $today     = $now->toDateString();
        $timeNow   = $now->format('H:i');
        $resetTime = "17:50"; // jam reset harian

        // ---- BACA FILE FLAG JIKA ADA ----
        $lastDate = null;
        $lastTime = null;

        if (file_exists($flagFile)) {
            $content = explode("|", trim(file_get_contents($flagFile)));

            $lastDate = $content[0] ?? null;
            $lastTime = $content[1] ?? null;
        }

        // ---- KONDISI 1: RESET SAAT BERGANTI HARI ----
        $shouldReset = false;

        if ($lastDate !== $today) {
            $shouldReset = true;
        }

        // ---- KONDISI 2: RESET OTOMATIS JAM 17:50 ----
        if ($timeNow >= $resetTime && $lastDate === $today && $lastTime !== $resetTime) {
            $shouldReset = true;
        }

        // Jika tidak ada kondisi yang terpenuhi, jangan reset
        if (! $shouldReset) {
            return response()->json([
                'success' => false,
                'message' => "Reward sudah di-set hari ini",
            ]);
        }

        // ---- RESET REWARD ----
        DB::table('rewards')->truncate();

        $defaultRewards = [
            ['name'=>'Payung','stock'=>1,'stock_temp'=>0,'is_aktive'=>1],
            ['name'=>'Indomie','stock'=>8,'stock_temp'=>0,'is_aktive'=>1],
            ['name'=>'Minyak Goreng','stock'=>3,'stock_temp'=>0,'is_aktive'=>1],
            ['name'=>'Gula','stock'=>3,'stock_temp'=>0,'is_aktive'=>1],
            ['name'=>'Snack','stock'=>10,'stock_temp'=>0,'is_aktive'=>1],
            ['name'=>'Gantungan Kunci','stock'=>3,'stock_temp'=>0,'is_aktive'=>1],
        ];

        foreach ($defaultRewards as &$r) {
            $r['created_at'] = $now;
            $r['updated_at'] = $now;
        }

        DB::table('rewards')->insert($defaultRewards);

        // ---- SIMPAN TANGGAL & JAM RESET ----
        file_put_contents($flagFile, $today . "|" . ($timeNow >= $resetTime ? $resetTime : $timeNow));

        return response()->json([
            'success' => true,
            'message' => "Reward berhasil di-reset pada " . $now->format('Y-m-d H:i'),
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
        Storage::append('admin_logs.txt', $log);

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

        return response()->json(['success' => true]);
    }

    public function destroy(Reward $reward)
    {
        //
    }
}
