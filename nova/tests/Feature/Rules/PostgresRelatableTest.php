<?php

namespace Laravel\Nova\Tests\Feature\Rules;

use Laravel\Nova\Tests\PostgresIntegrationTestCase;

class PostgresRelatableTest extends PostgresIntegrationTestCase
{
    use RelatableTest;

    protected function setUp(): void
    {
        $this->skipIfNotRunning();

        parent::setUp();
    }
}
