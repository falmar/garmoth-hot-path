<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TestController extends Controller
{
    public function randomWait(Request $request, Response $response)
    {
        // sleep between 10ms to 2000ms
        $time = rand(10, 2000);

        usleep($time * 1000);

        return $response
            ->setContent("slept {$time}ms!")
            ->setStatusCode(200);
    }
}
