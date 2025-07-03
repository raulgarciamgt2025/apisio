<?php

namespace App\Providers;

use App\Interfaces\EmpresaRepositoryInterface;
use App\Repositories\EmpresaRepository;
use App\Interfaces\ModuloRepositoryInterface;
use App\Repositories\ModuloRepository;
use App\Interfaces\MenuRepositoryInterface;
use App\Repositories\MenuRepository;
use App\Interfaces\OpcionRepositoryInterface;
use App\Repositories\OpcionRepository;

use App\Interfaces\RolRepositoryInterface;
use App\Repositories\RolRepository;
use App\Interfaces\RolopcionRepositoryInterface;
use App\Repositories\RolopcionRepository;
use App\Interfaces\RolusuarioRepositoryInterface;
use App\Repositories\RolusuarioRepository;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Interfaces\PeriodoRepositoryInterface;
use App\Repositories\PeriodoRepository;
use App\Interfaces\TipoProcesoRepositoryInterface;
use App\Repositories\TipoProcesoRepository;
use App\Interfaces\AreaRepositoryInterface;
use App\Repositories\AreaRepository;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(EmpresaRepositoryInterface::class, EmpresaRepository::class);
        $this->app->bind(ModuloRepositoryInterface::class, ModuloRepository::class);
        $this->app->bind(MenuRepositoryInterface::class, MenuRepository::class);
        $this->app->bind(OpcionRepositoryInterface::class, OpcionRepository::class);
        $this->app->bind(RolRepositoryInterface::class, RolRepository::class);
        $this->app->bind(RolopcionRepositoryInterface::class, RolopcionRepository::class);
        $this->app->bind(RolusuarioRepositoryInterface::class, RolusuarioRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(PeriodoRepositoryInterface::class, PeriodoRepository::class);
        $this->app->bind(TipoProcesoRepositoryInterface::class, TipoProcesoRepository::class);
        $this->app->bind(AreaRepositoryInterface::class, AreaRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
