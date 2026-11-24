
<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SecurityController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ResumeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| HALAMAN UTAMA
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

/*
|--------------------------------------------------------------------------
| HALAMAN PUBLIK
|--------------------------------------------------------------------------
*/

Route::post('/contact', [HomeController::class, 'contact'])
    ->name('contact.store');

Route::get('/cv/download', [ResumeController::class, 'download'])
    ->name('cv.download');

/*
|--------------------------------------------------------------------------
| ADMINISTRATOR
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {

    // LOGIN
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])
            ->name('login');

        Route::post('/login', [AuthController::class, 'login'])
            ->name('login.process');
    });

    // AREA ADMIN
    Route::middleware(['auth', 'admin'])->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::post('/logout', [AuthController::class, 'logout'])
            ->name('logout');

        // MANAJEMEN PROFIL
        Route::get('/profile', [ProfileController::class, 'edit'])
            ->name('profile.edit');

        Route::put('/profile', [ProfileController::class, 'update'])
            ->name('profile.update');

        Route::delete('/profile/resume', [ProfileController::class, 'deleteResume'])
            ->name('profile.resume.delete');

        // MANAJEMEN KONTEN
        Route::get('/content/{module}', [ContentController::class, 'index'])
            ->name('content.index');

        Route::get('/content/{module}/create', [ContentController::class, 'create'])
            ->name('content.create');

        Route::post('/content/{module}', [ContentController::class, 'store'])
            ->name('content.store');

        Route::get('/content/{module}/{id}/edit', [ContentController::class, 'edit'])
            ->name('content.edit');

        Route::put('/content/{module}/{id}', [ContentController::class, 'update'])
            ->name('content.update');

        Route::delete('/content/{module}/{id}', [ContentController::class, 'destroy'])
            ->name('content.destroy');

        // MANAJEMEN PESAN
        Route::get('/messages', [MessageController::class, 'index'])
            ->name('messages.index');

        Route::get('/messages/{message}', [MessageController::class, 'show'])
            ->name('messages.show');

        Route::delete('/messages/{message}', [MessageController::class, 'destroy'])
            ->name('messages.destroy');

        // NOTIFIKASI
        Route::get('/notifications', [NotificationController::class, 'index'])
            ->name('notifications.index');

        Route::post('/notifications/{notification}/read', [NotificationController::class, 'read'])
            ->name('notifications.read');

        Route::post('/notifications/read-all', [NotificationController::class, 'readAll'])
            ->name('notifications.read-all');

        // KEAMANAN ADMIN
        Route::get('/security/password', [SecurityController::class, 'editPassword'])
            ->name('security.password');

        Route::put('/security/password', [SecurityController::class, 'updatePassword'])
            ->name('security.password.update');

        // PENGATURAN WEBSITE
        Route::get('/settings', [SettingController::class, 'index'])
            ->name('settings.index');

        Route::put('/settings', [SettingController::class, 'update'])
            ->name('settings.update');

        // MANAJEMEN ADMINISTRATOR
        Route::resource('/users', UserController::class)
            ->except(['show'])
            ->names('users');
    });
});
