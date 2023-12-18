<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyProgram extends Model
{
    use HasFactory;

    protected $guard = ["id"];

    public function employee()
    {
        return $this->belongsTo(Employee::class, "mngr_id", "nik");
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, "faculty_id", "id");
    }

    public function students()
    {
        return $this->hasMany(Student::class, "study_program_id", "id");
    }
}
