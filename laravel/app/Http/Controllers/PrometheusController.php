<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Prometheus\CollectorRegistry;
use Prometheus\RenderTextFormat;
use Psr\Container\ContainerInterface;

class PrometheusController extends Controller
{
    protected CollectorRegistry $collectorRegistry;

    public function __construct(ContainerInterface $container)
    {
        $this->collectorRegistry = $container->get(CollectorRegistry::class);
    }

    public function exposeMetrics(Request $request, Response $response)
    {
        // TODO: add basic auth or token

        $response->setContent(
            (new RenderTextFormat())->render(
                $this->collectorRegistry->getMetricFamilySamples()
            )
        );

        return $response
            ->setStatusCode(200)
            ->header('Content-Type', RenderTextFormat::MIME_TYPE);
    }
}
