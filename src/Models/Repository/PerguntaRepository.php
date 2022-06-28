<?php


namespace App\Models\Repository;


use App\Models\Entities\Pergunta;
use Doctrine\ORM\EntityRepository;

class PerguntaRepository extends EntityRepository
{
    public function save(Pergunta $entity) {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
        return $entity;
    }
}