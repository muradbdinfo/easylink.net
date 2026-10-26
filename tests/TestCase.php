<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use RuntimeException;

abstract class TestCase extends BaseTestCase
{
    /**
     * Tests use RefreshDatabase (migrate:fresh), which would erase a real database. Refuse to boot
     * unless they run on the in-memory SQLite database from phpunit.xml - a cached config
     * (php artisan config:cache) ignores phpunit.xml and would point them at MySQL.
     */
    protected function refreshApplication(): void
    {
        parent::refreshApplication();

        $config = $this->app['config'];

        if ($config->get('database.default') !== 'sqlite' || $config->get('database.connections.sqlite.database') !== ':memory:') {
            throw new RuntimeException('Refusing to run the tests: they would wipe the "'.$config->get('database.default').'" database. Run "php artisan config:clear" and use the sqlite :memory: settings from phpunit.xml.');
        }
    }
}
