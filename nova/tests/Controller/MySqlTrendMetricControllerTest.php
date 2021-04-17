<?php

namespace Laravel\Nova\Tests\Controller;

use Laravel\Nova\Tests\MySqlIntegrationTestCase;

class MySqlTrendMetricControllerTest extends MySqlIntegrationTestCase
{
    use TrendDateTests;

    protected function setUp(): void
    {
        $this->skipIfNotRunning();

        parent::setUp();

        $this->authenticate();
    }
}
