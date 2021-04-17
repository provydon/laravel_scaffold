<?php

namespace Laravel\Nova\Tests\Feature\Rules;

use Laravel\Nova\Tests\MySqlIntegrationTestCase;

class MySqlRelatableTest extends MySqlIntegrationTestCase
{
    use RelatableTest;

    protected function setUp(): void
    {
        $this->skipIfNotRunning();

        parent::setUp();
    }
}
