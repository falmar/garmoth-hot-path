<?php


namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Prometheus\CollectorRegistry;
use Prometheus\Exception\MetricsRegistrationException;
use Psr\Container\ContainerInterface;

class PrometheusMiddleware
{
    protected float $startTime;
    protected float $endTime;
    protected CollectorRegistry $collectorRegistry;

    public function __construct(ContainerInterface $container)
    {
        $this->collectorRegistry = $container->get(CollectorRegistry::class);
    }

    public function handle(Request $request, Closure $next)
    {
        $this->startTime = microtime(true);
        $response        = $next($request);
        $this->endTime   = microtime(true);

        return $response;
    }

    /**
     * @param Request $request
     * @param Response $response
     */
    public function terminate(Request $request, Response $response)
    {
        try {
            $data = [
                'code'   => $response->getStatusCode(),
                'path'   => '/' . $request->route()->uri(),
                'method' => strtoupper($request->method()),
            ];

            $count     = $this->collectorRegistry->getOrRegisterCounter(
                'app',
                'http_requests_count',
                'request count',
                ['path', 'status', 'method']
            );
            $histogram = $this->collectorRegistry->getOrRegisterHistogram(
                'app',
                'http_requests_seconds',
                'requests latency',
                ['path', 'method'],
                [0.1, 0.25, 0.5, 0.75, 1, 1.5, 2]
            );

            $count->inc(
                [
                    $data['path'],
                    $data['code'],
                    $data['method'],
                ]
            );

            // seconds
            $histogram->observe(
                $this->endTime - $this->startTime,
                [
                    $data['path'],
                    $data['method'],
                ]
            );
        } catch (MetricsRegistrationException $exception) {
            // TODO: notify bugsnag or other error service?
        }
    }
}
