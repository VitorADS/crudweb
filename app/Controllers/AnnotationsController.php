<?php

namespace App\Controllers;

use App\Controllers\Pages\PageController;
use App\Http\Request;
use App\Models\Entitys\Annotation;
use App\Models\Entitys\User;
use App\Models\Service\AnnotationService;
use App\Models\Service\UserService;
use App\Session\Auth\Login;
use App\Utils\View;

class AnnotationsController extends PageController
{

    /**
     * @param Request $request
     * @return string
     */
    public static function getStatus(Request $request): string{
        $queryParams = $request->getQueryParams();

        if(!isset($queryParams['status'])) return '';

        switch($queryParams['status']){
            case 'addedAnnotation':
                return AlertController::getSuccess('Anotação adicionada com sucesso');
                break;
            case 'updatedAnnotation':
                return AlertController::getSuccess('Anotação editada com sucesso');
                break;
            case 'removedAnnotation':
                return AlertController::getSuccess('Anotação removida com sucesso');
                break;
            case 'notFoundAnnotation':
                return AlertController::getError('Anotação não encontrada');
                break;
            default:
                return '';
                break;
        }
    }
    
    /**
     * @param Request $request
     * @param UserService $userService
     * @return string
     */
    public static function getHome(Request $request, UserService $userService): string
    {
        $user = $userService->getRepository()->find((int) Login::getUser());
        $icards = '';

        /** @var Annotation $annotation */
        foreach($user->getAnnotations() as $annotation){
            $icards .= View::render('annotations/card', [
                'header' => $annotation->getHeader(),
                'title' => $annotation->getTitle(),
                'text' => $annotation->getText(),
                'id' => $annotation->getId()
            ]);
        }

        if($icards === ''){
            $icards = '<h3>Você ainda não adicionou nenhuma anotação :(</h3>';
        }

        $cards = View::render('annotations/index', [
            'status' => self::getStatus($request),
            'cards' => $icards
        ]);

        return parent::getPage('Anotações', $cards, false);
    }

    /**
     * @param Request $request
     * @param UserService $userService
     * @return void
     */
    public static function saveAction(Request $request, UserService $userService): void
    {
        /** @var User $user */
        $user = $userService->getRepository()->find((int) Login::getUser());
        $postVars = $request->getPostVars();

        $id = htmlspecialchars($postVars['id'], ENT_QUOTES) ?? '';
        $header = htmlspecialchars($postVars['header'], ENT_QUOTES) ?? '';
        $title = htmlspecialchars($postVars['title'], ENT_QUOTES) ?? '';
        $text = htmlspecialchars($postVars['text'], ENT_QUOTES) ?? '';

        if(is_numeric($id)){
            $annotation = (new AnnotationService($userService->getRepository()->getEm()))->getRepository()->find((int) $id);

            if(!$annotation instanceof Annotation) $annotation = new Annotation();
        } else{
            $annotation = new Annotation();
        }

        $annotation->setHeader($header);
        $annotation->setTitle($title);
        $annotation->setText($text);
        $annotation->setUser($user);

        $user->addAnnotation($annotation);
        $userService->save($user);

        if(!is_numeric($id)) $request->getRouter()->redirect('/home?status=addedAnnotation');
        else $request->getRouter()->redirect('/home?status=updatedAnnotation');
    }

    /**
     * @param Request $request
     * @param AnnotationService $annotationService
     * @return void
     */
    public static function removeAction(Request $request, AnnotationService $annotationService): void
    {
        $queryParams = $request->getQueryParams();
        $success = false;

        if(isset($queryParams['id'])){
            $id = htmlspecialchars($queryParams['id'], ENT_QUOTES);
            $annotation = $annotationService->getRepository()->find((int) $id);

            if($annotation instanceof Annotation){
                $annotationService->remove($annotation);
                $success = true;
            }
        }

        if($success === true) $request->getRouter()->redirect('/home?status=removedAnnotation');
        else $request->getRouter()->redirect('/home?status=notFoundAnnotation');
    }

    /**
     * @param Request $request
     * @param AnnotationService $annotationService
     * @return void
     */
    public static function getAnnotation(Request $request, AnnotationService $annotationService): array
    {
        $retorno = [
            'success' => false,
            'message' => 'ID invalido.'
        ];

        $queryParams = $request->getQueryParams();
        $id = isset($queryParams['id']) ? htmlspecialchars($queryParams['id'], ENT_QUOTES) : false;

        if($id !== false){
            $annotation = $annotationService->getRepository()->find((int) $id);

            if($annotation instanceof Annotation){
                $retorno = [
                    'success' => true,
                    'message' => '',
                    'annotation' => [
                        'id' => $annotation->getId(),
                        'header' => $annotation->getHeader(),
                        'title' => $annotation->getTitle(),
                        'text' => $annotation->getText()
                    ]
                ];
            }
        }

        return $retorno;
    }
}