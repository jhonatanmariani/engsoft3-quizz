<?php

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

$app->get('/api/quiz/', fn(Request $request, Response $response) => $this->QuizController->getQuizSearch($request, $response));

$app->post('/api/quiz/', fn(Request $request, Response $response) => $this->QuizController->endQuiz($request, $response));
