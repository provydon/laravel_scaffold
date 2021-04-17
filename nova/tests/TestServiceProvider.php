<?php

namespace Laravel\Nova\Tests;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Nova;
use Laravel\Nova\Tests\Fixtures\AddressResource;
use Laravel\Nova\Tests\Fixtures\BooleanResource;
use Laravel\Nova\Tests\Fixtures\CallableDefaultResource;
use Laravel\Nova\Tests\Fixtures\CategoryResource;
use Laravel\Nova\Tests\Fixtures\CommentResource;
use Laravel\Nova\Tests\Fixtures\CustomKeyResource;
use Laravel\Nova\Tests\Fixtures\DiscussionResource;
use Laravel\Nova\Tests\Fixtures\FileResource;
use Laravel\Nova\Tests\Fixtures\ForbiddenUserResource;
use Laravel\Nova\Tests\Fixtures\GroupedUserResource;
use Laravel\Nova\Tests\Fixtures\PanelResource;
use Laravel\Nova\Tests\Fixtures\PostResource;
use Laravel\Nova\Tests\Fixtures\ProfileResource;
use Laravel\Nova\Tests\Fixtures\RecipientResource;
use Laravel\Nova\Tests\Fixtures\RoleResource;
use Laravel\Nova\Tests\Fixtures\SnippetResource;
use Laravel\Nova\Tests\Fixtures\SoftDeletingFileResource;
use Laravel\Nova\Tests\Fixtures\TagResource;
use Laravel\Nova\Tests\Fixtures\UserResource;
use Laravel\Nova\Tests\Fixtures\UserWithCustomFields;
use Laravel\Nova\Tests\Fixtures\UserWithRedirectResource;
use Laravel\Nova\Tests\Fixtures\VaporFileResource;
use Laravel\Nova\Tests\Fixtures\VehicleResource;
use Laravel\Nova\Tests\Fixtures\WheelResource;

class TestServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        Nova::resources([
            AddressResource::class,
            BooleanResource::class,
            CallableDefaultResource::class,
            CategoryResource::class,
            CommentResource::class,
            CustomKeyResource::class,
            DiscussionResource::class,
            FileResource::class,
            ForbiddenUserResource::class,
            GroupedUserResource::class,
            PanelResource::class,
            PostResource::class,
            ProfileResource::class,
            RecipientResource::class,
            RoleResource::class,
            SoftDeletingFileResource::class,
            SnippetResource::class,
            TagResource::class,
            UserResource::class,
            UserWithRedirectResource::class,
            UserWithCustomFields::class,
            VaporFileResource::class,
            VehicleResource::class,
            WheelResource::class,
        ]);

        Nova::routes()->withAuthenticationRoutes()
                      ->withPasswordResetRoutes();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Nova::auth(function () {
            return true;
        });
    }
}
