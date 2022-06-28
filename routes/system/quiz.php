<?php

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

$app->get('/quiz/', fn(Request $request, Response $response) => $this->QuizController->index($request, $response));

$app->get('/quiz/resultados/', fn(Request $request, Response $response) => $this->QuizController->indexResultados($request, $response));

$app->get('/quiz/jogar/{id}/{count}/', fn(Request $request, Response $response) => $this->QuizController->indexPergunta($request, $response));
