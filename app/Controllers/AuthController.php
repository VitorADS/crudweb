<?php

namespace App\Controllers;

use App\Controllers\Pages\PageController;
use App\Http\Request;
use App\Models\Entitys\User;
use App\Models\Service\UserService;
use App\Session\Auth\Login;
use App\Utils\View;

class AuthController extends PageController
{

    /**
     * @param Request $request
     * @return string
     */
    public static function getStatus(Request $request): string{
        $queryParams = $request->getQueryParams();

        if(!isset($queryParams['status'])) return '';

        switch($queryParams['status']){
            case 'recorded':
                return AlertController::getSuccess('Registrado com sucesso!');
                break;
            case 'passwordNotMatch':
                return AlertController::getError('As senhas não coincidem!');
                break;
            case 'userNotFound':
                return AlertController::getError('E-mail ou senha incorretos!');
                break;
            case 'duplicatedEmail':
                return AlertController::getError('E-mail já cadastrado!');
                break;
            default:
                return '';
                break;
        }
    }

    /**
     * @param Request $request
     * @return string
     */
    public static function login(Request $request): string
    {
        $content = View::render('auth/formLogin', [
            'status' => self::getStatus($request)
        ]);

        return parent::getPage('Login', $content, false);
    }

    /**
     * @param Request $request
     * @param UserService $userService
     * @return string
     */
    public static function loginAction(Request $request, UserService $userService): void
    {
        $postVars = $request->getPostVars();
        $email = htmlspecialchars($postVars['email'], ENT_QUOTES) ?? '';
        $password = htmlspecialchars($postVars['password'], ENT_QUOTES) ?? '';

        $user = $userService->getRepository()->findOneBy(['email' => $email]);

        if($user instanceof User && password_verify($password, $user->getPassword())){
            Login::login($user);
            $request->getRouter()->redirect('/home');
        }

        $request->getRouter()->redirect('/?status=userNotFound');
    }

    /**
     * @param Request $request
     * @return string
     */
    public static function register(Request $request): string
    {
        $content = View::render('auth/formRegister', [
            'status' => self::getStatus($request)
        ]);

        return parent::getPage('Registre-se', $content, false);
    }

    /**
     * @param Request $request
     * @param UserService $userService
     * @return void
     */
    public static function registerAction(Request $request, UserService $userService): void
    {
        $postVars = $request->getPostVars();
        $name = htmlspecialchars($postVars['name'], ENT_QUOTES) ?? '';
        $email = htmlspecialchars($postVars['email'], ENT_QUOTES) ?? '';
        $password = htmlspecialchars($postVars['password'], ENT_QUOTES) ?? '';
        $passwordConfirmation = htmlspecialchars($postVars['password_confirmation'], ENT_QUOTES) ?? '';

        if($password !== $passwordConfirmation){
            $request->getRouter()->redirect('/register?status=passwordNotMatch');
        }

        $user = new User();
        $user->setName($name);
        $user->setEmail($email);
        $user->setPassword(password_hash($password, PASSWORD_DEFAULT));
        $user = $userService->registerUser($user);

        if($user === null){
            $request->getRouter()->redirect('/register?status=duplicatedEmail');
        }

        $request->getRouter()->redirect('/?status=recorded');
    }

    /**
     * @param Request $request
     * @return void
     */
    public static function logout(Request $request): void
    {
        Login::logout();
        $request->getRouter()->redirect('/');
    }
}