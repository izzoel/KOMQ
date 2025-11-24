<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
    * Display a listing of the resource.
    */
    public function index()
    {
        return view('acak');
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
            $pilihan[$label] = $quiz->{"pilihan".$label};
        }

        return view('quiz', compact('quiz', 'pilihan', 'kategori'));
    }

    // public function show(Quiz $quiz, $kategori)
    // {
    //     $labels = ['A', 'B', 'C', 'D'];
    //     $pilihan = [];

    //     foreach ($labels as $label) {
    //         $kolom = "pilihan" . $label;
    //         $pilihan[$label] = $quiz->$kolom;
    //     }

    //     return view('quiz', compact('quiz', 'pilihan'));
    // }


    /**
    * Show the form for editing the specified resource.
    */
    public function edit(Quiz $quiz)
    {
        //
    }

    /**
    * Update the specified resource in storage.
    */
    public function update(Request $request, $kategori, $id_soal, $jawab)
    {
        $quiz = Quiz::where('kategori', $kategori)->where('id', $id_soal)->firstOrFail();

        $benar = strtolower($quiz->jawaban);

        return response()->json([
            'status' => $jawab === $benar ? 'benar' : 'salah',
            'kunci' => strtolower($benar)
        ]);

        //         return response()->json([
        //     'status' => $isCorrect ? 'benar' : 'salah',
        //     'kunci'  => strtolower($quiz->kunci) // misal 'c'
        // ]);

    }



    /**
    * Remove the specified resource from storage.
    */
    public function destroy(Quiz $quiz)
    {
        //
    }
}
