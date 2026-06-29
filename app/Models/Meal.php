<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    protected $fillable = [
        'user_id',
        'meal_date',
        'meal_type',
        'name',
        'is_planned',
        'is_eaten',
        'eaten_at',
    ];

    protected $casts = [
        'meal_date' => 'date',
        'is_planned' => 'boolean',
        'is_eaten' => 'boolean',
        'eaten_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(MealItem::class);
    }
}
