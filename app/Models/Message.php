<?php

namespace App\Models;

use App\Notifications\NewMessageNotification;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'is_read',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
            'read_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::created(function (Message $message) {
            User::where('is_admin', true)
                ->get()
                ->each(function (User $admin) use ($message) {
                    $admin->notify(new NewMessageNotification($message));
                });
        });
    }
}
