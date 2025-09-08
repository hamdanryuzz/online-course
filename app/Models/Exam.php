<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = [
        'course_id',
        'question',
        'options', // simpan dalam JSON
        'answer',
    ];

    protected $casts = [
        'options' => 'array', // <- ini penting
    ];


    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
