<?php

namespace Laravel\Nova\Tests\Controller\Laravel;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Fields\MorphToActionTarget;
use Laravel\Nova\Nova;
use Laravel\Nova\Tests\LaravelTestCase;

class ActionEventResourceTest extends LaravelTestCase
{
    public function test_action_events_resource_index_can_be_displayed_for_removed_resource()
    {
        $user = User::find(1);
        $model = User::find(4);

        $model->delete();

        tap(Nova::actionEvent(), function ($actionEvent) use ($model, $user) {
            DB::connection($actionEvent->getConnectionName())->table('action_events')->insert(
                $actionEvent->forResourceDelete($user, collect([$model]))
                    ->map->getAttributes()->all()
            );
        });

        $response = $this->withExceptionHandling()
                        ->actingAs($user)
                        ->getJson('/nova-api/action-events');

        $target = $response->original['resources'][0]['fields'][3];

        $this->assertInstanceOf(MorphToActionTarget::class, $target);
        $this->assertSame(__('Action Target'), $target->name);
        $this->assertSame(User::class, $target->morphToType);
        $this->assertSame('4', $target->morphToId);
        $this->assertNull($target->resourceClass);
        $this->assertNull($target->resourceName);
    }

    public function test_action_events_resource_detail_can_be_displayed_for_removed_resource()
    {
        $user = User::find(1);
        $model = User::find(4);

        $model->delete();

        tap(Nova::actionEvent(), function ($actionEvent) use ($model, $user) {
            DB::connection($actionEvent->getConnectionName())->table('action_events')->insert(
                $actionEvent->forResourceDelete($user, collect([$model]))
                    ->map->getAttributes()->all()
            );
        });

        $response = $this->withExceptionHandling()
                        ->actingAs($user)
                        ->getJson('/nova-api/action-events/1');

        $target = $response->original['resource']['fields'][3];

        $this->assertInstanceOf(MorphToActionTarget::class, $target);
        $this->assertSame(__('Action Target'), $target->name);
        $this->assertSame(User::class, $target->morphToType);
        $this->assertSame('4', $target->morphToId);
        $this->assertNull($target->resourceClass);
        $this->assertNull($target->resourceName);
    }
}
