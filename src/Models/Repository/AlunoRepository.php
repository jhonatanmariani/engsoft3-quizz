<?php


namespace App\Models\Repository;


use App\Models\Entities\Aluno;
use Doctrine\ORM\EntityRepository;

class AlunoRepository extends EntityRepository
{
    public function save(Aluno $entity) {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
        return $entity;
    }

    public function login(string $email, string $password)
    {
        $user = $this->findOneBy(['password' => $password]);
        if (!$user) {
            throw new \Exception('Usuário ou senha inválidos.');
        }
        return $user;
    }
}