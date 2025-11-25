<?php

namespace App\Http\Controllers;

use App\Models\Reward;
use Illuminate\Http\Request;

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
        return response()->json(['success' => true]);
    }

    public function minus($id)
    {
        $reward = Reward::findOrFail($id);
        if ($reward->stock > 0) {
            $reward->stock -= 1;
            $reward->save();
        }
        return response()->json(['success' => true]);
    }

    public function toggle(Request $request)
    {
        $reward = Reward::findOrFail($request->id);

        // SWITCH ON (aktif)
        if ($request->status == 1) {
            // jika stock masih kosong, kembalikan dari stock_temp
            if ($reward->stock == 0 && $reward->stock_temp > 0) {
                $reward->stock = $reward->stock_temp;
                $reward->stock_temp = 0;
                $reward->is_aktive = 1;
            }
        }

        // SWITCH OFF (nonaktif)
        else {
            // pindahkan stock → stock_temp
            if ($reward->stock > 0) {
                $reward->stock_temp = $reward->stock;
                $reward->stock = 0;
                $reward->is_aktive = 0;
            }
        }

        $reward->save();

        return response()->json([
            "success" => true,
            "stock" => $reward->stock,
            "stock_temp" => $reward->stock_temp
        ]);
    }

    /**
    * Show the form for creating a new resource.
    */
    public function create()
    {
        //
    }

    /**
    * Store a newly created resource in storage.
    */
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

        return response()->json(['success' => true]);
    }

    /**
    * Display the specified resource.
    */
    public function show(Reward $reward)
    {
        return Reward::where('stock', '>', 0)->pluck('name');

    }

    /**
    * Show the form for editing the specified resource.
    */
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

        return response()->json([
            'success' => true,
            'message' => 'Reward berhasil diubah'
        ]);
    }
    public function editReward(Request $request,Reward $reward)
    {
        return Reward::find($request->id);
    }

    /**
    * Update the specified resource in storage.
    */
    public function update(Request $request, Reward $reward)
    {
        $reward = Reward::where('name', $request->reward)->first();

        if ($reward && $reward->stock > 0) {
            // return response()->json($reward->stock);
            $reward->stock -= 1;
            $reward->save();
        }

        return response()->json(['success' => true]);
    }

    /**
    * Remove the specified resource from storage.
    */
    public function destroy(Reward $reward)
    {
        //
    }
}
