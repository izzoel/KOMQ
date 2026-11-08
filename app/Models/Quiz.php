<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = [
        'soal',
        'pilihanA',
        'pilihanB',
        'pilihanC',
        'pilihanD',
        'jawaban',
        'kategori',
    ];
}
