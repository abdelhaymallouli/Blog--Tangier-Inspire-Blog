<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $primaryKey = 'article_id';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'views',
        'status',
        'author_id',
        'category_id',
        'published_at',
        'is_moderated',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_moderated' => 'boolean',
    ];

    // 🔗 Relationships
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id', 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'article_tag', 'article_id', 'tag_id');
    }

    // 🔢 Increment views atomically
    public function incrementViews()
    {
        $this->increment('views');
    }

    // ✅ Optional: Scope for filtering published articles
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
