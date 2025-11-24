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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->string('soal');
            $table->string('pilihanA');
            $table->string('pilihanB');
            $table->string('pilihanC');
            $table->string('pilihanD');
            $table->string('jawaban');
            $table->string('kategori');
            $table->timestamps();
        });
    }

    /**
    * Reverse the migrations.
    */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
