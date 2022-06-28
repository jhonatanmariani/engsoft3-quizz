<?php


namespace App\Controllers;


use App\Models\Entities\Pergunta;
use App\Models\Entities\PerguntaQuiz;
use App\Models\Entities\Quiz;
use App\Models\Entities\ResultadoQuiz;
use App\Models\Entities\UserQuiz;
use Slim\Http\Request;
use Slim\Http\Response;

class RegisterController extends Controller
{
    public function index(Request $request, Response $response) {
        $user = $this->getLogged();
        return $this->renderer->render($response, 'default.phtml', ['page' => 'dashboard/index.phtml',
            'user' => $user]);
    }

    public function indexRegisterUsuario(Request $request, Response $response) {
        $user = $this->getLogged();
        return $this->renderer->render($response, 'default.phtml', ['page' => 'cadastros/aluno.phtml',
            'user' => $user]);
    }

    public function indexRegisterQuiz(Request $request, Response $response) {
        $user = $this->getLogged();
        return $this->renderer->render($response, 'default.phtml', ['page' => 'cadastros/quiz.phtml',
            'user' => $user]);
    }

    public function indexRegisterNewQuiz(Request $request, Response $response) {
        $user = $this->getLogged();
        $perguntas = $this->em->getRepository(Pergunta::class)->findAll();
        return $this->renderer->render($response, 'default.phtml', ['page' => 'cadastros/novo-quiz.phtml',
            'user' => $user, 'perguntas' => $perguntas]);
    }

    public function indexNovoUsuario(Request $request, Response $response) {
        return $this->renderer->render($response, 'default2.phtml', ['page' => 'cadastros/novo-usuario.phtml']);
    }

    public function registerUsuario(Request $request, Response $response) {
        try {
            $data = (array)$request->getParams();
            $user = new UserQuiz();
            $user->setEmail($data['email'])
                ->setMatricula($data['matricula'] ?? '')
                ->setName($data['name'])
                ->setPassword($data['password'])
                ->setTipoUsuario($data['tipo']);
            $this->em->getRepository(UserQuiz::class)->save($user);
            return $response->withJson([
                'status' => 'ok',
                'message' => 'Usuário cadastrado com sucesso!'
            ])->withHeader('Content-Type','application/json');
        } catch (\Exception $e) {
            return $response->withJson([
                'status' => 'error',
                'message' => $e->getMessage()
            ])->withStatus(500);
        }
    }

    public function registerQuiz(Request $request, Response $response) {
        try {
            $data = (array)$request->getParams();
            $perguntas = (array)$request->getParam('perguntas');
            $quiz = new Quiz();
            $quiz->setName($data['name'] ?? '')
                ->setDificuldade($data['dificuldade'] ?? '');
            foreach ($perguntas as $p) {
                $perguntaQuiz = new PerguntaQuiz();
                $perguntaQuiz->setPergunta($this->em->getReference(Pergunta::class, $p));
                $quiz->addPergunta($perguntaQuiz);
            }
            $this->em->getRepository(Quiz::class)->save($quiz);
            return $response->withJson([
                'status' => 'ok',
                'message' => 'Quiz cadastrado com sucesso!'
            ])->withHeader('Content-Type','application/json');
        } catch (\Exception $e) {
            return $response->withJson([
                'status' => 'error',
                'message' => $e->getMessage()
            ])->withStatus(500);
        }
    }

    public function getUsuarios(Request $request, Response $response) {
        $tipo = $request->getAttribute('route')->getArgument('tipo');
        $users = $this->em->getRepository(UserQuiz::class)->findBy(['tipoUsuario' => $tipo]);
        $array = [];
        foreach ($users as $u) {
            $array[] = ['id' => $u->getId(), 'name' => $u->getName(), 'email' => $u->getEmail(),
                'tipoUsuario' => $u->getTipoUsuario()];
        }
        return $response->withJson([
            'status' => 'ok',
            'message' => $array,
        ])->withHeader('Content-Type','application/json');
    }
}