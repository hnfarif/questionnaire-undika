<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Submission extends Model
{
    use HasFactory;

    protected array $guard = ['id'];

    protected $fillable = [
        'questionnaire_id',
        'nim'
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'nim', 'nim');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class, 'submission_id', 'id');
    }
}
