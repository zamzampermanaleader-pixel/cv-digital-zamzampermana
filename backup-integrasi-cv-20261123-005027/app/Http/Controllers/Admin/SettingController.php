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

        foreach ($validated as $key => $value) {
            if (in_array($key, ['site_logo', 'site_favicon', 'og_image'])) {
                continue;
            }

            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $value,
                    'group' => $groups[$key] ?? 'general',
                ]
            );
        }

        $fileGroups = [
            'site_logo' => 'media',
            'site_favicon' => 'media',
            'og_image' => 'seo',
        ];

        foreach ($fileGroups as $field => $group) {
            if (! $request->hasFile($field)) {
                continue;
            }

            $oldFile = Setting::where('key', $field)->value('value');

            $newFile = $request->file($field)->store('site', 'public');

            if (! $newFile) {
                return back()
                    ->withInput()
                    ->withErrors([$field => 'Gagal menyimpan file. Silakan coba kembali.']);
            }

            Setting::updateOrCreate(
                ['key' => $field],
                [
                    'value' => $newFile,
                    'group' => $group,
                ]
            );

            if ($oldFile && Storage::disk('public')->exists($oldFile)) {
                Storage::disk('public')->delete($oldFile);
            }
        }

        return redirect()
            ->route('admin.settings.edit')
            ->with('success', 'Pengaturan website berhasil diperbarui.');
    }
}
