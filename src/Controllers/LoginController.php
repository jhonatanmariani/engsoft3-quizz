<?php


namespace App\Controllers;
use App\Helpers\Session;
use App\Models\Entities\Aluno;
use App\Models\Entities\User;
use App\Models\Entities\UserQuiz;
use Slim\Http\Request;
use Slim\Http\Response;

class LoginController extends Controller
{
    public function login(Request $request, Response $response)
    {
        if (Session::get(Session::get('accessType'))) $this->redirect();
        return $this->renderer->render($response, 'login/login.phtml');
    }

    public function index(Request $request, Response $response) {
        $this->renderer->render($response, 'default.phtml', ['page' => 'home/index.phtml', 'session' => 'home']);
    }

    public function autentication(Request $request, Response $response)
    {
        try {
            $data = (array)$request->getParams();
            $user = $this->em->getRepository(UserQuiz::class)->login($data['login'], $data['password']);
//            $permissions = $this->em->getRepository(EmployeeFunctionality::class)->findBy(['employee' => $user->getId()],['systemFunctionality' => 'asc']);
//            $array = [];
//            foreach ($permissions as $p) {
//                $array[] = $p->getSystemFunctionality()->getId();
//            }
            Session::set('accessType', USER_SESSION);
//            Session::set('permissions', $array);
            Session::set(Session::get('accessType'), $user);
            $redirect = Session::get('redirect');
            if ($redirect) {
                Session::forgot('redirect');
                $redirect = substr($redirect, 0, 1) == '/' ? substr($redirect, 1) : $redirect;
                $this->redirect($redirect);
                exit;
            }
        } catch (\Exception $e) {
            Session::set('errorMsg', $e->getMessage());
            header("Refresh: 0");
            exit;
        }
        $this->redirect();
    }

    public function recoverPassword(Request $request, Response $response, int $type = 1)
    {
        return $this->renderer->render($response, 'login/recover-password.phtml', ['type' => $type, 'valid' => true]);
    }

    public function changePassword(Request $request, Response $response)
    {
        $id = $request->getAttribute('route')->getArgument('id');
        $valid = true;
        $recover = $this->em->getRepository(RecoverPassword::class)->findOneBy(['token' => $id, 'used' => 0]);
        if (!$recover) $valid = false;
        return $this->renderer->render($response, 'login/change-password.phtml', ['id' => $id, 'valid' => $valid]);
    }

    public function savePassword(Request $request, Response $response)
    {
        try {
            $data = (array)$request->getParams();
            $recover = $this->em->getRepository(RecoverPassword::class)->findOneBy(['token' => $data['id'], 'used' => 0]);
            if (!$recover) throw new \Exception('Token Inválido');
            $fields = [
                'password2' => 'Confirme a senha',
                'password' => 'Senha',
            ];
            Validator::requireValidator($fields, $data);
            Validator::validatePassword($data);
            $employee = $recover->getEmployee();
            $employee->setPassword(password_hash($data['password'], PASSWORD_ARGON2I));
            $this->em->getRepository(Employee::class)->save($employee);
            $recover->setUsed(1);
            $this->em->getRepository(RecoverPassword::class)->save($recover);
            return $response->withJson([
                'status' => 'ok',
                'message' => 'Senha alterada com sucesso.',
            ], 201)
                ->withHeader('Content-type', 'application/json');
        } catch (\Exception $e) {
            return $response->withJson([
                'status' => 'error',
                'message' => $e->getMessage(),
            ])->withStatus(500);
        }
    }

    public function saveRecover(Request $request, Response $response)
    {
        try {
            $data = (array)$request->getParams();
            $fields = [
                'email' => 'Email',
            ];
            Validator::requireValidator($fields, $data);
            $user = $this->em->getRepository(Employee::class)->findOneBy(['email' => $data['email'], 'active' => 1]);
            if (!$user) throw new \Exception('Email inválido.');
            $recoverPassword = new RecoverPassword();
            $recoverPassword->setToken(Utils::generateToken())
                ->setEmployee($user);
            $this->em->getRepository(RecoverPassword::class)->save($recoverPassword);
            $msg = "<p>Olá {$user->getName()}.</p>
                    <p>Segue <a href='{$this->baseUrl}recuperar/{$recoverPassword->getToken()}' target='_blank'>link</a> para redefinição de senha.</p>";
            Email::send($user->getEmail(), $user->getName(), 'Recuperação de Senha - ClinCard', $msg);
            return $response->withJson([
                'status' => 'ok',
                'message' => 'Foi enviado um e-mail para redefinição de senha.',
            ], 201)
                ->withHeader('Content-type', 'application/json');
        } catch (\Exception $e) {
            return $response->withJson([
                'status' => 'error',
                'message' => $e->getMessage(),
            ])->withStatus(500);
        }
    }

    public function logout(Request $request, Response $response)
    {
        Session::forgot(Session::get('accessType'));
        header("Location: {$this->baseUrl}login");
        exit;
    }
}