<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    /**
     * Relasi seluruh notifikasi pengguna.
     */
    public function notifications(): MorphMany
    {
        return $this->morphMany(
            DatabaseNotification::class,
            'notifiable'
        )->latest();
    }

    /**
     * Relasi notifikasi yang belum dibaca.
     */
    public function unreadNotifications(): MorphMany
    {
        return $this->morphMany(
            DatabaseNotification::class,
            'notifiable'
        )->whereNull('read_at')->latest();
    }

    /**
     * Relasi notifikasi yang sudah dibaca.
     */
    public function readNotifications(): MorphMany
    {
        return $this->morphMany(
            DatabaseNotification::class,
            'notifiable'
        )->whereNotNull('read_at')->latest();
    }
}
