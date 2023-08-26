<?php

namespace App\Models\Service;

use App\Models\Entitys\AbstractEntity;
use App\Models\Repository\AbstractRepository;
use Doctrine\ORM\EntityManager;

abstract class AbstractService
{
    private AbstractRepository $repository;

    public function __construct(string $repository, ?EntityManager $em = null)
    {
        $this->setRepository($repository, $em);
    }

    /**
     * @return AbstractRepository
     */
    public function getRepository(): AbstractRepository
    {
        return $this->repository;
    }

    /**
     * @param AbstractEntity $entity
     * @return AbstractEntity
     */
    public function save(AbstractEntity $entity): AbstractEntity
    {
        return $this->getRepository()->save($entity);
    }

    /**
     * @param AbstractEntity $entity
     * @return int
     */
    public function remove(AbstractEntity $entity): int
    {
        return $this->getRepository()->remove($entity);
    }

    /**
     * @param string $repository
     * @param ?EntityManager $em = null
     * @return void
     */
    private function setRepository(string $repository, ?EntityManager $em = null): void
    {
        $this->repository = new $repository($em);
    }
}