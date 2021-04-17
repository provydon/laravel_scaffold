<?php

namespace Laravel\Nova\Tests;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Queue\WorkerOptions;
use Illuminate\Support\Facades\Hash;
use Laravel\Nova\NovaCoreServiceProvider;
use Laravel\Nova\NovaServiceProvider;
use Laravel\Nova\Tests\Fixtures\NoopAction;
use Mockery;

abstract class IntegrationTestCase extends TestCase
{
    /**
     * The user the request is currently authenticated as.
     *
     * @var mixed
     */
    protected $authenticatedAs;

    /**
     * Setup the test case.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->beforeApplicationDestroyed(function () {
            NoopAction::$applied = [];
            NoopAction::$appliedToComments = [];
        });

        parent::setUp();

        Hash::driver('bcrypt')->setRounds(4);

        $this->withFactories(__DIR__.'/Factories');
    }

    /**
     * Load the migrations for the test environment.
     *
     * @return void
     */
    protected function defineDatabaseMigrations()
    {
        $this->defineDatabaseMigrationsUsingDatabase('sqlite');
    }

    /**
     * Get the service providers for the package.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            NovaCoreServiceProvider::class,
            NovaServiceProvider::class,
            TestServiceProvider::class,
        ];
    }

    /**
     * Define database migrations using database connection.
     *
     * @param  string  $database
     * @return void
     */
    protected function defineDatabaseMigrationsUsingDatabase($database)
    {
        $this->loadMigrationsFrom([
            '--database' => $database,
            '--path' => realpath(__DIR__.'/Migrations'),
        ]);
    }

    /**
     * Authenticate as an anonymous user.
     *
     * @return $this
     */
    protected function authenticate()
    {
        $this->actingAs($this->authenticatedAs = Mockery::mock(Authenticatable::class));

        $this->authenticatedAs->shouldReceive('getAuthIdentifier')->andReturn(1);
        $this->authenticatedAs->shouldReceive('getKey')->andReturn(1);

        return $this;
    }

    /**
     * Run the next job on the queue.
     *
     * @param  int  $times
     * @return void
     */
    protected function work($times = 1)
    {
        for ($i = 0; $i < $times; $i++) {
            $this->worker()->runNextJob(
                'redis', 'default', $this->workerOptions()
            );
        }
    }

    /**
     * Get the queue worker instance.
     *
     * @return \Illuminate\Queue\Worker
     */
    protected function worker()
    {
        return resolve('queue.worker');
    }

    /**
     * Get the options for the worker.
     *
     * @return \Illuminate\Queue\WorkerOptions
     */
    protected function workerOptions()
    {
        return tap(new WorkerOptions, function ($options) {
            $options->sleep = 0;
            $options->maxTries = 1;
        });
    }
}
