<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $fillable = [
        'phone_number',
        'quiz_id',
        'kategori',
        'soal',
        'jawaban_peserta',
        'status_jawaban',
        'doorprize',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }
}
