<?php

namespace App\Models\Service;

use App\Models\Entitys\User;
use App\Models\Repository\UserRepository;
use Doctrine\ORM\EntityManager;

class UserService extends AbstractService
{
    public function __construct(?EntityManager $em = null)
    {
        parent::__construct(UserRepository::class, $em);
    }

    public function registerUser(User $user)
    {
        $userCheck = $this->getRepository()->findOneBy(['email' => $user->getEmail()]);

        if($userCheck instanceof User){
            return null;
        }

        return $this->save($user);
    }
}