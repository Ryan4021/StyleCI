<?php

/*
 * This file is part of StyleCI.
 *
 * (c) Graham Campbell <graham@mineuk.com>
 * (c) Joseph Cohen <joseph.cohen@dinkbit.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace StyleCI\StyleCI\Providers;

use Illuminate\Support\ServiceProvider;
use StyleCI\StyleCI\Http\Middleware\Authenticate;
use StyleCI\StyleCI\Models\User;

/**
 * This is the app service provider class.
 *
 * @author Graham Campbell <graham@mineuk.com>
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @param \Illuminate\Bus\Dispatcher $dispatcher
     *
     * @return void
     */
    public function boot(Dispatcher $dispatcher)
    {
        User::setStripeKey($this->app->config->get('services.stripe.key'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerAuthenticate();
    }

    /**
     * Register the auth middleware.
     *
     * @return void
     */
    protected function registerAuthenticate()
    {
        $this->app->singleton(Authenticate::class, function ($app) {
            $auth = $app['auth.driver'];
            $allowed = $app->config->get('styleci.allowed', []);

            return new Authenticate($auth, $allowed);
        });
    }
}
