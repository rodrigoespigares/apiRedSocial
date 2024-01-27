<?php

    namespace Routes;
    use Lib\Router;
    use Controllers\PublicacionesController;
    use Controllers\BaseController;
    use Controllers\AuthController;
    use Controllers\ErrorController;
    use Controllers\LoginController;
    class Routes{
        public static function index() {
            /*-*-*-*-*-*-*-*-*-*-* DOCS Y PRUEBAS -*-*-*-*-*-*-*-*-*-*-*-*/
            // HOME
            Router::add('GET','/', function (){
                return (new BaseController())->index();
            });
            // PROBAR
            Router::add('GET','/pruebas', function (){
                return (new AuthController())->pruebas();
            });
            /*-*-*-*-*-*-*-*-*-*-* LOGIN Y REGISTRO -*-*-*-*-*-*-*-*-*-*-*-*/
            Router::add('GET','/login', function (){
                return (new LoginController())->index(true);
            });
            Router::add('GET','/signup', function (){
                return (new LoginController())->index(false);
            });
            Router::add('POST','/vlogin', function (){
                
                $action = preg_replace('/' . preg_quote(BASE_URL, '/') . '/', '', $_SERVER['HTTP_REFERER']);
                $action = trim($action, '/');
                $value = $action == "login"? true : false;
                return (new LoginController())->vLogin($value);
            });
            Router::add('GET','/logout', function (){
                return (new LoginController())->logout();
            });

            /*-*-*-*-*-*-*-*-*-*-* CONFIRMAR CUENTA -*-*-*-*-*-*-*-*-*-*-*-*/
            Router::add('GET','/confirmar/:id', function ($id){
                return (new AuthController())->verificate($id);
            });

            /*-*-*-*-*-*-*-*-*-*-* CRUD COMPLETO -*-*-*-*-*-*-*-*-*-*-*-*/
            // CREATE PONENTE
            Router::add('POST','/publicaciones', function (){
                return (new PublicacionesController())->create();
            });
            // READ PONENTES
            Router::add('GET','/publicaciones', function (){
                return (new PublicacionesController())->allPonentes();
            });
            Router::add('GET','/publicaciones/:id', function ($id){
                return (new PublicacionesController())->find($id);
            });
            // UPDATE PONENTE
            Router::add('PUT','/publicaciones/:id', function ($id){
                return (new PublicacionesController())->edit($id);
            });
            // DELETE PONENTE
            Router::add('DELETE','/publicaciones/:id', function ($id){
                return (new PublicacionesController())->delete($id);
            });

            /*-*-*-*-*-*-*-*-*-*-* ERRORES DE RUTAS -*-*-*-*-*-*-*-*-*-*-*-*/
            // ERROR 404
            Router::add('GET', '/error', function () {
                return (new ErrorController())->show_err404();
            });
            Router::dispatch();
        }
    }