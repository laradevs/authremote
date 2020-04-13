<?php


namespace LaraDevs\AuthRemote;

use Illuminate\Support\ServiceProvider;
use LaraDevs\AuthRemote\ServiceProviders\RouteServiceProvider;
use SocialiteProviders\LaravelPassport\LaravelPassportExtendSocialite;
use SocialiteProviders\Manager\SocialiteWasCalled;

class MainServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        SocialiteWasCalled::class => [
            LaravelPassportExtendSocialite::class
        ]
    ];

    /**
     * void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/rest-provider.php' => config_path('rest-provider.php'),
        ], 'config');

        $this->app['auth']->provider(
            'rest-users',
            function ($app, array $config) {
                $appConfig = $app['config']['rest-provider'];
                $appConfig['model'] = $config['model'];
                $appConfig['headers'] = $this->addAuthorizationToken($appConfig);

                return new RestUserProvider($appConfig, $app['hash'], $app['cache']);
            }
        );
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/rest-provider.php', 'rest-provider');
    }

    /**
     * @param array $appConfig
     * @return array
     * @throws RestException
     */
    private function addAuthorizationToken(array $appConfig)
    {
        $token = session()->get($appConfig['name_session_rest']);
        if (is_null($token)) {
            throw new RestException('Empty token in session.');
        }

        return array_merge($appConfig['headers'], [
            'Authorization' => "Bearer $token",
        ]);
    }
}
