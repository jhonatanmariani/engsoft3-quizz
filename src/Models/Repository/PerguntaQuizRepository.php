<?php


namespace App\Models\Repository;


use App\Models\Entities\PerguntaQuiz;
use Doctrine\ORM\EntityRepository;

class PerguntaQuizRepository extends EntityRepository
{
    public function save(PerguntaQuiz $entity) {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
        return $entity;
    }
}