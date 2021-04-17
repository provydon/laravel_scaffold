<?php

namespace Laravel\Nova\Tests\Controller;

use Laravel\Nova\Tests\IntegrationTestCase;

class SqliteTrendMetricControllerTest extends IntegrationTestCase
{
    use TrendDateTests;

    protected function setUp(): void
    {
        parent::setUp();

        $this->authenticate();
    }
}
