<?php

namespace Laravel\Nova\Tests\Feature\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Laravel\Nova\Events\NovaServiceProviderRegistered;
use Laravel\Nova\Tests\IntegrationTestCase;

class ServeNovaTest extends IntegrationTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->authenticate();
    }

    /**
     * Uses default path environment setup.
     */
    protected function usesDefaultPath($app)
    {
        $app['config']->set([
            'app.url' => 'http://localhost',
            'nova.domain' => 'http://localhost',
            'nova.path' => '/nova',
        ]);
    }

    /**
     * Uses custom subdomain with root path environment setup.
     */
    protected function usesNullDomainWithRootPath($app)
    {
        $app['config']->set([
            'app.url' => 'http://localhost',
            'nova.domain' => null,
            'nova.path' => '/',
        ]);
    }

    /**
     * Uses custom subdomain with root path environment setup.
     */
    protected function usesCustomSchemalessSubdomainWithRootPath($app)
    {
        $app['config']->set([
            'app.url' => 'http://localhost',
            'nova.domain' => 'nova.app',
            'nova.path' => '/',
        ]);
    }

    /**
     * Uses custom subdomain with root path environment setup.
     */
    protected function usesCustomSubdomainWithRootPath($app)
    {
        $app['config']->set([
            'app.url' => 'http://localhost',
            'nova.domain' => 'http://nova.app',
            'nova.path' => '/',
        ]);
    }

    /**
     * Uses custom subdomain with root path environment setup.
     */
    protected function usesCustomLocalSubdomainWithRootPath($app)
    {
        $app['config']->set([
            'app.url' => 'http://localhost',
            'nova.domain' => 'http://nova.localhost',
            'nova.path' => '/',
        ]);
    }

    /**
     * Uses custom subdomain with http prefix + root path environment setup.
     */
    protected function usesCustomSubdomainWithPortAndRootPath($app)
    {
        $app['config']->set([
            'app.url' => 'http://localhost',
            'nova.domain' => 'nova.app',
            'nova.path' => '/',
        ]);
    }

    /**
     * Uses custom subdomain with http prefix + root path environment setup.
     */
    protected function usesCustomLocalSubdomainWithPortAndRootPath($app)
    {
        $app['config']->set([
            'app.url' => 'http://localhost',
            'nova.domain' => 'nova.localhost',
            'nova.path' => '/',
        ]);
    }

    /**
     * Uses custom subdomain with http prefix + root path environment setup.
     */
    protected function usesCustomSubdomainWithHttpPrefixAndRootPath($app)
    {
        $app['config']->set([
            'app.url' => 'http://localhost',
            'nova.domain' => 'httpsnova.app',
            'nova.path' => '/',
        ]);
    }

    /**
     * @environment-setup usesDefaultPath
     */
    public function test_it_can_serve_from_default_path_will_trigger_service_provider_registered()
    {
        Event::fake();

        $this->get('/nova-api/users')->assertOk();

        Event::assertDispatched(NovaServiceProviderRegistered::class);
    }

    /**
     * @environment-setup usesNullDomainWithRootPath
     */
    public function test_it_can_serve_from_null_subdomain_will_trigger_service_provider_registered()
    {
        Event::fake();

        $this->get('http://nova.app/nova-api/users')->assertOk();

        Event::assertDispatched(NovaServiceProviderRegistered::class);
    }

    /**
     * @environment-setup usesCustomSubdomainWithRootPath
     */
    public function test_it_can_serve_from_subdomain_will_trigger_service_provider_registered()
    {
        Event::fake();

        $this->get('http://nova.app/nova-api/users')->assertOk();

        Event::assertDispatched(NovaServiceProviderRegistered::class);
    }

    /**
     * @environment-setup usesCustomLocalSubdomainWithRootPath
     */
    public function test_it_can_serve_from_local_subdomain_will_trigger_service_provider_registered()
    {
        Event::fake();

        $this->get('http://nova.localhost/nova-api/users')->assertOk();

        Event::assertDispatched(NovaServiceProviderRegistered::class);
    }

    /**
     * @environment-setup usesCustomSchemalessSubdomainWithRootPath
     */
    public function test_it_can_serve_from_schemaless_subdomain_will_trigger_service_provider_registered()
    {
        Event::fake();

        $this->get('http://nova.app/nova-api/users')->assertOk();

        Event::assertDispatched(NovaServiceProviderRegistered::class);
    }

    /**
     * @environment-setup usesCustomSubdomainWithPortAndRootPath
     */
    public function test_it_can_serve_from_subdomain_with_port_will_trigger_service_provider_registered()
    {
        Event::fake();

        $this->get('http://nova.app:8080/nova-api/users')->assertOk();

        Event::assertDispatched(NovaServiceProviderRegistered::class);
    }

    /**
     * @environment-setup usesCustomLocalSubdomainWithPortAndRootPath
     */
    public function test_it_can_serve_from_local_subdomain_with_port_will_trigger_service_provider_registered()
    {
        Event::fake();

        $this->get('http://nova.localhost:8080/nova-api/users')->assertOk();

        Event::assertDispatched(NovaServiceProviderRegistered::class);
    }

    /**
     * @environment-setup usesCustomSubdomainWithHttpPrefixAndRootPath
     */
    public function test_it_can_serve_from_subdomain_with_http_prefix_will_trigger_service_provider_registered()
    {
        Event::fake();

        $this->get('http://httpsnova.app/nova-api/users')->assertOk();

        Event::assertDispatched(NovaServiceProviderRegistered::class);
    }

    /**
     * @environment-setup usesDefaultPath
     */
    public function test_it_can_serve_from_default_path_will_not_trigger_service_provider_registered_on_none_nova_request()
    {
        Event::fake();

        $this->app['router']->get('test', function (Request $request) {
            return 'OK';
        });

        $this->get('http://localhost/test')->assertOk();

        Event::assertNotDispatched(NovaServiceProviderRegistered::class);
    }

    /**
     * @environment-setup usesNullDomainWithRootPath
     */
    public function test_it_can_serve_from_null_subdomain_will_trigger_service_provider_registered_on_none_nova_request()
    {
        Event::fake();

        $this->app['router']->get('test', function (Request $request) {
            return 'OK';
        });

        $this->get('http://localhost/test')->assertOk();

        Event::assertDispatched(NovaServiceProviderRegistered::class);
    }

    /**
     * @environment-setup usesCustomSubdomainWithRootPath
     */
    public function test_it_can_serve_from_subdomain_will_trigger_service_provider_registered_on_none_nova_request()
    {
        Event::fake();

        $this->app['router']->get('test', function (Request $request) {
            return 'OK';
        });

        $this->get('http://localhost/test')->assertOk();

        Event::assertNotDispatched(NovaServiceProviderRegistered::class);
    }

    /**
     * @environment-setup usesCustomSchemalessSubdomainWithRootPath
     */
    public function test_it_can_serve_from_schemaless_subdomain_will_not_trigger_service_provider_registered_on_none_nova_request()
    {
        Event::fake();

        $this->app['router']->get('test', function (Request $request) {
            return 'OK';
        });

        $this->get('http://localhost/test')->assertOk();

        Event::assertNotDispatched(NovaServiceProviderRegistered::class);
    }

    /**
     * @environment-setup usesCustomSubdomainWithPortAndRootPath
     */
    public function test_it_can_serve_from_subdomain_with_port_will_trigger_service_provider_registered_on_none_nova_request()
    {
        Event::fake();

        $this->app['router']->get('test', function (Request $request) {
            return 'OK';
        });

        $this->get('http://localhost/test')->assertOk();

        Event::assertNotDispatched(NovaServiceProviderRegistered::class);
    }

    /**
     * @environment-setup usesCustomSubdomainWithHttpPrefixAndRootPath
     */
    public function test_it_can_serve_from_subdomain_with_http_prefix_will_trigger_service_provider_registered_on_none_nova_request()
    {
        Event::fake();

        $this->app['router']->get('test', function (Request $request) {
            return 'OK';
        });

        $this->get('http://localhost/test')->assertOk();

        Event::assertNotDispatched(NovaServiceProviderRegistered::class);
    }
}
