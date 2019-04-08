<?php


use Slim\Http\Request;
use Slim\Http\Response;


// Routes
require __DIR__ . '/../app/route/recipe.php';

/**
 * @OA\Get(
 *   path="/swagger/doc",
 *   summary="Get swagger documentacion",
 *   @OA\Response(
 *     response=200,
 *     description="Get Swagger doc"
 *   ),
 *   @OA\Response(
 *     response="default",
 *     description="an ""unexpected"" error"
 *   )
 * )
 */
$app->get('/swagger/doc', function (Request $request, Response $response, array $args) {
    $openapi = \OpenApi\scan('/home/app/slimApp/', ['exclude' => 'vendor']);
    header('Content-Type: application/x-yaml');
    echo $openapi->toYaml();
});

