<?php

namespace App\Providers;

use App\Repositories\EloquentLeadRepository;
use App\Repositories\LeadRepositoryContract;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(LeadRepositoryContract::class, EloquentLeadRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
