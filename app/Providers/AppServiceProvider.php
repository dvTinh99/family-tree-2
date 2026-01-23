<?php

namespace App\Providers;

use App\Models\Edge;
use App\Models\Node;
use App\Models\User;
use App\Repositories\EdgeRepository;
use App\Repositories\NodeRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepository::class, function ($app) {
            return new UserRepository($app->make(User::class));
        });

        $this->app->bind(NodeRepository::class, function ($app) {
            return new NodeRepository($app->make(Node::class));
        });

        $this->app->bind(EdgeRepository::class, function ($app) {
            return new EdgeRepository($app->make(Edge::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
