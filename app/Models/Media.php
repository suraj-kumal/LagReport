<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        "filename",
        "stored_name",
        "url",
        "mime_type",
        "size",
    ];
}
