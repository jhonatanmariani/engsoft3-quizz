<?php


namespace App\Models\Repository;


use App\Models\Entities\Professor;
use Doctrine\ORM\EntityRepository;

class ProfessorRepository extends EntityRepository
{
    public function save(Professor $entity) {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
        return $entity;
    }
}