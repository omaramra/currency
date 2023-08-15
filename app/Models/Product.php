<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'barcode',
        'category_id',
        'description',
        'image',
        'keywords',
        'active',
        'currency_id',
        'price'

    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }
}
