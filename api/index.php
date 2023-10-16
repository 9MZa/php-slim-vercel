<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
  });
  
  $app->add(function ($request, $handler) {
    $response = $handler->handle($request);
    return $response
      ->withHeader('Access-Control-Allow-Origin', '*')
      ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
      ->withHeader('Access-Control-Allow-Methods', 'GET, OPTIONS');
  });
 
$app->get("/", function (Request $request, Response $response, $args) {
    $response->getBody()->write("<h1>Hello World</h1>");
    return $response;
});

$app->run();
