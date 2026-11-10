<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\Quiz;
use App\Models\Reward;
use App\Models\Setting;
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

        $requirePhone = Setting::get('require_phone', '1') === '1';

        return view('acak', compact('totalStok', 'categories', 'requirePhone'));
    }

    /**
     * Verifikasi dan simpan nomor HP peserta sebelum mengundi soal kuis.
     */
    public function verifyPhone(Request $request)
    {
        $requirePhone = Setting::get('require_phone', '1') === '1';

        // Jika fitur input nomor HP sedang dinonaktifkan oleh admin
        if (!$requirePhone) {
            return response()->json([
                'success'  => true,
                'required' => false,
                'message'  => 'Input nomor HP tidak diwajibkan.',
            ]);
        }

        $rawPhone = (string) $request->input('phone', '');
        $cleanPhone = preg_replace('/[^0-9]/', '', $rawPhone);

        // Konversi format nomor telepon lokal Indonesia
        if (str_starts_with($cleanPhone, '628')) {
            $cleanPhone = '08' . substr($cleanPhone, 3);
        } elseif (str_starts_with($cleanPhone, '8')) {
            $cleanPhone = '0' . $cleanPhone;
        }

        // Validasi format nomor telepon
        if (!str_starts_with($cleanPhone, '08') || strlen($cleanPhone) < 10 || strlen($cleanPhone) > 15) {
            return response()->json([
                'success' => false,
                'message' => 'Format nomor HP tidak valid. Masukkan nomor HP aktif diawali 08 (10-15 digit).',
            ], 422);
        }

        // Cek apakah nomor HP sudah pernah digunakan di database
        $exists = Participant::where('phone_number', $cleanPhone)->exists();
        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => "Nomor HP {$cleanPhone} sudah pernah digunakan untuk mengikuti kuis. Setiap nomor hanya berhak bermain 1 kali.",
            ], 409);
        }

        // Simpan nomor HP peserta baru ke database
        $participant = Participant::create([
            'phone_number' => $cleanPhone,
        ]);

        // Simpan ID & nomor HP ke session peserta jika sesi tersedia
        if ($request->hasSession()) {
            $request->session()->put('participant_id', $participant->id);
            $request->session()->put('participant_phone', $cleanPhone);
        }

        return response()->json([
            'success'  => true,
            'required' => true,
            'message'  => 'Nomor HP berhasil didaftarkan. Selamat bermain!',
            'phone'    => $cleanPhone,
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $kategori)
    {
        $quiz = Quiz::where('kategori', $kategori)->inRandomOrder()->firstOrFail();

        // Catat soal dan kategori yang dikerjakan peserta jika terdaftar via nomor HP
        if ($request->hasSession() && $request->session()->has('participant_id')) {
            $participant = Participant::find($request->session()->get('participant_id'));
            if ($participant) {
                $participant->update([
                    'quiz_id'  => $quiz->id,
                    'kategori' => $quiz->kategori,
                    'soal'     => $quiz->soal,
                ]);
            }
        }

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

        $jawabLower = strtolower($jawab);
        $benar = strtolower($quiz->jawaban);
        $isBenar = $jawabLower === $benar;

        // Siapkan keterangan jawaban peserta untuk log database
        if ($jawabLower === 'e') {
            $jawabanTeks = 'Waktu Habis';
            $statusJawaban = 'waktu_habis';
        } else {
            $kolomPilihan = 'pilihan' . strtoupper($jawabLower);
            $teksOpsi = $quiz->{$kolomPilihan} ?? '-';
            $jawabanTeks = strtoupper($jawabLower) . '. ' . $teksOpsi;
            $statusJawaban = $isBenar ? 'benar' : 'salah';
        }

        // Simpan log soal & jawaban peserta ke database jika terdaftar
        if ($request->hasSession() && $request->session()->has('participant_id')) {
            $participant = Participant::find($request->session()->get('participant_id'));
            if ($participant) {
                $participant->update([
                    'quiz_id'         => $quiz->id,
                    'kategori'        => $quiz->kategori,
                    'soal'            => $quiz->soal,
                    'jawaban_peserta' => $jawabanTeks,
                    'status_jawaban'  => $statusJawaban,
                ]);
            }
        }

        // Jika jawaban benar, simpan token sekali pakai di sesi
        if ($isBenar && $request->hasSession()) {
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
