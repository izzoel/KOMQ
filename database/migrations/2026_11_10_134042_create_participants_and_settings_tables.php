<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tabel Data Peserta Kuis berdasarkan Nomor HP
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->string('phone_number')->unique()->index();
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });

        // Tabel Pengaturan Global Aplikasi (Key-Value)
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique()->index();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Masukkan konfigurasi awal: Wajib input nomor HP (default: 1 = aktif)
        DB::table('settings')->insert([
            'key' => 'require_phone',
            'value' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participants');
        Schema::dropIfExists('settings');
    }
};
