<?php

use Hydrat\GroguCMS\Filament\Pages\WelcomeUser;
use Spatie\WelcomeNotification\WelcomesNewUsers;

Route::get('/admin/welcome/{user}', WelcomeUser::class)->middleware(WelcomesNewUsers::class)->name('welcome');
