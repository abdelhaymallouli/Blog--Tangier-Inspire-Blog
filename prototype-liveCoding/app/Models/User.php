<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property int               $user_id
 * @property string            $username
 * @property string            $email
 * @property string|null       $password_hash
 * @property string            $role          // admin|writer
 * @property \Carbon\Carbon|null $email_verified_at
 * @property \Carbon\Carbon    $created_at
 * @property \Carbon\Carbon    $updated_at
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /** -----------------------------------------------------------------
     *  Primary key (the column is called `user_id` in the DB)
     *  ----------------------------------------------------------------- */
    protected $primaryKey = 'user_id';

    /** -----------------------------------------------------------------
     *  Mass-assignable columns
     *  ----------------------------------------------------------------- */
    protected $fillable = [
        'username',
        'email',
        'password_hash',
        'role',
    ];

    /** -----------------------------------------------------------------
     *  Hidden when the model is converted to array/JSON
     *  ----------------------------------------------------------------- */
    protected $hidden = [
        'password_hash',
        'remember_token',
    ];

    /** -----------------------------------------------------------------
     *  Attribute casting
     *  ----------------------------------------------------------------- */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'role'              => 'string',
        ];
    }

    /** -----------------------------------------------------------------
     *  Relationships
     *  ----------------------------------------------------------------- */
    public function articles()
    {
        return $this->hasMany(Article::class, 'author_id', 'user_id');
    }

    /** -----------------------------------------------------------------
     *  Helper – is the user an admin?
     *  ----------------------------------------------------------------- */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}