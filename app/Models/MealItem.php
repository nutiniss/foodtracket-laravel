<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MealItem extends Model
{
    protected $fillable = [
        'meal_id',
        'product_id',
        'grams',
    ];

    public function meal()
    {
        return $this->belongsTo(Meal::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
