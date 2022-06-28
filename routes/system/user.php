<?php

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

$app->get('/', fn(Request $request, Response $response) => $this->RegisterController->index($request, $response));

//$app->get('/', fn(Request $request, Response $response) => $this->UserTwoController->index($request, $response));

$app->post('/usuario/', fn(Request $request, Response $response) => $this->UserTwoController->registerUser($request, $response));

$app->put('/usuario/{id}/', fn(Request $request, Response $response) => $this->UserTwoController->registerUser($request, $response));

$app->delete('/usuario/{id}/', fn(Request $request, Response $response) => $this->UserTwoController->deleteUser($request, $response));
