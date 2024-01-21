<?php

namespace App\Models;


use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Questionnaire extends Model
{
    use HasFactory;

    protected array $guard = ['id'];

    protected $fillable = [
        'study_program_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'semester'
    ];

    public function studyProgram(): BelongsTo
    {
        return $this->belongsTo(StudyProgram::class, 'study_program_id', 'id');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }

    public function scopeSemester(Builder $query, string $semester): void
    {
        $query->whereSemester($semester);
    }

    public function scopeStudyProgram(Builder $query, array $studyPrograms): void
    {
        $query->whereIn("study_program_id", $studyPrograms);
    }
}
