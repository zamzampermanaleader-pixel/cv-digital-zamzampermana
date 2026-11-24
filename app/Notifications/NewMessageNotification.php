<?php

namespace App\Notifications;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewMessageNotification extends Notification
{
    use Queueable;

    public function __construct(public Message $message)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'Pesan baru dari pengunjung',
            'message_id' => $this->message->id,
            'sender_name' => $this->message->name,
            'sender_email' => $this->message->email,
            'subject' => $this->message->subject ?: 'Tanpa subjek',
            'created_at' => $this->message->created_at?->toDateTimeString(),
        ];
    }
}
