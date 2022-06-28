<?php


namespace App\Controllers;
use App\Models\Entities\Pergunta;
use App\Models\Entities\PerguntaQuiz;
use App\Models\Entities\Quiz;
use App\Models\Entities\ResultadoQuiz;
use App\Models\Entities\UserQuiz;
use Slim\Http\Request;
use Slim\Http\Response;

class QuizController extends Controller
{
    public function index(Request $request, Response $response) {
        $user = $this->getLogged();
        return $this->renderer->render($response, 'default.phtml', ['page' => 'quiz/index.phtml',
            'user' => $user]);
    }

    public function indexResultados(Request $request, Response $response) {
        $user = $this->getLogged();
        $resultados = $this->em->getRepository(ResultadoQuiz::class)->findBy([],['result' => 'desc']);
        if($user->getTipoUsuario() == 0) {
            $resultados = $this->em->getRepository(ResultadoQuiz::class)->findBy(['userQuiz' => $user->getId()],['result' => 'desc']);
        }
        return $this->renderer->render($response, 'default.phtml', ['page' => 'quiz/resultadoIndex.phtml',
            'user' => $user, 'resultados' => $resultados]);
    }

    public function indexPergunta(Request $request, Response $response) {
        $user = $this->getLogged();
        $id = $request->getAttribute('route')->getArgument('id');
        $count = $request->getAttribute('route')->getArgument('count');
        $quiz = $this->em->getRepository(Quiz::class)->find($id);
        $perguntas = $quiz->getPerguntas();
        $array = [];
        $i = 0;
        foreach ($perguntas as $p) {
            $array[$i]['descricao'] = [$p->getPergunta()->getDescricao()];
            $array[$i]['alternativa1'] = [$p->getPergunta()->getAlternativa1()];
            $array[$i]['alternativa2'] = [$p->getPergunta()->getAlternativa2()];
            $array[$i]['alternativa3'] = [$p->getPergunta()->getAlternativa3()];
            $array[$i]['alternativa4'] = [$p->getPergunta()->getAlternativa4()];
            $array[$i]['alternativa5'] = [$p->getPergunta()->getAlternativa5()];
            $i++;
        }
        $array = json_encode($array);
        return $this->renderer->render($response, 'default.phtml', ['page' => 'quiz/indexPergunta.phtml',
            'user' => $user, 'quiz' => $quiz, 'perguntas' => $array]);
    }

    public function getQuiz(Request $request, Response $response) {
        $quiz = $this->em->getRepository(Quiz::class)->findAll();
        $array = [];
        foreach ($quiz as $q) {
            $array[] = ['id' => $q->getId(), 'name' => $q->getName(), 'dificuldade' => $q->getDificuldade()];
        }
        return $response->withJson([
            'status' => 'ok',
            'message' => $array
        ])->withHeader('Content-Type','application/json');
    }

    public function getQuizSearch(Request $request, Response $response) {
        $filter = $request->getQueryParams();
        $quiz = $this->em->getRepository(Quiz::class)->findAll();
        if($filter['dificuldade']) $quiz = $this->em->getRepository(Quiz::class)->findBy(['dificuldade' => $filter['dificuldade']],['id' => 'desc']);
        $array = [];
        foreach ($quiz as $q) {
            $array[] = ['id' => $q->getId(), 'name' => $q->getName(), 'dificuldade' => $q->getDificuldade()];
        }
        $total = count($array);
        return $response->withJson([
            'status' => 'ok',
            'message' => $array,
            'total' => $total
        ])->withHeader('Content-Type','application/json');
    }

    public function endQuiz(Request $request, Response $response) {
        try {
            $data = (array)$request->getParams();
            $respostas = $request->getParam('respostas');
            $pontos = 0;
            $valor = 10 / count($respostas);
            $quiz = $this->em->getReference(Quiz::class, $data['quizId']);
            $perguntas = $quiz->getPerguntas();
            $i = 0;
            foreach ($perguntas as $p) {
                if($respostas[$i] == $p->getPergunta()->getAlternativaCorreta()) {
                    $pontos++;
                }
                $i++;
            }
            $resultadoQuiz = new ResultadoQuiz();
            $resultadoQuiz->setQuiz($quiz)
                ->setResult($pontos*$valor)
                ->setUserQuiz($this->getLogged());
            $this->em->getRepository(ResultadoQuiz::class)->save($resultadoQuiz);
            return $response->withJson([
                'status' => 'ok',
                'message' => 'Quiz registrado com sucesso',
            ])->withHeader('Content-Type','application/json');
        } catch (\Exception $e) {
            return $response->withJson([
                'status' => 'error',
                'message' => $e->getMessage(),
            ])->withStatus(500);
        }
    }
}