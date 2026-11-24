<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Services\ResumePdfService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ProfileController extends Controller
{
    public function edit()
    {
        $profile = Profile::first();

        $resumeFileExists = $profile?->resume_file
            && Storage::disk('public')->exists($profile->resume_file);

        $resumeSize = $resumeFileExists
            ? round(Storage::disk('public')->size($profile->resume_file) / 1024 / 1024, 2)
            : null;

        $resumeUpdatedAt = $resumeFileExists
            ? date('d M Y, H:i', Storage::disk('public')->lastModified($profile->resume_file))
            : null;

        return view('admin.profile.edit', compact(
            'profile',
            'resumeFileExists',
            'resumeSize',
            'resumeUpdatedAt'
        ));
    }

    public function update(Request $request, ResumePdfService $resumePdfService)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'headline' => 'nullable|string|max:255',
            'summary' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:30',
            'location' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'is_published' => 'nullable|boolean',
        ]);

        $profile = Profile::first() ?? new Profile;

        $oldPhoto = $profile->photo;

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')
                ->store('profiles', 'public');
        }

        $validated['is_published'] = $request->boolean('is_published');

        $profile->fill($validated);
        $profile->save();

        if ($request->hasFile('photo') &&
            $oldPhoto &&
            $oldPhoto !== $profile->photo) {
            Storage::disk('public')->delete($oldPhoto);
        }

        try {
            $resumePdfService->generate($profile);

            return back()->with(
                'success',
                'Profil berhasil disimpan dan PDF CV berhasil diperbarui otomatis.'
            );
        } catch (Throwable $e) {
            Log::error('Gagal membuat PDF CV otomatis.', [
                'profile_id' => $profile->id,
                'error' => $e->getMessage(),
            ]);

            return back()->with(
                'error',
                'Profil tersimpan, tetapi PDF CV gagal dibuat. Periksa log aplikasi.'
            );
        }
    }

    public function destroyResume()
    {
        return back()->with(
            'error',
            'PDF CV sekarang dibuat otomatis oleh sistem dan tidak perlu dihapus manual.'
        );
    }
}
