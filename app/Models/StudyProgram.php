<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudyProgram extends Model
{
    use HasFactory;

    protected array $guard = ["id"];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, "mngr_id", "nik");
    }

    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class, "faculty_id", "id");
    }

    public function students()
    {
        return $this->hasMany(Student::class, "study_program_id", "id");
    }
}
