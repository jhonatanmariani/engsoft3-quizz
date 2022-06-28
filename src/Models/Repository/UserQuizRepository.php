<?php


namespace App\Models\Repository;


use App\Models\Entities\UserQuiz;
use Doctrine\ORM\EntityRepository;

class UserQuizRepository extends EntityRepository
{

    public function save(UserQuiz $entity) {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
        return $entity;
    }

    public function login(string $email, string $password)
    {
        $user = $this->findOneBy(['email' => $email, 'password' => $password]);
        if (!$user) {
            throw new \Exception('Usuário ou senha inválidos.');
        }
        return $user;
    }

}