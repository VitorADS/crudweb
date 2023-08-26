<?php

namespace App\Session\Auth;

use App\Models\Entitys\User;
use App\Models\Service\UserService;

class Login{

    /**
     * @return void
     */
    private static function init(): void
    {
        if(session_status() != PHP_SESSION_ACTIVE){
            session_start();
        }
    }

    /**
     * @param User $user
     * @return bool
     */
    public static function login(User $user): bool
    {
        self::init();

        $_SESSION['user'] = [
            'id' => $user->getId(),
            'name' => $user->getName(),
            'email' => $user->getEmail()
        ];

        return true;
    }

    /**
     * @return boolean
     */
    public static function isLogged(): bool
    {
        self::init();
        $user = false;

        if(isset($_SESSION['user']['id'])){
            $user = (new UserService())->getRepository()->find((int) $_SESSION['user']['id']);
        }

        if($user === false){
            self::logout();
        }

        return $user instanceof User;
    }

    /**
     * 
     */
    public static function logout()
    {
        self::init();

        unset($_SESSION['user']);
        return true;
    }

    /**
     * @param User $user
     * @return bool
     */
    public static function checkUser(User $user): bool
    {
        if(self::isLogged() && $user->getId() === $_SESSION['user']['id']){
            return true;
        }

        return false;
    }

    /**
     * @return ?int
     */
    public static function getUser(): ?int
    {
        if(self::isLogged()){
            return $_SESSION['user']['id'];
        }

        return null;
    }
}