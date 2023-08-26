<?php

namespace App\Models\Repository;

use App\Models\Entitys\User;
use App\Models\Repository\AbstractRepository;
use Doctrine\ORM\EntityManager;

class UserRepository extends AbstractRepository
{
    public function __construct(?EntityManager $em = null)
    {
        parent::__construct(User::class, $em);
    }
}