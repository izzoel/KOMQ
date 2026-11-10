<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\Quiz;
use App\Models\Reward;
use App\Models\Setting;
use App\Models\User;
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

        $requirePhone = Setting::get('require_phone', '1') === '1';
        $totalParticipants = Participant::count();

        return view('admin', compact('rewards', 'sudahReset', 'tanggalReset', 'requirePhone', 'totalParticipants'));
    }

    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('admin.index');
        }

        return view('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Berhasil logout!');
    }

    public function proses(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('name', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return response()->json(['success' => true, 'message' => 'Sukses']);
        } else {
            return response()->json(['success' => false, 'message' => 'Password salah!']);
        }
    }

    // ========================================
    // CRUD Manajemen Soal Kuis
    // ========================================

    public function quizIndex(Request $request)
    {
        $kategori = $request->query('kategori');

        $query = Quiz::orderBy('kategori')->orderBy('id', 'desc');

        if ($kategori) {
            $query->where('kategori', $kategori);
        }

        $quizzes = $query->get();
        $kategoriList = Quiz::select('kategori')->distinct()->orderBy('kategori')->pluck('kategori');

        return view('admin-quiz', compact('quizzes', 'kategoriList', 'kategori'));
    }

    public function quizStore(Request $request)
    {
        $request->validate([
            'soal'     => 'required|string',
            'pilihanA' => 'required|string|max:255',
            'pilihanB' => 'required|string|max:255',
            'pilihanC' => 'required|string|max:255',
            'pilihanD' => 'required|string|max:255',
            'jawaban'  => 'required|in:a,b,c,d',
            'kategori' => 'required|string|max:255',
        ]);

        Quiz::create($request->only([
            'soal', 'pilihanA', 'pilihanB', 'pilihanC', 'pilihanD', 'jawaban', 'kategori'
        ]));

        return response()->json(['success' => true, 'message' => 'Soal berhasil ditambahkan']);
    }

    public function quizEdit($id)
    {
        $quiz = Quiz::findOrFail($id);
        return response()->json($quiz);
    }

    public function quizUpdate(Request $request)
    {
        $request->validate([
            'id'       => 'required|exists:quizzes,id',
            'soal'     => 'required|string',
            'pilihanA' => 'required|string|max:255',
            'pilihanB' => 'required|string|max:255',
            'pilihanC' => 'required|string|max:255',
            'pilihanD' => 'required|string|max:255',
            'jawaban'  => 'required|in:a,b,c,d',
            'kategori' => 'required|string|max:255',
        ]);

        Quiz::where('id', $request->id)->update($request->only([
            'soal', 'pilihanA', 'pilihanB', 'pilihanC', 'pilihanD', 'jawaban', 'kategori'
        ]));

        return response()->json(['success' => true, 'message' => 'Soal berhasil diperbarui']);
    }

    public function quizDestroy($id)
    {
        $quiz = Quiz::findOrFail($id);
        $quiz->delete();

        return response()->json(['success' => true, 'message' => 'Soal berhasil dihapus']);
    }

    // ========================================
    // Pengaturan Fitur & Manajemen Peserta
    // ========================================

    public function featuresIndex()
    {
        $requirePhone = Setting::get('require_phone', '1') === '1';

        return view('admin-features', compact('requirePhone'));
    }

    public function participantsIndex()
    {
        $participants = Participant::orderBy('id', 'desc')->get();
        $totalParticipants = $participants->count();
        $requirePhone = Setting::get('require_phone', '1') === '1';

        return view('admin-participants', compact('participants', 'totalParticipants', 'requirePhone'));
    }

    public function togglePhoneRequirement(Request $request)
    {
        $current = Setting::get('require_phone', '1');
        $newVal = ($current === '1') ? '0' : '1';
        Setting::set('require_phone', $newVal);

        $statusText = ($newVal === '1') ? 'Aktif (Wajib Input No. HP)' : 'Nonaktif (Tanpa Input No. HP)';
        $log = "[" . now()->format('Y-m-d H:i:s') . "] Admin mengubah pengaturan verifikasi nomor HP: " . $statusText;
        Storage::append('admin_logs.txt', $log);

        return response()->json([
            'success'     => true,
            'status'      => $newVal,
            'is_required' => ($newVal === '1'),
            'message'     => 'Fitur input nomor HP sekarang ' . $statusText,
        ]);
    }

    public function destroyParticipant($id)
    {
        $participant = Participant::findOrFail($id);
        $phone = $participant->phone_number;
        $participant->delete();

        $log = "[" . now()->format('Y-m-d H:i:s') . "] Admin menghapus nomor peserta: " . $phone;
        Storage::append('admin_logs.txt', $log);

        return response()->json([
            'success' => true,
            'message' => "Nomor {$phone} berhasil dihapus dari database peserta.",
        ]);
    }

    public function resetParticipants()
    {
        $count = Participant::count();
        Participant::truncate();

        $log = "[" . now()->format('Y-m-d H:i:s') . "] Admin mereset seluruh data peserta ({$count} nomor dihapus).";
        Storage::append('admin_logs.txt', $log);

        return response()->json([
            'success' => true,
            'message' => "Seluruh data peserta ({$count} nomor) berhasil di-reset.",
        ]);
    }
}
