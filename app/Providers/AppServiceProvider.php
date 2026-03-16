<?php

namespace App\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (! Collection::hasMacro('links')) {
            Collection::macro('links', fn () => '');
        }

        if (! Collection::hasMacro('withQueryString')) {
            Collection::macro('withQueryString', fn () => $this);
        }

        if (! Collection::hasMacro('appends')) {
            Collection::macro('appends', fn () => $this);
        }

        if (! Collection::hasMacro('total')) {
            Collection::macro('total', fn () => $this->count());
        }

        if (! Collection::hasMacro('perPage')) {
            Collection::macro('perPage', fn () => $this->count());
        }

        if (! Collection::hasMacro('currentPage')) {
            Collection::macro('currentPage', fn () => 1);
        }

        if (! Collection::hasMacro('hasPages')) {
            Collection::macro('hasPages', fn () => false);
        }

        if (! Collection::hasMacro('firstItem')) {
            Collection::macro('firstItem', fn () => $this->isEmpty() ? null : 1);
        }

        if (! Collection::hasMacro('lastItem')) {
            Collection::macro('lastItem', fn () => $this->isEmpty() ? null : $this->count());
        }

        View::composer('*', function () {
            if (app()->bound('view.flash.success')) {
                return;
            }

            $flashSuccess = session()->pull('success');
            app()->instance('view.flash.success', $flashSuccess);
            View::share('flashSuccess', $flashSuccess);
        });
    }
}
