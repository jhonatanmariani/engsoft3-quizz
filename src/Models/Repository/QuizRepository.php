<?php


namespace App\Models\Repository;


use App\Models\Entities\Quiz;
use Doctrine\ORM\EntityRepository;

class QuizRepository extends EntityRepository
{
    public function save(Quiz $entity) {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
        return $entity;
    }
}