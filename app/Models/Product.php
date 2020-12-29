<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes;
    
    protected $primaryKey = 'product_id';

    protected $fillable =
    [
        "name",
        "content",
        "price",
        "price_new",
        "image",
        "image_alt_text",
        "tax_type",
        "tax"
    ];
}
