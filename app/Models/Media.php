<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'article_id',
    'collection',
    'disk',
    'path',
    'file_name',
    'mime_type',
    'size',
])]
class Media extends Model
{
    /**
     * Get the article that owns the media.
     */
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * Get the URL to serve this media file.
     */
    public function url(): string
    {
        return route('media.show', $this);
    }
}
