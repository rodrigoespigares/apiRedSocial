<?php

namespace Controllers;

use Lib\Pages;
use Lib\Security;
use Services\UsuariosService;

class AuthController
{
    private UsuariosService $service;
    private Pages $page;
    public function __construct()
    {
        $this->page = new Pages();
        $this->service = new UsuariosService();
    }
    /**
     * Verifica el token proporcionado.
     *
     * Esta función toma un token como entrada, lo verifica usando la clase Security y luego realiza acciones.
     * Si el token es válido, confirma el email asociado al token y redirige al usuario a la URL base.
     * Si el token no es válido, genera un nuevo token de confirmación y redirige al usuario a la página de token después de 3 segundos.
     *
     * @param string $token El token a verificar.
     * @return void
     */
    public function verificate($token): void
    {
        $myToken = Security::returnToken($token);
        if ($myToken) {
            if ($this->service->checkToken($token)) {
                $this->service->confirmado($myToken->data->email);
                header("Location:" . BASE_URL);
            }
        } else {
            self::nuevoTokenConfirmacion($this->service->checkToken($token));
            $redirectUrl = BASE_URL;
            header("refresh:3;url=$redirectUrl");
            $this->page->render("pages/base/token");
        }
    }
    /**
     * Crea un token
     * 
     * Esta función genera un nuevo token con el email del usuario y la muestra por pantalla con el renderJSON en un formato legile para JavaScript
     * 
     * @return void
     */
    public function nuevoToken()
    {
        if ($_SESSION['identity'] != null) {
            $token = Security::crearToken(Security::claveSecreta(), ["email" => $_SESSION['identity']['email']]);
            $this->service->changeToken($_SESSION['identity']['email'], $token);
            $json['token'] = $token;
            $this->page->renderJSON($json);
        }
    }
    /**
     * Crea un token
     * 
     * Esta función genera un nuevo token con el email del usuario y para poder validar el correo que se le pasa por parámetro
     * 
     * @param string $email con el email del usuario
     * @return void
     */
    public function nuevoTokenConfirmacion(string $email)
    {

        $token = Security::crearToken(Security::claveSecreta(), ["email" => $email]);
        $this->service->changeTokenConfirmacion($email, $token);
    }
}
