<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecipeItem extends Model
{
    protected $fillable = [
        'recipe_id',
        'product_id',
        'grams',
    ];

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
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