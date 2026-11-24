<?php

namespace App\Providers;

use App\Models\Certificate;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use App\Models\SocialLink;
use App\Services\ResumePdfService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Throwable;

class ResumePdfServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $models = [
            Education::class,
            Experience::class,
            Skill::class,
            Certificate::class,
            Project::class,
            SocialLink::class,
        ];

        foreach ($models as $model) {
            $model::saved(function (): void {
                $this->regenerateAfterCommit();
            });

            $model::deleted(function (): void {
                $this->regenerateAfterCommit();
            });
        }
    }

    private function regenerateAfterCommit(): void
    {
        DB::afterCommit(function (): void {
            try {
                $profile = Profile::query()
                    ->where('is_published', true)
                    ->first();

                if (! $profile) {
                    return;
                }

                app(ResumePdfService::class)->generate($profile);

                Log::info('PDF CV berhasil diperbarui otomatis.');
            } catch (Throwable $exception) {
                Log::error('Gagal memperbarui PDF CV otomatis.', [
                    'message' => $exception->getMessage(),
                ]);
            }
        });
    }
}