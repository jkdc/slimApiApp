<?php


use Slim\Http\Request;
use Slim\Http\Response;


/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         version="1.0.0",
 *         title="Slim API",
 *         description="CRUD for manage recipes",
 *         @OA\Contact(
 *             email="joaquincardosobuzon@gmail.com"
 *         ),
 *     ),
 *     @OA\Server(
 *         url="http://slimapp.loc"
 *     ),
 * )
 */

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

