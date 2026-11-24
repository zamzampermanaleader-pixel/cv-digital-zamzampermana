<?php

namespace App\Services;

use App\Models\Certificate;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use App\Models\SocialLink;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class ResumePdfService
{
    public function generate(Profile $profile): string
    {
        $data = [
            'profile' => $profile,
            'educations' => Education::where('is_visible', true)
                ->orderBy('sort_order')->orderByDesc('start_date')->get(),
            'experiences' => Experience::where('is_visible', true)
                ->orderBy('sort_order')->orderByDesc('start_date')->get(),
            'skills' => Skill::where('is_visible', true)
                ->orderBy('sort_order')->get(),
            'certificates' => Certificate::where('is_visible', true)
                ->orderBy('sort_order')->orderByDesc('issue_date')->get(),
            'projects' => Project::where('is_visible', true)
                ->orderBy('sort_order')->orderByDesc('is_featured')->get(),
            'socialLinks' => SocialLink::where('is_visible', true)
                ->orderBy('sort_order')->get(),
            'photoData' => $this->photoData($profile),
        ];

        $pdf = Pdf::loadView('pdf.resume', $data)
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isRemoteEnabled' => false,
                'isHtml5ParserEnabled' => true,
                'defaultFont' => 'DejaVu Sans',
            ]);

        $path = 'resumes/cv-'.$profile->id.'.pdf';

        Storage::disk('public')->put($path, $pdf->output());

        $profile->forceFill([
            'resume_file' => $path,
        ])->saveQuietly();

        return $path;
    }

    private function photoData(Profile $profile): ?string
    {
        if (! $profile->photo ||
            ! Storage::disk('public')->exists($profile->photo)) {
            return null;
        }

        $mime = Storage::disk('public')->mimeType($profile->photo);

        if (! in_array($mime, ['image/jpeg', 'image/png', 'image/webp'], true)) {
            return null;
        }

        return 'data:'.$mime.';base64,'.
            base64_encode(Storage::disk('public')->get($profile->photo));
    }
}
