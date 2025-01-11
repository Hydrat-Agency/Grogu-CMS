<?php

use Illuminate\Support\Facades\Route;
use Hydrat\GroguCMS\Filament\Pages\WelcomeUser;
use Spatie\WelcomeNotification\WelcomesNewUsers;

Route::middleware('web')
    ->group(function () {
        Route::get('/admin/welcome/{user}', WelcomeUser::class)
            ->middleware(WelcomesNewUsers::class)
            ->name('welcome');
    });
