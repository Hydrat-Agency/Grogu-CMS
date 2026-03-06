<?php

namespace Hydrat\GroguCMS\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * TestCase with full database support.
 * Extends the base TestCase and runs package migrations in the correct order.
 */
class DatabaseTestCase extends TestCase
{
    use RefreshDatabase;

    protected function defineDatabaseMigrations(): void
    {
        $this->loadLaravelMigrations();
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }
}
