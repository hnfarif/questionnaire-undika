<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    protected array $guard = ["id"];

    public function employee(){
        return $this->belongsTo(Employee::class, "mngr_id", "nik");
    }

    public function studyPrograms(){
        return $this->hasMany(StudyProgram::class, "faculty_id", "id");
    }
}
