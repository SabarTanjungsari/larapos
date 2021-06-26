<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $rules = [
        'code' => 'required|string|max:10|unique:products',
        'name' => 'required|string|max:100',
        'description' => 'nullable|string|max:100',
        'stock' => 'required|integer',
        'price' => 'required|integer',
        'category_id' => 'required|exists:categories,id',
        #'photo' => 'nullable|image|mimes:jpg,png,jpeg'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
