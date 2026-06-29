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

    public function getCaloriesAttribute()
    {
        return $this->product->calories_per_100g * $this->grams / 100;
    }

    public function getProteinAttribute()
    {
        return $this->product->protein_per_100g * $this->grams / 100;
    }

    public function getFatAttribute()
    {
        return $this->product->fat_per_100g * $this->grams / 100;
    }

    public function getCarbsAttribute()
    {
        return $this->product->carbs_per_100g * $this->grams / 100;
    }
}