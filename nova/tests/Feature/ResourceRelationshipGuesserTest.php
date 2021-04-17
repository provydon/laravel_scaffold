<?php

namespace Laravel\Nova\Tests\Feature;

use Illuminate\Http\Request;
use Illuminate\Support\Fluent;
use Laravel\Nova\Tests\Fixtures\RelationshipGuesserResource;
use Laravel\Nova\Tests\Fixtures\UserResource;
use Laravel\Nova\Tests\IntegrationTestCase;

class ResourceRelationshipGuesserTest extends IntegrationTestCase
{
    public function test_resource_can_be_guessed()
    {
        $fields = (new RelationshipGuesserResource(new Fluent))->fields(Request::create('/'));
        $this->assertEquals(UserResource::class, $fields[1]->resourceClass);
    }
}
