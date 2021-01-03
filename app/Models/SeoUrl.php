<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SeoUrl extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'seo_url_id';

    protected $fillable =
    [
        "id",
        "type",
        "slug",
    ];
}
