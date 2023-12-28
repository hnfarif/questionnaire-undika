<?php

namespace App\Models;

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
        'end_date'
    ];
}
