<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return view('admin.notifications.index', [
            'notifications' => $user->notifications()->latest()->paginate(15),
            'totalNotifications' => $user->notifications()->count(),
            'unreadCount' => $user->unreadNotifications()->count(),
        ]);
    }

    public function read(string $id): RedirectResponse
    {
        $notification = auth()->user()
            ->notifications()
            ->whereKey($id)
            ->firstOrFail();

        if (!$notification->read_at) {
            $notification->markAsRead();
        }

        $messageId = $notification->data['message_id'] ?? null;

        if ($messageId) {
            $message = Message::find($messageId);

            if ($message) {
                return redirect()->route('admin.messages.show', $message->id);
            }
        }

        return redirect()
            ->route('admin.notifications.index')
            ->with('success', 'Notifikasi telah ditandai sudah dibaca.');
    }

    public function readAll(): RedirectResponse
    {
        auth()->user()
            ->unreadNotifications()
            ->update(['read_at' => now()]);

        return redirect()
            ->route('admin.notifications.index')
            ->with('success', 'Semua notifikasi berhasil ditandai sudah dibaca.');
    }
}
