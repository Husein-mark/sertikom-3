<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price_per_student',
        'min_students',
        'duration',
        'description',
        'features',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price_per_student' => 'integer',
        'min_students' => 'integer',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
