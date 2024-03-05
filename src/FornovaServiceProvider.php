<?php

namespace wdd\fornova;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Exceptions\NovaExceptionHandler;
use Laravel\Nova\Nova;

class FornovaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->gate();
        $this->routes();
        Nova::serving(function (ServingNova $event) {
            $this->authorization();
            $this->registerExceptionHandler();
            $this->resources();
            Nova::dashboards($this->dashboards());
        });
    }

    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });
    }
    protected function routes()
    {
        Nova::routes()
            ->withAuthenticationRoutes()
            ->withPasswordResetRoutes();
    }

    protected function resources()
    {
        Nova::resourcesIn(app_path('Nova'));
    }

    protected function authorization()
    {
        Nova::auth(function ($request) {
            return app()->environment('local') ||
            Gate::check('viewNova', [Nova::user($request)]);
        });
    }

    protected function dashboards()
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }

    protected function registerExceptionHandler()
    {
        app()->bind(ExceptionHandler::class, NovaExceptionHandler::class);
    }
}