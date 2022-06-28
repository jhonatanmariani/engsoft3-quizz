<?php

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

$app->post('/api/cadastros/aluno/', fn(Request $request, Response $response) => $this->AlunoController->registerAluno($request, $response));

$app->get('/api/cadastros/aluno/', fn(Request $request, Response $response) => $this->AlunoController->getAlunos($request, $response));

$app->get('/api/cadastros/usuario/{tipo}/', fn(Request $request, Response $response) => $this->AlunoController->getUsuarios($request, $response));

$app->post('/api/cadastros/usuario/', fn(Request $request, Response $response) => $this->RegisterController->registerUsuario($request, $response));

$app->post('/api/cadastros/quiz/', fn(Request $request, Response $response) => $this->RegisterController->registerQuiz($request, $response));

$app->post('/api/cadastros/professor/', fn(Request $request, Response $response) => $this->ProfessorController->registerProfessor($request, $response));

$app->post('/api/cadastros/pergunta/', fn(Request $request, Response $response) => $this->PerguntaController->registerPergunta($request, $response));

$app->get('/api/cadastros/pergunta/', fn(Request $request, Response $response) => $this->PerguntaController->getPerguntas($request, $response));

$app->get('/api/cadastros/professor/', fn(Request $request, Response $response) => $this->ProfessorController->getProfessores($request, $response));
