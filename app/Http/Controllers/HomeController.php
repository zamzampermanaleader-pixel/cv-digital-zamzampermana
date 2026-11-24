<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Message;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Setting;
use App\Models\Skill;
use App\Models\SocialLink;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman utama CV Digital.
     */
    public function index()
    {
        // Profil hanya ditampilkan jika sudah dipublikasikan.
        $profile = Profile::where('is_published', true)->first();

        // Pendidikan.
        $educations = Education::query()
            ->where('is_visible', true)
            ->orderBy('sort_order')
            ->orderByDesc('start_date')
            ->get();

        // Pengalaman kerja.
        $experiences = Experience::query()
            ->where('is_visible', true)
            ->orderBy('sort_order')
            ->orderByDesc('start_date')
            ->get();

        // Keahlian.
        $skills = Skill::query()
            ->where('is_visible', true)
            ->orderBy('sort_order')
            ->get();

        // Sertifikat.
        $certificates = Certificate::query()
            ->where('is_visible', true)
            ->orderBy('sort_order')
            ->orderByDesc('issue_date')
            ->get();

        // Proyek.
        $projects = Project::query()
            ->where('is_visible', true)
            ->orderBy('sort_order')
            ->orderByDesc('is_featured')
            ->get();

        // Media sosial.
        $socialLinks = SocialLink::query()
            ->where('is_visible', true)
            ->orderBy('sort_order')
            ->get();

        // Pengaturan website.
        $settings = Setting::query()
            ->get()
            ->keyBy('key');

        return view('welcome', compact(
            'profile',
            'educations',
            'experiences',
            'skills',
            'certificates',
            'projects',
            'socialLinks',
            'settings'
        ));
    }

    /**
     * Menyimpan pesan dari formulir kontak.
     */
    public function contact(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        Message::create($data);

        return redirect()
            ->route('home')
            ->with('contact_success', 'Pesan berhasil dikirim. Terima kasih!');
    }
}
