<?php

namespace Laravel\Nova\Tests;

use Illuminate\Foundation\Mix;
use Illuminate\Support\Facades\Schema;
use Laravel\Nova\Nova;
use Laravel\Nova\Tests\Fixtures\CustomConnectionActionResource;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Setup the test case.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->beforeApplicationDestroyed(function () {
            Nova::flushState();
        });

        parent::setUp();
    }

    /**
     * Define environment.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function defineEnvironment($app)
    {
        $app['config']->set('database.default', 'sqlite');

        $app['config']->set('database.connections.sqlite', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    /**
     * Assert a top-level subset for an array.
     *
     * @param array $subset
     * @param array $array
     * @return void
     */
    public function assertSubset($subset, $array)
    {
        $values = collect($array)->only(array_keys($subset))->all();

        $this->assertEquals($subset, $values, 'The expected subset does not match the given array.');
    }

    /**
     * Run tests Without Mix.
     *
     * @return $this
     */
    protected function withoutMix()
    {
        $this->instance(Mix::class, function () {
            //
        });

        return $this;
    }

    /**
     * Configure ActionEvents to be on a separate database connection.
     *
     * @return void
     */
    protected function setupActionEventsOnSeparateConnection()
    {
        config(['nova.actions.resource' => CustomConnectionActionResource::class]);

        config([
            'database.connections.sqlite-custom' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
            ],
        ]);

        Schema::connection('sqlite-custom')->create('action_events', function ($table) {
            $table->increments('id');
            $table->char('batch_id', 36);
            $table->unsignedInteger('user_id')->index();
            $table->string('name');
            $table->string('actionable_type');
            $table->unsignedInteger('actionable_id');
            $table->string('target_type');
            $table->unsignedInteger('target_id');
            $table->string('model_type');
            $table->unsignedInteger('model_id')->nullable();
            $table->text('fields');
            $table->string('status', 25)->default('running');
            $table->text('exception');
            $table->json('original')->nullable();
            $table->json('changes')->nullable();
            $table->timestamps();

            $table->index(['actionable_type', 'actionable_id']);
            $table->index(['batch_id', 'model_type', 'model_id']);
        });
    }
}
