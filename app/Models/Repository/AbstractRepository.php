<?php

namespace App\Models\Repository;

use App\Models\Entitys\AbstractEntity;
use Config\EntityManager\EntityManagerCreator;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Exception;

class AbstractRepository extends EntityRepository
{

    public function __construct($class, ?EntityManager $em = null)
    {
        if(!$em) $em = EntityManagerCreator::getEntityManager();
        $class = $em->getClassMetadata($class);

        parent::__construct($em, $class);
    }

    /**
     * @param AbstractEntity $entity
     * @return AbstractEntity
     */
    public function save(AbstractEntity $entity): AbstractEntity
    {
        $entityManager = $this->getEntityManager();
        $entityManager->beginTransaction();
        
        try{
            $entityManager->persist($entity);
            $entityManager->flush();
            $entityManager->getConnection()->commit();

            $entityManager->refresh($entity);
            return $entity;
        } catch(Exception $e){
            $entityManager->getConnection()->rollback();
            throw $e;
        }
    }

    /**
     * @param AbstractEntity $entity
     * @return int
     */
    public function remove(AbstractEntity $entity): int
    {
        $entityManager = $this->getEntityManager();

        if(is_numeric($entity)){
            $entity = $this->find((int) $entity);
        }
        
        $id = $entity->getId();

        $entityManager->beginTransaction();
        try{
            $entityManager->remove($entity);
            $entityManager->flush();
            $entityManager->getConnection()->commit();

            return $id;
        }catch(Exception $e){
            $entityManager->getConnection()->rollback();
            throw $e;
        }
    }

    /**
     * @return EntityManager
     */
    public function getEm(): EntityManager
    {
        return $this->getEntityManager();
    }
}