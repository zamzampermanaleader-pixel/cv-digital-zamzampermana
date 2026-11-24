<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Services\ResumePdfService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ResumeController extends Controller
{
    public function download(ResumePdfService $resumePdfService)
    {
        $profile = Profile::where('is_published', true)->first();

        abort_unless($profile, 404, 'Profil CV belum dipublikasikan.');

        try {
            // Selalu buat ulang agar unduhan menggunakan data paling baru.
            $resumePdfService->generate($profile);
            $profile->refresh();
        } catch (Throwable $e) {
            Log::error('Gagal membuat PDF CV saat proses unduhan.', [
                'profile_id' => $profile->id,
                'exception' => $e->getMessage(),
            ]);

            abort(503, 'PDF CV belum berhasil diperbarui. Silakan coba kembali.');
        }

        abort_unless(
            $profile->resume_file &&
            Storage::disk('public')->exists($profile->resume_file),
            404,
            'PDF CV belum berhasil dibuat.'
        );

        return Storage::disk('public')->download(
            $profile->resume_file,
            'CV-'.str($profile->full_name)->slug().'.pdf'
        );
    }
}