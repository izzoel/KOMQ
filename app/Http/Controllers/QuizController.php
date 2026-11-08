<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Reward;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalStok = Reward::sum('stock');
        $dbCategories = Quiz::select('kategori')->distinct()->pluck('kategori')->toArray();

        $defaultCategories = ['Pemrograman', 'Artificial Intelligence', 'SuperApps', 'Internet Sehat', 'GOVEM', 'LAPOR!'];
        $categories = !empty($dbCategories) ? array_values($dbCategories) : $defaultCategories;

        return view('acak', compact('totalStok', 'categories'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($kategori)
    {
        $quiz = Quiz::where('kategori', $kategori)->inRandomOrder()->firstOrFail();

        $labels = ['A', 'B', 'C', 'D'];
        $pilihan = [];

        foreach ($labels as $label) {
            $pilihan[$label] = $quiz->{'pilihan'.$label};
        }

        return view('quiz', compact('quiz', 'pilihan', 'kategori'));
    }

    public function reward(Request $request)
    {
        // Cek apakah peserta sudah menjawab kuis dengan benar
        if (! $request->session()->has('reward_token')) {
            return redirect('/')->with('error', 'Anda harus menjawab kuis dengan benar terlebih dahulu.');
        }

        $totalStok = Reward::sum('stock');

        return view('reward', compact('totalStok'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $kategori, $id_soal, $jawab)
    {
        $quiz = Quiz::where('kategori', $kategori)->where('id', $id_soal)->firstOrFail();

        $benar = strtolower($quiz->jawaban);
        $isBenar = $jawab === $benar;

        // Jika jawaban benar, simpan token sekali pakai di sesi
        if ($isBenar) {
            $request->session()->put('reward_token', bin2hex(random_bytes(16)));
        }

        return response()->json([
            'status' => $isBenar ? 'benar' : 'salah',
            'kunci' => strtolower($benar),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quiz $quiz)
    {
        //
    }
}
