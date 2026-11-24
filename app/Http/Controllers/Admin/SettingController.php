<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function edit()
    {
        $settings = Setting::all()->keyBy('key');

        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_title' => 'required|string|max:255',
            'site_description' => 'nullable|string|max:1000',
            'site_author' => 'nullable|string|max:255',
            'seo_keywords' => 'nullable|string|max:500',
            'social_title' => 'nullable|string|max:255',
            'social_description' => 'nullable|string|max:500',
            'contact_email' => 'nullable|email|max:255',
            'whatsapp_number' => 'nullable|string|max:30',
            'footer_text' => 'nullable|string|max:500',

            'organizations_text' => 'nullable|string|max:10000',
            'hobbies_text' => 'nullable|string|max:5000',
            'languages_text' => 'nullable|string|max:5000',

            'site_logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'site_favicon' => 'nullable|image|mimes:png|max:1024',
            'og_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $groups = [
            'site_title' => 'general',
            'site_description' => 'seo',
            'site_author' => 'seo',
            'seo_keywords' => 'seo',
            'social_title' => 'seo',
            'social_description' => 'seo',
            'contact_email' => 'contact',
            'whatsapp_number' => 'contact',
            'footer_text' => 'general',
        ];

        foreach ($groups as $key => $group) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $validated[$key] ?? null, 'group' => $group]
            );
        }

        $organizations = collect(preg_split('/\r\n|\r|\n/', $validated['organizations_text'] ?? ''))
            ->map(function ($line) {
                $parts = array_map('trim', explode('|', $line, 2));

                return count($parts) === 2 && $parts[0] !== '' && $parts[1] !== ''
                    ? ['jabatan' => $parts[0], 'nama' => $parts[1]]
                    : null;
            })
            ->filter()
            ->values()
            ->all();

        foreach ([
            'organizations' => $organizations,
            'hobbies' => collect(preg_split('/\r\n|\r|\n/', $validated['hobbies_text'] ?? ''))
                ->map(fn ($item) => trim($item))
                ->filter()
                ->values()
                ->all(),
            'languages' => collect(preg_split('/\r\n|\r|\n/', $validated['languages_text'] ?? ''))
                ->map(fn ($item) => trim($item))
                ->filter()
                ->values()
                ->all(),
        ] as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => json_encode($value, JSON_UNESCAPED_UNICODE), 'group' => 'cv']
            );
        }

        foreach ([
            'site_logo' => 'media',
            'site_favicon' => 'media',
            'og_image' => 'seo',
        ] as $field => $group) {
            if (! $request->hasFile($field)) {
                continue;
            }

            $oldFile = Setting::where('key', $field)->value('value');
            $newFile = $request->file($field)->store('site', 'public');

            if (! $newFile) {
                return back()->withInput()->withErrors([
                    $field => 'Gagal menyimpan file. Silakan coba kembali.',
                ]);
            }

            Setting::updateOrCreate(
                ['key' => $field],
                ['value' => $newFile, 'group' => $group]
            );

            if ($oldFile && Storage::disk('public')->exists($oldFile)) {
                Storage::disk('public')->delete($oldFile);
            }
        }

        return redirect()
            ->route('admin.settings.edit')
            ->with('success', 'Pengaturan website dan data CV berhasil diperbarui.');
    }
}
