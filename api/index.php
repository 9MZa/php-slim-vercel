<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

// Include the lookupWord function here
function lookupWord($keyword)
{
    $curl = curl_init();

    $data = array(
        'word' => $keyword,
        'funcName' => 'lookupWord',
        'status' => 'lookup'
    );

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://dictionary.orst.go.th/func_lookup.php',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => http_build_query($data),
        CURLOPT_SSL_VERIFYPEER => false,
    ));

    $response = curl_exec($curl);

    if ($response === false) {
        return 'cURL Error: ' . curl_error($curl);
    } else {
        return $response;
    }

    curl_close($curl);
}

$app->get("/", function (Request $request, Response $response, $args) {
    $response->getBody()->write("<h1>Hello World</h1>");
    return $response;
});

// Create a route to handle the POST request for keyword lookup
$app->post('/lookup', function (Request $request, Response $response, $args) {
    $data = $request->getParsedBody();
    $keyword = $data['keyword'] ?? '';

    if (empty($keyword)) {
        $response = $response->withStatus(400);
        $response->getBody()->write('Keyword is required.');
    } else {
        $result = lookupWord($keyword);
        $response->getBody()->write($result);
    }

    return $response; // Corrected line
});

$app->run();
