<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    public function studyProgram()
    {
        return $this->belongsTo(StudyProgram::class, 'study_program_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'nim', 'id');
    }
}
