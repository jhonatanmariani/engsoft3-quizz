<?php


namespace App\Models\Repository;


use App\Models\Entities\ResultadoQuiz;
use Doctrine\ORM\EntityRepository;

class ResultadoQuizRepository extends EntityRepository
{
    public function save(ResultadoQuiz $entity) {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
        return $entity;
    }
}