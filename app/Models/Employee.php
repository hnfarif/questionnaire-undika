<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $primaryKey = 'nik';
    public function user()
    {
        return $this->belongsTo(User::class, 'nik', 'id');
    }

    public function studyProgram()
    {
        return $this->hasOne(StudyProgram::class, 'mngr_id', 'nik');
    }

    public function faculty()
    {
        return $this->hasOne(Faculty::class, 'mngr_id', 'nik');
    }
}
