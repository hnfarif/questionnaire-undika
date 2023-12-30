<?php

namespace App\Models;


use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function studyProgram()
    {
        return $this->belongsTo(StudyProgram::class, 'study_program_id', 'id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function scopeSemester(Builder $query, string $semester): void
    {
        $query->whereSemester($semester);
    }
}
