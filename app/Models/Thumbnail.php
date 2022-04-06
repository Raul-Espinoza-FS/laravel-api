<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Thumbnail extends Model
{
    use HasFactory;

    /**
     * Get the user that owns the phone.
     */
    public function post()
    {
        return $this->hasOne(Post::class);
    }

    protected function url(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Storage::disk('public')->url($value)
        );
    }
}
