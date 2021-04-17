<?php

namespace Laravel\Nova\Tests\Feature\Metric;

use Illuminate\Support\Carbon;
use Laravel\Nova\Metrics\PostgresTrendDateExpression;
use Laravel\Nova\Tests\Fixtures\User;
use Laravel\Nova\Tests\PostgresIntegrationTestCase;

class PostgresTrendDateExpressionTest extends PostgresIntegrationTestCase
{
    protected function setUp(): void
    {
        $this->skipIfNotRunning();

        parent::setUp();
    }

    /**
     * @test
     * @dataProvider offsetDataProvider
     */
    public function it_can_handle_setting_offset($unit, $appTimezone, $userTimezone, $offset, $value)
    {
        $now = Carbon::now($userTimezone);

        if ($appTimezone == 'UTC' && $now->isDST()) {
            $offset = $offset + 1;
        }

        config(['app.timezone' => $appTimezone]);

        $query = User::query();

        $trend = new PostgresTrendDateExpression($query, 'created_at', $unit, $userTimezone);

        $this->assertSame($offset, $trend->offset());
        $this->assertSame(sprintf($value, abs($offset)), $trend->getValue());
    }

    public function offsetDataProvider()
    {
        // [$unit, $appTimezone, $userTimezone, $offset, $value]

        yield ['month', 'UTC', 'Japan', 9, "to_char(\"created_at\" + interval '%d hour', 'YYYY-MM')"];
        yield ['month', 'UTC', 'Asia/Kuala_Lumpur', 8, "to_char(\"created_at\" + interval '%d hour', 'YYYY-MM')"];
        yield ['month', 'UTC', 'UTC', 0, "to_char(\"created_at\" , 'YYYY-MM')"];
        yield ['month', 'UTC', 'America/New_York', -5, "to_char(\"created_at\" - interval '%d HOUR', 'YYYY-MM')"];
        yield ['month', 'UTC', 'America/Chicago', -6, "to_char(\"created_at\" - interval '%d HOUR', 'YYYY-MM')"];

        yield ['month', 'Asia/Kuala_Lumpur', 'Japan', 1, "to_char(\"created_at\" + interval '%d hour', 'YYYY-MM')"];
        yield ['month', 'Asia/Kuala_Lumpur', 'Asia/Kuala_Lumpur', 0, "to_char(\"created_at\" , 'YYYY-MM')"];
        yield ['month', 'Japan', 'Asia/Kuala_Lumpur', -1, "to_char(\"created_at\" - interval '%d HOUR', 'YYYY-MM')"];
        yield ['month', 'Asia/Kuala_Lumpur', 'UTC', -8, "to_char(\"created_at\" - interval '%d HOUR', 'YYYY-MM')"];

        yield ['month', 'America/Chicago', 'America/New_York', 1, "to_char(\"created_at\" + interval '%d hour', 'YYYY-MM')"];
        yield ['month', 'America/New_York', 'America/Chicago', -1, "to_char(\"created_at\" - interval '%d HOUR', 'YYYY-MM')"];
    }
}
