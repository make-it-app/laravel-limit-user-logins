<?php

namespace MakeIT\LoginLimiter;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

/**
 * Class LoginLimiterServiceProvider
 * @package MakeIT\LoginLimiter
 */
class LoginLimiterServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom( __DIR__ . '/config.php', 'login_limiter' );
        Event::listen(
            \Illuminate\Auth\Events\Login::class,
            \MakeIT\LoginLimiter\LogoutOtherDevicesListener::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ( $this->app->runningInConsole() )
        {
            $this->publishes( [
                __DIR__ . '/config.php' => config_path( 'login_limiter.php' ),
            ], 'config' );
        }
    }

}
