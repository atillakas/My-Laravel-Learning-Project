<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    use HasFactory, SoftDeletes, NodeTrait;
    // use HasFactory, SoftDeletes;

    protected $fillable =
    [
        "name",
        "description",
        "parent_id"
    ];

    //generate slug before save on database
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::of($value)->slug('-');
    }

    /**
 * Get the user's full name.
 *
 * @return string
 */
// public function getNameAttribute()
// {
//     return $this->slug . " denemeleri";
// }
}
