<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeightEntry extends Model
{
    protected $fillable = [
        'user_id',
        'entry_date',
        'weight',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
