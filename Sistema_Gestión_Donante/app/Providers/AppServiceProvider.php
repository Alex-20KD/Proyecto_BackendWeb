<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\DonanteRepositoryInterface;
use App\Repositories\DonanteRepository;
use App\Repositories\Interfaces\MascotaDonadaRepositoryInterface;
use App\Repositories\MascotaDonadaRepository;
use App\Repositories\Interfaces\HistorialColaboracionRepositoryInterface;
use App\Repositories\HistorialColaboracionRepository;
use App\Repositories\Interfaces\InformacionContactoRepositoryInterface;
use App\Repositories\InformacionContactoRepository;
use App\Repositories\Interfaces\VerificacionDonanteRepositoryInterface;
use App\Repositories\VerificacionDonanteRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Registrar las interfaces con sus implementaciones
        $this->app->bind(DonanteRepositoryInterface::class, DonanteRepository::class);
        $this->app->bind(MascotaDonadaRepositoryInterface::class, MascotaDonadaRepository::class);
        $this->app->bind(HistorialColaboracionRepositoryInterface::class, HistorialColaboracionRepository::class);
        $this->app->bind(InformacionContactoRepositoryInterface::class, InformacionContactoRepository::class);
        $this->app->bind(VerificacionDonanteRepositoryInterface::class, VerificacionDonanteRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
