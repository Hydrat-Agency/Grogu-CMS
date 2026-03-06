<?php

use Hydrat\GroguCMS\Tests\DatabaseTestCase;
use Hydrat\GroguCMS\Tests\Models\User;
use Hydrat\GroguCMS\Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
| Unit and configuration tests use the base TestCase (no DB migrations).
| Feature tests that touch the database use DatabaseTestCase.
*/

uses(TestCase::class)->in('Unit', 'Feature/Configuration', 'Feature/Filament/Macros');
uses(DatabaseTestCase::class)->in('Feature/Actions', 'Feature/Filament/Resources', 'Feature/Models');

/*
|--------------------------------------------------------------------------
| Helpers
|--------------------------------------------------------------------------
*/

/**
 * Create and authenticate a test admin user against the Filament panel.
 */
function actingAsAdmin(): User
{
    $user = new User([
        'id' => 1,
        'name' => 'Test Admin',
        'email' => 'admin@example.com',
    ]);

    test()->actingAs($user);

    return $user;
}
