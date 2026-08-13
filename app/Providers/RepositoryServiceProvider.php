<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\ProjectRepositoryInterface;
use App\Repositories\ProjectRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ProjectRepositoryInterface::class, ProjectRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
