<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman manajemen profil.
     */
    public function edit()
    {
        $profile = Profile::first();

        if (! $profile) {
            $profile = Profile::create([
                'full_name' => 'Nama Anda',
                'is_published' => true,
            ]);
        }

        $resumeFileExists = false;
        $resumeSize = 0;
        $resumeUpdatedAt = '-';

        if (
            $profile->resume_file &&
            Storage::disk('public')->exists($profile->resume_file)
        ) {
            $resumeFileExists = true;

            $fileSize = Storage::disk('public')->size(
                $profile->resume_file
            );

            $resumeSize = round($fileSize / 1048576, 2);

            $lastModified = Storage::disk('public')->lastModified(
                $profile->resume_file
            );

            $resumeUpdatedAt = date(
                'd-m-Y H:i',
                $lastModified
            );
        }

        return view('admin.profile.edit', compact(
            'profile',
            'resumeFileExists',
            'resumeSize',
            'resumeUpdatedAt'
        ));
    }

    /**
     * Menyimpan perubahan profil.
     */
    public function update(Request $request)
    {
        $profile = Profile::first();

        if (! $profile) {
            $profile = new Profile;
        }

        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'headline' => ['nullable', 'string', 'max:255'],
            'summary' => ['nullable', 'string'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'location' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],

            'photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'resume_file' => [
                'nullable',
                'file',
                'mimes:pdf',
                'max:10240',
            ],

            'is_published' => ['nullable', 'boolean'],
        ]);

        $oldPhoto = $profile->photo;
        $oldResume = $profile->resume_file;

        unset($validated['photo'], $validated['resume_file']);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')
                ->store('profiles/photos', 'public');
        }

        if ($request->hasFile('resume_file')) {
            $validated['resume_file'] = $request->file('resume_file')
                ->store('profiles/resumes', 'public');
        }

        $validated['is_published'] = $request->boolean('is_published');

        $profile->fill($validated);
        $profile->save();

        // Hapus foto lama setelah penyimpanan berhasil.
        if (
            isset($validated['photo']) &&
            $oldPhoto &&
            Storage::disk('public')->exists($oldPhoto)
        ) {
            Storage::disk('public')->delete($oldPhoto);
        }

        // Hapus CV lama setelah penyimpanan berhasil.
        if (
            isset($validated['resume_file']) &&
            $oldResume &&
            Storage::disk('public')->exists($oldResume)
        ) {
            Storage::disk('public')->delete($oldResume);
        }

        return redirect()
            ->route('admin.profile.edit')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Menghapus dokumen CV.
     */
    public function deleteResume()
    {
        $profile = Profile::first();

        abort_unless($profile, 404, 'Profil tidak ditemukan.');

        if ($profile->resume_file) {
            if (Storage::disk('public')->exists($profile->resume_file)) {
                Storage::disk('public')->delete($profile->resume_file);
            }

            $profile->update([
                'resume_file' => null,
            ]);
        }

        return redirect()
            ->route('admin.profile.edit')
            ->with('success', 'Dokumen CV berhasil dihapus.');
    }
}
