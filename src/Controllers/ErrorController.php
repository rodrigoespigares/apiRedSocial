<?php
// Uso la clase monedero llamandola con su espacion de nombres
namespace Controllers;

use Lib\Pages;

/**
 * Clase para controlar errores
 */
class ErrorController
{
    /**
     * Creando la funcion para probocar el error 404
     *
     * @return void
     */
    public static function show_err404(): void
    {
        $page = new Pages();

        $page->render("pages/error/404");
    }
}
