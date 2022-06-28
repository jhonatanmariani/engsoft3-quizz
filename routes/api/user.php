<?php

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

$app->get('/api/usuario/[{id}/]', fn(Request $request, Response $response) => $this->UserTwoController->getUsers($request, $response));

$app->post('/api/usuario/', fn(Request $request, Response $response) => $this->UserTwoController->registerUser($request, $response));

$app->post('/api/usuario/foto/', fn(Request $request, Response $response) => $this->UserTwoController->savePhoto($request, $response));

$app->put('/api/usuario/{id}/', fn(Request $request, Response $response) => $this->UserTwoController->registerUser($request, $response));

$app->delete('/api/usuario/{id}/', fn(Request $request, Response $response) => $this->UserTwoController->deleteUser($request, $response));
