<?php


namespace App\Controllers;


use App\Models\Entities\Professor;
use Slim\Http\Request;
use Slim\Http\Response;
class ProfessorController extends Controller
{
    public function index(Request $request, Response $response) {
        return $this->renderer->render($response, 'default.phtml', ['page' => 'cadastros/professor.phtml']);
    }

    public function registerProfessor(Request $request, Response $response) {
        try {
            $data = (array)$request->getParams();
            $prof = new Professor();
            $prof->setEmail($data['email'])
                ->setName($data['name'])
                ->setPassword($data['password']);
            $this->em->getRepository(Professor::class)->save($prof);
            return $response->withJson([
                'status' => 'ok',
                'message' => 'Professor cadastrado com sucesso!'
            ])->withHeader('Content-Type','application/json');
        } catch (\Exception $e) {
            return $response->withJson([
                'status' => 'error',
                'message' => $e->getMessage()
            ])->withStatus(500);
        }
    }

    public function getProfessores(Request $request, Response $response) {
        $profs = $this->em->getRepository(Professor::class)->findAll();
        $array = [];
        foreach ($profs as $p) {
            $array[] = ['id' => $p->getId(), 'name' => $p->getName(), 'email' => $p->getEmail()];
        }
        return $response->withJson([
            'status' => 'ok',
            'message' => $array,
        ])->withHeader('Content-Type','application/json');
    }
}