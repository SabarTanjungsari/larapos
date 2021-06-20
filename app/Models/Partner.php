<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }
}
