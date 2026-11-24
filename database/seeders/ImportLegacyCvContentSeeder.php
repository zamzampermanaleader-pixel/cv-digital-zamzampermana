<?php

namespace Database\Seeders;

use App\Models\Education;
use App\Models\Experience;
use App\Models\Skill;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImportLegacyCvContentSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            // PENDIDIKAN
            $educations = [
                [
                    'institution' => 'MAN 1 Kota Tasikmalaya',
                    'degree' => 'Pendidikan Menengah Atas',
                    'field_of_study' => 'Ilmu Pengetahuan Alam (IPA)',
                    'description' => 'Tahun lulus: 2024',
                    'sort_order' => 1,
                ],
                [
                    'institution' => 'MTs Bahrul Ulum',
                    'degree' => 'Pendidikan Menengah Pertama',
                    'field_of_study' => null,
                    'description' => 'Tahun lulus: 2021',
                    'sort_order' => 2,
                ],
            ];

            foreach ($educations as $item) {
                Education::updateOrCreate(
                    ['institution' => $item['institution']],
                    array_merge($item, [
                        'is_current' => false,
                        'is_visible' => true,
                    ])
                );
            }

            // PENGALAMAN
            $experiences = [
                [
                    'company' => 'Tasikmalaya Hitz',
                    'position' => 'Peserta Magang',
                    'employment_type' => 'Magang',
                    'description' => 'Membuat tulisan berupa berita, artikel, jurnal, dan novel.',
                    'sort_order' => 1,
                ],
                [
                    'company' => 'DICO',
                    'position' => 'Peserta Magang',
                    'employment_type' => 'Magang',
                    'description' => 'Membuat poster, mendesain banner, serta melakukan penyuntingan foto dan video.',
                    'sort_order' => 2,
                ],
            ];

            foreach ($experiences as $item) {
                Experience::updateOrCreate(
                    [
                        'company' => $item['company'],
                        'position' => $item['position'],
                    ],
                    array_merge($item, [
                        'is_current' => false,
                        'is_visible' => true,
                    ])
                );
            }

            // KEAHLIAN
            $skills = [
                ['name' => 'Desain Grafis CorelDRAW', 'category' => 'Desain Grafis'],
                ['name' => 'Desain UI/UX', 'category' => 'Desain Digital'],
                ['name' => 'Pengembangan Website', 'category' => 'Teknologi Informasi'],
                ['name' => 'Analisis Data', 'category' => 'Teknologi Informasi'],
                ['name' => 'Kerja Sama Tim', 'category' => 'Soft Skill'],
            ];

            foreach ($skills as $index => $item) {
                Skill::updateOrCreate(
                    ['name' => $item['name']],
                    array_merge($item, [
                        'sort_order' => $index + 1,
                        'is_visible' => true,
                    ])
                );
            }

            // PORTOFOLIO
            $projects = [
                [
                    'title' => 'Desain Poster Masyarakat',
                    'slug' => 'desain-poster-masyarakat',
                    'description' => 'Karya desain poster untuk menyampaikan informasi kepada masyarakat.',
                    'role' => 'Desain Grafis',
                    'technologies' => [],
                    'sort_order' => 1,
                ],
                [
                    'title' => 'Desain Konten Media Sosial',
                    'slug' => 'desain-konten-media-sosial',
                    'description' => 'Pembuatan desain visual untuk kebutuhan publikasi dan media sosial.',
                    'role' => 'Desain Grafis',
                    'technologies' => [],
                    'sort_order' => 2,
                ],
            ];

            foreach ($projects as $item) {
                Project::updateOrCreate(
                    ['slug' => $item['slug']],
                    array_merge($item, [
                        'is_featured' => false,
                        'is_visible' => true,
                    ])
                );
            }
        });

        $this->command->info('Impor konten CV selesai.');
    }
}