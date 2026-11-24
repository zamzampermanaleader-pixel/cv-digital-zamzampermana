<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Message;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard administrator.
     */
    public function index()
    {
        $user = Auth::user();

        // Aktivitas pesan selama 7 hari terakhir.
        $activity = collect(range(6, 0))->map(function ($daysAgo) {
            $date = now()->subDays($daysAgo);

            return [
                'label' => $date->translatedFormat('D'),
                'date' => $date->format('d M'),
                'count' => Message::whereDate(
                    'created_at',
                    $date->toDateString()
                )->count(),
            ];
        });

        // Statistik dashboard.
        $statistics = [
            'profileCount' => Profile::count(),
            'educationCount' => Education::count(),
            'experienceCount' => Experience::count(),
            'skillCount' => Skill::count(),
            'certificateCount' => Certificate::count(),
            'projectCount' => Project::count(),
            'messageCount' => Message::count(),
            'unreadMessages' => Message::where('is_read', false)->count(),
        ];

        // Pesan terbaru.
        $recentMessages = Message::latest()
            ->take(5)
            ->get();

        // ID administrator yang sedang login.
        $userId = Auth::user()?->id;

        // Statistik notifikasi yang belum dibaca.
        $unreadNotifications = DatabaseNotification::where(
            'notifiable_type',
            \App\Models\User::class
        )
            ->where('notifiable_id', $userId)
            ->whereNull('read_at')
            ->count();

        // Lima notifikasi terbaru.
        $recentNotifications = DatabaseNotification::where(
            'notifiable_type',
            \App\Models\User::class
        )
            ->where('notifiable_id', $userId)
            ->latest()
            ->take(5)
            ->get();
        // Data yang dikirim ke dashboard.
        return view('admin.dashboard', array_merge(
            $statistics,
            [
                'recentMessages' => $recentMessages,
                'unreadNotifications' => $unreadNotifications,
                'recentNotifications' => $recentNotifications,
                'activity' => $activity,
            ]
        ));
    }
}
