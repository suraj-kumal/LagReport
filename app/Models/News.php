<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class News extends Model
{
    //mass alignment
    protected $fillable = [
        "headline",
        "slug",
        "byline",
        "lead",
        "body",
        "conclusion",
        "cover_image",
        "headline_news",
        "publish",
        "seo_title",
        "seo_description",
        "seo_keywords",
    ];

    //casting
    protected $casts = [
        "headline_news" => "boolean",
        "publish" => "boolean",
    ];

    //auto generate slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($news) {
            $news->slug = Str::slug($news->headline);
        });

        static::updating(function ($news) {
            $news->slug = Str::slug($news->headline);
        });
    }

    public function scopePublished($query)
    {
        return $query->where("publish", true);
    }

    // Only headline news
    public function scopeHeadline($query)
    {
        return $query->where("headline_news", true);
    }
}
