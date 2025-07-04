<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use App\Repositories\TodoRepositoryInterface;
use App\Repositories\EloquentTodoRepository;

/**
 * The main application service provider.
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services and bindings.
     */
    public function register(): void
    {
        // Bind the Todo repository interface to its Eloquent implementation.
        $this->app->bind(
            TodoRepositoryInterface::class,
            EloquentTodoRepository::class
        );

        // Register other application services or singletons here if needed.
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set Vite prefetch concurrency (improves asset loading performance).
        Vite::prefetch(concurrency: 3);

        // You can add additional boot logic here if needed.
    }
}
