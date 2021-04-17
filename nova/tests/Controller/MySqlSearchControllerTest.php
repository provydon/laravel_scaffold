<?php

namespace Laravel\Nova\Tests\Controller;

use Laravel\Nova\Tests\MySqlIntegrationTestCase;

class MySqlSearchControllerTest extends MySqlIntegrationTestCase
{
    use SearchControllerTests;

    protected function setUp(): void
    {
        $this->skipIfNotRunning();

        parent::setUp();

        $this->authenticate();
    }
}
