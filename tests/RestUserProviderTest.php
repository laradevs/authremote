<?php

namespace LaraDevs\AuthRemote\Tests;
use Auth;
use Illuminate\Support\Facades\Route;
use LaraDevs\AuthRemote\RestException;
use LaraDevs\AuthRemote\RestUserProvider;
use LaraDevs\AuthRemote\MainServiceProvider;
use LaraDevs\AuthRemote\ServiceProviders\RouteServiceProvider;
use LaraDevs\AuthRemote\User;

class RestUserProviderTest extends \Orchestra\Testbench\TestCase
{

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('auth.providers.users.driver', 'rest-users');
        $app['config']->set('auth.providers.users.model', User::class);
        $app->register(RouteServiceProvider::class);
    }
    /**
     * @test
     */
    public function validate_key_driver_test()
    {
        $this->assertTrue(config('auth.providers.users.driver')==='rest-users');
    }
    /**
     * @test
     */
    public function validate_key_model_test()
    {
        $this->assertTrue(config('auth.providers.users.model')===User::class);
    }

    /**
     * @test
     */
    public function validate_exist_routes_test()
    {
        $this->assertTrue(Route::has('laravel_passport'));
        $this->assertTrue(Route::has('laravel_passport.logout'));
    }

}