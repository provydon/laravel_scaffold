<?php

namespace Laravel\Nova\Tests\Controller;

use Laravel\Nova\Tests\IntegrationTestCase;

class SqliteSearchControllerTest extends IntegrationTestCase
{
    use SearchControllerTests;

    protected function setUp(): void
    {
        parent::setUp();

        $this->authenticate();
    }
}
