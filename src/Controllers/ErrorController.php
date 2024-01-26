<?php
// Uso la clase monedero llamandola con su espacion de nombres
namespace Controllers;

/**
 * Clase para controlar errores
 */
class ErrorController
{
    /**
     * Creando la funcion para probocar el error 404
     *
     * @return string
     */
    public static function show_err404(): string
    {
        return "<p>La pagina no existe</p>";
    }
    public static function show_err504(): string
    {
        return "<p>La pagina no existe (ANTES)</p>";
    }
}
