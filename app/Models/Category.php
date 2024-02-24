<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected array $guard = ['id'];

    protected $fillable = ['name'];

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, 'category_id', 'id');
    }
}
