
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Tabel education
        |--------------------------------------------------------------------------
        | Model Education menggunakan tabel education (singular).
        */
        if (Schema::hasTable('education')) {
            Schema::table('education', function (Blueprint $table) {
                if (! Schema::hasColumn('education', 'institution')) {
                    $table->string('institution')->nullable();
                }
                if (! Schema::hasColumn('education', 'degree')) {
                    $table->string('degree')->nullable();
                }
                if (! Schema::hasColumn('education', 'field_of_study')) {
                    $table->string('field_of_study')->nullable();
                }
                if (! Schema::hasColumn('education', 'location')) {
                    $table->string('location')->nullable();
                }
                if (! Schema::hasColumn('education', 'start_date')) {
                    $table->date('start_date')->nullable();
                }
                if (! Schema::hasColumn('education', 'end_date')) {
                    $table->date('end_date')->nullable();
                }
                if (! Schema::hasColumn('education', 'is_current')) {
                    $table->boolean('is_current')->default(false);
                }
                if (! Schema::hasColumn('education', 'description')) {
                    $table->text('description')->nullable();
                }
                if (! Schema::hasColumn('education', 'sort_order')) {
                    $table->integer('sort_order')->default(0);
                }
                if (! Schema::hasColumn('education', 'is_visible')) {
                    $table->boolean('is_visible')->default(true);
                }
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Tabel experiences
        |--------------------------------------------------------------------------
        */
        if (Schema::hasTable('experiences')) {
            Schema::table('experiences', function (Blueprint $table) {
                if (! Schema::hasColumn('experiences', 'company')) {
                    $table->string('company')->nullable();
                }
                if (! Schema::hasColumn('experiences', 'position')) {
                    $table->string('position')->nullable();
                }
                if (! Schema::hasColumn('experiences', 'employment_type')) {
                    $table->string('employment_type')->nullable();
                }
                if (! Schema::hasColumn('experiences', 'location')) {
                    $table->string('location')->nullable();
                }
                if (! Schema::hasColumn('experiences', 'start_date')) {
                    $table->date('start_date')->nullable();
                }
                if (! Schema::hasColumn('experiences', 'end_date')) {
                    $table->date('end_date')->nullable();
                }
                if (! Schema::hasColumn('experiences', 'is_current')) {
                    $table->boolean('is_current')->default(false);
                }
                if (! Schema::hasColumn('experiences', 'description')) {
                    $table->text('description')->nullable();
                }
                if (! Schema::hasColumn('experiences', 'sort_order')) {
                    $table->integer('sort_order')->default(0);
                }
                if (! Schema::hasColumn('experiences', 'is_visible')) {
                    $table->boolean('is_visible')->default(true);
                }
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Tabel skills
        |--------------------------------------------------------------------------
        */
        if (Schema::hasTable('skills')) {
            Schema::table('skills', function (Blueprint $table) {
                if (! Schema::hasColumn('skills', 'name')) {
                    $table->string('name')->nullable();
                }
                if (! Schema::hasColumn('skills', 'category')) {
                    $table->string('category')->nullable();
                }
                if (! Schema::hasColumn('skills', 'proficiency')) {
                    $table->unsignedTinyInteger('proficiency')->default(0);
                }
                if (! Schema::hasColumn('skills', 'sort_order')) {
                    $table->integer('sort_order')->default(0);
                }
                if (! Schema::hasColumn('skills', 'is_visible')) {
                    $table->boolean('is_visible')->default(true);
                }
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Tabel certificates
        |--------------------------------------------------------------------------
        */
        if (Schema::hasTable('certificates')) {
            Schema::table('certificates', function (Blueprint $table) {
                if (! Schema::hasColumn('certificates', 'title')) {
                    $table->string('title')->nullable();
                }
                if (! Schema::hasColumn('certificates', 'issuer')) {
                    $table->string('issuer')->nullable();
                }
                if (! Schema::hasColumn('certificates', 'issue_date')) {
                    $table->date('issue_date')->nullable();
                }
                if (! Schema::hasColumn('certificates', 'expiry_date')) {
                    $table->date('expiry_date')->nullable();
                }
                if (! Schema::hasColumn('certificates', 'credential_id')) {
                    $table->string('credential_id')->nullable();
                }
                if (! Schema::hasColumn('certificates', 'credential_url')) {
                    $table->string('credential_url')->nullable();
                }
                if (! Schema::hasColumn('certificates', 'file_path')) {
                    $table->string('file_path')->nullable();
                }
                if (! Schema::hasColumn('certificates', 'sort_order')) {
                    $table->integer('sort_order')->default(0);
                }
                if (! Schema::hasColumn('certificates', 'is_visible')) {
                    $table->boolean('is_visible')->default(true);
                }
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Tabel projects
        |--------------------------------------------------------------------------
        */
        if (Schema::hasTable('projects')) {
            Schema::table('projects', function (Blueprint $table) {
                if (! Schema::hasColumn('projects', 'title')) {
                    $table->string('title')->nullable();
                }
                if (! Schema::hasColumn('projects', 'slug')) {
                    $table->string('slug')->nullable();
                }
                if (! Schema::hasColumn('projects', 'description')) {
                    $table->longText('description')->nullable();
                }
                if (! Schema::hasColumn('projects', 'role')) {
                    $table->string('role')->nullable();
                }
                if (! Schema::hasColumn('projects', 'technologies')) {
                    $table->json('technologies')->nullable();
                }
                if (! Schema::hasColumn('projects', 'image_path')) {
                    $table->string('image_path')->nullable();
                }
                if (! Schema::hasColumn('projects', 'project_url')) {
                    $table->string('project_url')->nullable();
                }
                if (! Schema::hasColumn('projects', 'repository_url')) {
                    $table->string('repository_url')->nullable();
                }
                if (! Schema::hasColumn('projects', 'start_date')) {
                    $table->date('start_date')->nullable();
                }
                if (! Schema::hasColumn('projects', 'end_date')) {
                    $table->date('end_date')->nullable();
                }
                if (! Schema::hasColumn('projects', 'is_featured')) {
                    $table->boolean('is_featured')->default(false);
                }
                if (! Schema::hasColumn('projects', 'sort_order')) {
                    $table->integer('sort_order')->default(0);
                }
                if (! Schema::hasColumn('projects', 'is_visible')) {
                    $table->boolean('is_visible')->default(true);
                }
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Tabel social_links
        |--------------------------------------------------------------------------
        */
        if (Schema::hasTable('social_links')) {
            Schema::table('social_links', function (Blueprint $table) {
                if (! Schema::hasColumn('social_links', 'platform')) {
                    $table->string('platform')->nullable();
                }
                if (! Schema::hasColumn('social_links', 'label')) {
                    $table->string('label')->nullable();
                }
                if (! Schema::hasColumn('social_links', 'url')) {
                    $table->string('url')->nullable();
                }
                if (! Schema::hasColumn('social_links', 'icon')) {
                    $table->string('icon')->nullable();
                }
                if (! Schema::hasColumn('social_links', 'sort_order')) {
                    $table->integer('sort_order')->default(0);
                }
                if (! Schema::hasColumn('social_links', 'is_visible')) {
                    $table->boolean('is_visible')->default(true);
                }
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Tabel profiles
        |--------------------------------------------------------------------------
        */
        if (Schema::hasTable('profiles')) {
            Schema::table('profiles', function (Blueprint $table) {
                if (! Schema::hasColumn('profiles', 'full_name')) {
                    $table->string('full_name')->nullable();
                }
                if (! Schema::hasColumn('profiles', 'headline')) {
                    $table->string('headline')->nullable();
                }
                if (! Schema::hasColumn('profiles', 'summary')) {
                    $table->longText('summary')->nullable();
                }
                if (! Schema::hasColumn('profiles', 'photo')) {
                    $table->string('photo')->nullable();
                }
                if (! Schema::hasColumn('profiles', 'email')) {
                    $table->string('email')->nullable();
                }
                if (! Schema::hasColumn('profiles', 'phone')) {
                    $table->string('phone')->nullable();
                }
                if (! Schema::hasColumn('profiles', 'location')) {
                    $table->string('location')->nullable();
                }
                if (! Schema::hasColumn('profiles', 'address')) {
                    $table->text('address')->nullable();
                }
                if (! Schema::hasColumn('profiles', 'website')) {
                    $table->string('website')->nullable();
                }
                if (! Schema::hasColumn('profiles', 'resume_file')) {
                    $table->string('resume_file')->nullable();
                }
                if (! Schema::hasColumn('profiles', 'is_published')) {
                    $table->boolean('is_published')->default(false);
                }
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Tabel settings
        |--------------------------------------------------------------------------
        */
        if (Schema::hasTable('settings')) {
            Schema::table('settings', function (Blueprint $table) {
                if (! Schema::hasColumn('settings', 'key')) {
                    $table->string('key')->nullable();
                }
                if (! Schema::hasColumn('settings', 'value')) {
                    $table->longText('value')->nullable();
                }
                if (! Schema::hasColumn('settings', 'group')) {
                    $table->string('group')->nullable();
                }
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Tabel messages
        |--------------------------------------------------------------------------
        */
        if (Schema::hasTable('messages')) {
            Schema::table('messages', function (Blueprint $table) {
                if (! Schema::hasColumn('messages', 'name')) {
                    $table->string('name')->nullable();
                }
                if (! Schema::hasColumn('messages', 'email')) {
                    $table->string('email')->nullable();
                }
                if (! Schema::hasColumn('messages', 'subject')) {
                    $table->string('subject')->nullable();
                }
                if (! Schema::hasColumn('messages', 'message')) {
                    $table->longText('message')->nullable();
                }
                if (! Schema::hasColumn('messages', 'is_read')) {
                    $table->boolean('is_read')->default(false);
                }
                if (! Schema::hasColumn('messages', 'read_at')) {
                    $table->timestamp('read_at')->nullable();
                }
            });
        }
    }

    public function down(): void
    {
        // Sengaja tidak menghapus kolom agar data tetap aman.
    }
};
