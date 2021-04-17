<?php

namespace Laravel\Nova\Tests\Controller\Laravel;

use App\Models\User;
use Laravel\Nova\Tests\LaravelTestCase;

class ResourceDetachTest extends LaravelTestCase
{
    /**
     * @test
     * @dataProvider detachResourceDataProvider
     */
    public function it_can_detach_pivot_from_resource($deleteRelation, $resources, $pivots, $personalBooksCount, $giftBooksCount)
    {
        $user = User::find(1);

        tap($user->personalBooks(), function ($book) {
            $book->attach(1, ['type' => 'personal', 'price' => 39, 'purchased_at' => now()]);
            $book->attach(1, ['type' => 'personal', 'price' => 39, 'purchased_at' => now()]);
            $book->attach(1, ['type' => 'personal', 'price' => 39, 'purchased_at' => now()]);
            $book->attach(2, ['type' => 'personal', 'price' => 39, 'purchased_at' => now()]);
            $book->attach(2, ['type' => 'personal', 'price' => 39, 'purchased_at' => now()]);
            $book->attach(3, ['type' => 'personal', 'price' => 39, 'purchased_at' => now()]);
        });

        tap($user->giftBooks(), function ($book) {
            $book->attach(4, ['type' => 'gift', 'price' => 29, 'purchased_at' => now()]);
            $book->attach(4, ['type' => 'gift', 'price' => 29, 'purchased_at' => now()]);
            $book->attach(4, ['type' => 'gift', 'price' => 29, 'purchased_at' => now()]);
            $book->attach(4, ['type' => 'gift', 'price' => 29, 'purchased_at' => now()]);
        });

        $response = $this->withExceptionHandling()
                        ->actingAs($user)
                        ->deleteJson('/nova-api/books/detach?viaResource=users&viaResourceId=1&viaRelationship='.$deleteRelation, array_filter([
                            'resources' => $resources,
                            'pivots' => $pivots,
                        ]));

        $response->assertStatus(200);

        $user->refresh();

        $this->assertCount($personalBooksCount, $user->personalBooks);
        $this->assertCount($giftBooksCount, $user->giftBooks);
    }

    public function detachResourceDataProvider()
    {
        yield ['personalBooks', [1], null, 3, 4];
        yield ['personalBooks', [2], null, 4, 4];
        yield ['personalBooks', [3], null, 5, 4];
        yield ['personalBooks', [4], null, 6, 4];
        yield ['personalBooks', [1], [1], 5, 4];
        yield ['personalBooks', [3], [6], 5, 4];
        yield ['personalBooks', [3], [90], 6, 4];

        yield ['giftBooks', [4], null, 6, 0];
        yield ['giftBooks', [4], [10], 6, 3];
        yield ['giftBooks', [4], [9, 10], 6, 2];
        yield ['giftBooks', [4], [90], 6, 4];

        // Delete using match all.
        yield ['personalBooks', 'all', null, 0, 4];
        yield ['giftBooks', 'all', null, 6, 0];
        yield ['personalBooks', 'all', [10], 0, 4];
        yield ['giftBooks', 'all', [1], 6, 0];
    }
}
