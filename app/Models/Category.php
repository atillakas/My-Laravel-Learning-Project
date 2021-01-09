<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    use HasFactory, SoftDeletes, NodeTrait;
    // use HasFactory, SoftDeletes;

    protected $fillable =
    [
        "name",
        "slug",
        "description",
        "image_alt_text",
        "image",
        "parent_id",
        "deleted_at"
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
        static::updated(function ($category) {
            Cache::flush();
        });
        static::created(function ($category) {
            Cache::flush();
        });
        static::deleted(function ($category) {
            Cache::flush();
        });
        
    }


    /**
     * The product that belong to the category.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class)->as('productCategory')->withPivot('updated_at', 'created_at');
    }

}
