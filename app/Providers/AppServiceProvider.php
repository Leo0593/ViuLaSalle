<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;      // Importar View
use App\Models\NivelEducativo;             // Importar modelo


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
        Paginator::useBootstrap();

        View::composer('layouts.redirecciones', function ($view) {
            $niveles = NivelEducativo::all();
            $view->with('niveles', $niveles);
        });
    }
}
