<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Services\ResumePdfService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Skill;
use App\Models\Certificate;
use App\Models\Project;
use App\Models\SocialLink;

class ContentController extends Controller
{
    private function config($module)
    {
        $configs = [
            'educations' => [
                'title' => 'Pendidikan',
                'model' => Education::class,
                'fields' => [
                    'institution' => ['label'=>'Institusi','type'=>'text','required'=>true],
                    'degree' => ['label'=>'Gelar','type'=>'text'],
                    'field_of_study' => ['label'=>'Bidang Studi','type'=>'text'],
                    'location' => ['label'=>'Lokasi','type'=>'text'],
                    'start_date' => ['label'=>'Tanggal Mulai','type'=>'date'],
                    'end_date' => ['label'=>'Tanggal Selesai','type'=>'date'],
                    'is_current' => ['label'=>'Masih Berlangsung','type'=>'checkbox'],
                    'description' => ['label'=>'Deskripsi','type'=>'textarea'],
                    'sort_order' => ['label'=>'Urutan','type'=>'number'],
                    'is_visible' => ['label'=>'Tampilkan','type'=>'checkbox'],
                ],
            ],
            'experiences' => [
                'title' => 'Pengalaman',
                'model' => Experience::class,
                'fields' => [
                    'company' => ['label'=>'Perusahaan/Instansi','type'=>'text','required'=>true],
                    'position' => ['label'=>'Jabatan','type'=>'text','required'=>true],
                    'employment_type' => ['label'=>'Jenis Pekerjaan','type'=>'text'],
                    'location' => ['label'=>'Lokasi','type'=>'text'],
                    'start_date' => ['label'=>'Tanggal Mulai','type'=>'date'],
                    'end_date' => ['label'=>'Tanggal Selesai','type'=>'date'],
                    'is_current' => ['label'=>'Masih Bekerja','type'=>'checkbox'],
                    'description' => ['label'=>'Deskripsi','type'=>'textarea'],
                    'sort_order' => ['label'=>'Urutan','type'=>'number'],
                    'is_visible' => ['label'=>'Tampilkan','type'=>'checkbox'],
                ],
            ],
            'skills' => [
                'title' => 'Keahlian',
                'model' => Skill::class,
                'fields' => [
                    'name' => ['label'=>'Nama Keahlian','type'=>'text','required'=>true],
                    'category' => ['label'=>'Kategori','type'=>'text'],
                    'proficiency' => ['label'=>'Tingkat Penguasaan (0-100)','type'=>'number'],
                    'sort_order' => ['label'=>'Urutan','type'=>'number'],
                    'is_visible' => ['label'=>'Tampilkan','type'=>'checkbox'],
                ],
            ],
            'certificates' => [
                'title' => 'Sertifikat',
                'model' => Certificate::class,
                'fields' => [
                    'title' => ['label'=>'Nama Sertifikat','type'=>'text','required'=>true],
                    'issuer' => ['label'=>'Penerbit','type'=>'text'],
                    'issue_date' => ['label'=>'Tanggal Terbit','type'=>'date'],
                    'expiry_date' => ['label'=>'Tanggal Kedaluwarsa','type'=>'date'],
                    'credential_id' => ['label'=>'ID Kredensial','type'=>'text'],
                    'credential_url' => ['label'=>'URL Verifikasi','type'=>'url'],
                    'file_path' => ['label'=>'File Sertifikat (PDF)','type'=>'file'],
                    'sort_order' => ['label'=>'Urutan','type'=>'number'],
                    'is_visible' => ['label'=>'Tampilkan','type'=>'checkbox'],
                ],
            ],
            'projects' => [
                'title' => 'Proyek / Portofolio',
                'model' => Project::class,
                'fields' => [
                    'title' => ['label'=>'Nama Proyek','type'=>'text','required'=>true],
                    'description' => ['label'=>'Deskripsi','type'=>'textarea'],
                    'role' => ['label'=>'Peran','type'=>'text'],
                    'technologies' => ['label'=>'Teknologi (pisahkan dengan koma)','type'=>'text'],
                    'image_path' => ['label'=>'Gambar Proyek','type'=>'image'],
                    'project_url' => ['label'=>'URL Proyek','type'=>'url'],
                    'repository_url' => ['label'=>'URL Repository','type'=>'url'],
                    'start_date' => ['label'=>'Tanggal Mulai','type'=>'date'],
                    'end_date' => ['label'=>'Tanggal Selesai','type'=>'date'],
                    'is_featured' => ['label'=>'Proyek Unggulan','type'=>'checkbox'],
                    'sort_order' => ['label'=>'Urutan','type'=>'number'],
                    'is_visible' => ['label'=>'Tampilkan','type'=>'checkbox'],
                ],
            ],
            'social-links' => [
                'title' => 'Media Sosial',
                'model' => SocialLink::class,
                'fields' => [
                    'platform' => ['label'=>'Platform','type'=>'text','required'=>true],
                    'label' => ['label'=>'Nama Tampilan','type'=>'text'],
                    'url' => ['label'=>'URL','type'=>'url','required'=>true],
                    'icon' => ['label'=>'Nama Ikon','type'=>'text'],
                    'sort_order' => ['label'=>'Urutan','type'=>'number'],
                    'is_visible' => ['label'=>'Tampilkan','type'=>'checkbox'],
                ],
            ],
        ];

        abort_unless(isset($configs[$module]), 404);
        return $configs[$module];
    }

    public function index($module)
    {
        $config = $this->config($module);
        $items = ($config['model'])::orderBy('sort_order')->latest()->paginate(10);

        return view('admin.content.index', compact('module', 'config', 'items'));
    }

    public function create($module)
    {
        $config = $this->config($module);
        $modelClass = $config['model'];
        $item = new $modelClass;

        return view('admin.content.form', compact('module', 'config', 'item'));
    }

    public function store(Request $request, $module)
    {
        $config = $this->config($module);
        $data = $this->validatedData($request, $config, $module);

        ($config['model'])::create($data);
        $pdfMessage = $this->refreshResumePdf();

        return redirect()->route('admin.content.index', $module)
            ->with('success', $config['title'].' berhasil ditambahkan.'.$pdfMessage);
    }

    public function edit($module, $id)
    {
        $config = $this->config($module);
        $item = ($config['model'])::findOrFail($id);

        return view('admin.content.form', compact('module', 'config', 'item'));
    }

    public function update(Request $request, $module, $id)
    {
        $config = $this->config($module);
        $item = ($config['model'])::findOrFail($id);
        $data = $this->validatedData($request, $config, $module, $item);

        $oldFiles = [];

        foreach (['image_path', 'file_path'] as $field) {
            if (isset($data[$field]) && $item->$field) {
                $oldFiles[$field] = $item->$field;
            }
        }

        $item->update($data);

        foreach ($oldFiles as $field => $oldPath) {
            if ($oldPath && $oldPath !== $item->$field) {
                Storage::disk('public')->delete($oldPath);
            }
        }

        $pdfMessage = $this->refreshResumePdf();

        return redirect()->route('admin.content.index', $module)
            ->with('success', $config['title'].' berhasil diperbarui.'.$pdfMessage);
    }

    public function destroy($module, $id)
    {
        $config = $this->config($module);
        $item = ($config['model'])::findOrFail($id);

        foreach (['image_path', 'file_path'] as $field) {
            if ($item->$field) {
                Storage::disk('public')->delete($item->$field);
            }
        }

        $item->delete();
        $pdfMessage = $this->refreshResumePdf();

        return back()->with('success', $config['title'].' berhasil dihapus.'.$pdfMessage);
    }

    private function refreshResumePdf(): string
    {
        $profile = Profile::where('is_published', true)->first()
            ?? Profile::first();

        if (! $profile) {
            return ' Profil belum tersedia; PDF akan dibuat setelah profil disimpan.';
        }

        try {
            app(ResumePdfService::class)->generate($profile);

            return ' PDF CV berhasil diperbarui otomatis.';
        } catch (\Throwable $e) {
            Log::error('Gagal memperbarui PDF CV setelah perubahan konten.', [
                'profile_id' => $profile->id,
                'exception' => $e->getMessage(),
            ]);

            return ' Namun PDF CV gagal diperbarui. Silakan periksa log aplikasi.';
        }
    }
    private function validatedData(Request $request, array $config, string $module, $item = null): array
    {
        $rules = [];

        foreach ($config['fields'] as $name => $field) {
            $rules[$name] = match ($field['type']) {
                'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
                'file' => 'nullable|file|mimes:pdf|max:10240',
                'url' => 'nullable|url|max:255',
                'date' => 'nullable|date',
                'number' => 'nullable|integer|min:0',
                'checkbox' => 'nullable|boolean',
                default => ($field['required'] ?? false ? 'required' : 'nullable').'|string|max:5000',
            };
        }

        $data = $request->validate($rules);

        foreach ($config['fields'] as $name => $field) {
            if ($field['type'] === 'checkbox') {
                $data[$name] = $request->boolean($name);
            }

            if (in_array($field['type'], ['image', 'file']) && $request->hasFile($name)) {

                $folder = $module.'/'.$name;
                $data[$name] = $request->file($name)->store($folder, 'public');
            }
        }

        if ($module === 'projects') {
            if (!$item || $item->title !== $data['title']) {
                $baseSlug = Str::slug($data['title']);
                $slug = $baseSlug;
                $counter = 2;
            
                while (Project::query()
                    ->where('slug', $slug)
                    ->when($item, fn ($query) => $query->where('id', '!=', $item->id))
                    ->exists()) {
                    $slug = $baseSlug . '-' . $counter;
                    $counter++;
                }
            
                $data['slug'] = $slug;
            }

            if (isset($data['technologies'])) {
                $data['technologies'] = array_values(array_filter(
                    array_map('trim', explode(',', $data['technologies']))
                ));
            }
        }

        return $data;
    }
}



