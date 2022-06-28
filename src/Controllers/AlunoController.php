<?php


namespace App\Controllers;


use App\Models\Entities\Aluno;
use Slim\Http\Request;
use Slim\Http\Response;

class AlunoController extends Controller
{

    public function index(Request $request, Response $response) {
        $user = $this->getLogged();
        return $this->renderer->render($response, 'default.phtml', ['page' => 'cadastros/aluno.phtml',
            'user' => $user]);
    }

    public function registerAluno(Request $request, Response $response) {
        try {
            $data = (array)$request->getParams();
            $aluno = new Aluno();
            $aluno->setEmail($data['email'])
                ->setMatricula($data['matricula'])
                ->setName($data['name'])
                ->setPassword($data['password']);
            $this->em->getRepository(Aluno::class)->save($aluno);
            return $response->withJson([
                'status' => 'ok',
                'message' => 'Aluno cadastrado com sucesso!'
            ])->withHeader('Content-Type','application/json');
        } catch (\Exception $e) {
            return $response->withJson([
                'status' => 'error',
                'message' => $e->getMessage()
            ])->withStatus(500);
        }
    }

    public function getAlunos(Request $request, Response $response) {
        $alunos = $this->em->getRepository(Aluno::class)->findAll();
        $array = [];
        foreach ($alunos as $a) {
            $array[] = ['id' => $a->getId(), 'name' => $a->getName(), 'email' => $a->getEmail()];
        }
        return $response->withJson([
            'status' => 'ok',
            'message' => $array,
        ])->withHeader('Content-Type','application/json');
    }
}