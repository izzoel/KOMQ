<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('participants', function (Blueprint $table) {
            if (Schema::hasColumn('participants', 'ip_address')) {
                $table->dropColumn('ip_address');
            }

            $table->unsignedBigInteger('quiz_id')->nullable()->after('phone_number');
            $table->string('kategori')->nullable()->after('quiz_id');
            $table->text('soal')->nullable()->after('kategori');
            $table->string('jawaban_peserta')->nullable()->after('soal');
            $table->string('status_jawaban')->nullable()->after('jawaban_peserta');
            $table->string('doorprize')->nullable()->after('status_jawaban');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('participants', function (Blueprint $table) {
            $table->dropColumn([
                'quiz_id',
                'kategori',
                'soal',
                'jawaban_peserta',
                'status_jawaban',
                'doorprize',
            ]);

            $table->string('ip_address')->nullable()->after('phone_number');
        });
    }
};
