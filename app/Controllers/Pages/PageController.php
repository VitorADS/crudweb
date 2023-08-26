<?php

namespace App\Controllers\Pages;

use App\Utils\View;

class PageController{

    /**
     * @return string
     */
    private static function getHeader(): string
    {
        return View::render('page/header');
    }

    /**
     * @return string
     */
    private static function getFooter(): string
    {
        return View::render('page/footer');
    }

    /**
     * @param string $title
     * @param string $content
     * @param bool $header = false
     * @return string
     */
    public static function getPage(string $title, string $content, bool $header = true) : string
    {
        if($header){
            $contentHeader = self::getHeader();
        } else {
            $contentHeader = '';
        }

        return View::render('page/page', [
            'title' => $title,
            'header' => $contentHeader,
            'content' => $content,
            'footer' => self::getFooter()
        ]);
    }
}

?>