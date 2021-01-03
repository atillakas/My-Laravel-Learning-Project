<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory,SoftDeletes;
    
    // protected $primaryKey = 'product_id';

    protected $fillable =
    [
        "name",
        "slug",
        "content",
        "price",
        "price_new",
        "image",
        "image_alt_text",
        "tax_type",
        "tax"
    ];

    //generate slug before save on database
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::of($value)->slug('-');
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        //When the database makes an insert, update, or delete action removes all cache data.
        static::updated(function ($product) {
            Cache::flush();
        });
        static::created(function ($product) {
            Cache::flush();
        });
        static::deleted(function ($product) {
            Cache::flush();
        });
        
    }
}
