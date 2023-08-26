<?php

namespace App\Controllers;

use App\Controllers\Pages\PageController;
use App\Utils\View;

class AlertController extends PageController
{

    /**
     * @param string $mensagem
     * @return string
     */
    public static function getSuccess(string $mensagem): string
    {
        return View::render('alert/status', [
            'tipo' => 'success',
            'mensagem' => $mensagem
        ]);
    }

    /**
     * @param string $mensagem
     * @return string
     */
    public static function getError(string $mensagem): string
    {
        return View::render('alert/status', [
            'tipo' => 'danger',
            'mensagem' => $mensagem
        ]);
    }
}

?>