<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::defaultView('pagination::default');
         // Set default pagination size
         Paginator::defaultSimpleView('pagination::simple-default');
         Paginator::defaultView('pagination::default');
         Paginator::useBootstrapFive(); // Optional: if you want to use Bootstrap 5 styling


    }
}
