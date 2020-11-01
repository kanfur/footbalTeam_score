<?php

namespace App\Providers;

use App\Models\Team;
use App\Services\LeagueService;
use Illuminate\Support\ServiceProvider;

class LeagueServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(LeagueService::class, function ($app) {
            $teams = Team::get()->toArray();
            return new LeagueService($teams);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
