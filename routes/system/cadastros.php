<?php

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

$app->get('/cadastros/aluno/', fn(Request $request, Response $response) => $this->RegisterController->indexRegisterUsuario($request, $response));
$app->get('/cadastros/quiz/', fn(Request $request, Response $response) => $this->RegisterController->indexRegisterQuiz($request, $response));
$app->get('/cadastros/novo-quiz/', fn(Request $request, Response $response) => $this->RegisterController->indexRegisterNewQuiz($request, $response));
$app->get('/cadastros/novo-usuario/', fn(Request $request, Response $response) => $this->RegisterController->indexNovoUsuario($request, $response));
$app->get('/cadastros/professor/', fn(Request $request, Response $response) => $this->ProfessorController->index($request, $response));
$app->get('/cadastros/pergunta/', fn(Request $request, Response $response) => $this->PerguntaController->index($request, $response));
$app->get('/cadastros/pergunta/form/', fn(Request $request, Response $response) => $this->PerguntaController->registerPerguntaIndex($request, $response));
