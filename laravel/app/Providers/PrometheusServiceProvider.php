<?php


namespace App\Providers;


use App\Http\Middleware\PrometheusMiddleware;
use Illuminate\Support\ServiceProvider;
use Prometheus\CollectorRegistry;
use Prometheus\Storage\Redis as RedisAdapter;
use Psr\Container\ContainerInterface;

class PrometheusServiceProvider extends ServiceProvider
{
    public function register()
    {
        // https://laravel.com/docs/8.x/middleware#terminable-middleware
        // same middleware instance
        $this->app->singleton(PrometheusMiddleware::class);

        $this->app->singleton(
            CollectorRegistry::class,
            function (ContainerInterface $container) {
                return new CollectorRegistry(
                    new RedisAdapter(
                        [
                            'host' => $_ENV['REDIS_HOST'],
                            'port' => $_ENV['REDIS_PORT'],
                        ]
                    )
                );
            }
        );
    }
}
