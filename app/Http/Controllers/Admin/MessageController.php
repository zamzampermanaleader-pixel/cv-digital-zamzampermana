<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $status = $request->query('status', 'all');

        if (!in_array($status, ['all', 'unread', 'read'], true)) {
            $status = 'all';
        }

        $query = Message::query();

        if ($search !== '') {
            $query->where(function ($builder) use ($search) {
                $builder->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            });
        }

        if ($status === 'unread') {
            $query->where('is_read', false);
        } elseif ($status === 'read') {
            $query->where('is_read', true);
        }

        return view('admin.messages.index', [
            'messages' => $query->latest()->paginate(15)->withQueryString(),
            'search' => $search,
            'status' => $status,
            'totalMessages' => Message::count(),
            'unreadMessages' => Message::where('is_read', false)->count(),
            'readMessages' => Message::where('is_read', true)->count(),
        ]);
    }

    public function show(int $id)
    {
        $message = Message::findOrFail($id);

        if (!$message->is_read) {
            $message->forceFill([
                'is_read' => true,
                'read_at' => now(),
            ])->save();
        }

        return view('admin.messages.show', compact('message'));
    }

    public function destroy(int $id)
    {
        $message = Message::findOrFail($id);
        $message->delete();

        return redirect()
            ->route('admin.messages.index')
            ->with('success', 'Pesan berhasil dihapus.');
    }
}
