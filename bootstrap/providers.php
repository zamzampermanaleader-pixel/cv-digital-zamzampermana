<?php

use App\Providers\AppServiceProvider;
use Illuminate\View\ViewServiceProvider;

return [
    ViewServiceProvider::class,
    AppServiceProvider::class,
    App\Providers\ResumePdfServiceProvider::class,
];
