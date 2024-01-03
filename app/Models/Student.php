<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    use HasFactory;

    protected $primaryKey = 'nim';

    protected $fillable = [
        'nim',
        'study_program_id',
        'name'
    ];

    public function studyProgram(): BelongsTo
    {
        return $this->belongsTo(StudyProgram::class, 'study_program_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nim', 'id');
    }
}
