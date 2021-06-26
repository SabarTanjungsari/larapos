<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $rules = [
        'name' => 'required|string',
        'email' => 'required|email',
        'address' => 'required|string',
        'phone' => 'required|integer',
        #'photo' => 'nullable|image|mimes:jpg,png,jpeg'
    ];
}
