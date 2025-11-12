<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id';
    protected $fillable = ['username', 'name', 'email', 'password', 'role_id'];

    public function role() {
        return $this->belongsTo(Role::class);
    }

    public function articles() {
        return $this->hasMany(Article::class, 'author_id');
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function favorites() {
        return $this->belongsToMany(Article::class, 'favorites', 'user_id', 'article_id')->using(Favorite::class);
    }
}
