<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Employee extends Model
{
    use HasFactory;

    protected $primaryKey = 'nik';
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'nik');
    }

    public function studyProgram(): HasOne
    {
        return $this->hasOne(StudyProgram::class,'mngr_id','nik');
    }

    public function faculty(): HasOne
    {
        return $this->hasOne(Faculty::class,'mngr_id','nik');
    }
}
