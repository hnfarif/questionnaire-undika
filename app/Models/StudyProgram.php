<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class StudyProgram extends Model
{
    use HasFactory;

    protected array $guard = ["id"];
    protected $with = ["semester"];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, "mngr_id", "nik");
    }

    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class, "faculty_id", "id");
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class, "study_program_id", "id");
    }

    public function semester(): HasOne
    {
        return $this->hasOne(Semester::class, 'study_program_id', 'id');
    }
}
