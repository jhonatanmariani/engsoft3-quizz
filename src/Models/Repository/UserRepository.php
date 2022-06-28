<?php


namespace App\Models\Repository;


use App\Models\Entities\User;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function save(User $entity) {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
        return $entity;
    }

    public function deleteById(int $id) {
        $pdo = $this->getEntityManager()->getConnection()->getWrappedConnection();
        $sql = "DELETE FROM users where users.id = :id";
        $stm = $pdo->prepare($sql);
        $stm->execute([':id' => $id]);
        return $stm->fetch();
    }

    public function list($limit, $offset, array $filter, int $id = null) {
        $params = [];
        $where = $this->generateWhere($filter, $params, $id);
        $pdo = $this->getEntityManager()->getConnection()->getWrappedConnection();
        $sql = "SELECT users.id, users.name, users.email, users.phone, users.path FROM users 
                WHERE 1 = 1 {$where}
                ORDER BY name ASC";
        $stm = $pdo->prepare($sql);
        $stm->execute($params);
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function countUsers(array $filter, $id = null) {
        $params = [];
        $where = $this->generateWhere($filter, $params, $id);
        $pdo = $this->getEntityManager()->getConnection()->getWrappedConnection();
        $sql = "SELECT count(users.id) AS total FROM users 
                WHERE 1 = 1 {$where}";
        $stm = $pdo->prepare($sql);
        $stm->execute($params);
        return $stm->fetch()['total'];
    }

    private function generateWhere(array $filter, array &$params, int $id = null) {
        $where = '';

        if($id) {
            $where .= ' AND users.id LIKE :id';
            $params[':id'] = $id;
        }

        if($filter['name']) {
            $where .= ' AND users.name LIKE :name';
            $params[':name'] = "%{$filter['name']}%";
        }

        if($filter['email']) {
            $where .= ' AND users.email LIKE :email';
            $params[':email'] = $filter['email'];
        }

        return $where;
    }
}