<?php

namespace Laravel\Nova\Tests\Controller;

use Laravel\Nova\Tests\PostgresIntegrationTestCase;

/**
 * @group postgres
 */
class PostgresTrendMetricControllerTest extends PostgresIntegrationTestCase
{
    use TrendDateTests;

    protected function setUp(): void
    {
        $this->skipIfNotRunning();

        parent::setUp();

        $this->authenticate();
    }
}
