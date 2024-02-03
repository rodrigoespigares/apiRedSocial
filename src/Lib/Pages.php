<?php
// Espacio de nombres para evitar errores
namespace Lib;

/**
 * Clase pages para cargar todas las paginas
 */
class Pages
{
    /**
     * Funcion render para hacer la carga de las paginas
     *
     * @param string $pageName El nombre del archivo dentro de la carpeta "views" o vistas.
     * @param array|null $params carga de los parametros que va a recibir esa "view" o vista.
     * @return void
     */
    public function render(string $pageName, array $params = null): void
    {
        if ($params != null) {
            foreach ($params as $name => $value) {
                $$name = $value;
            }
        }
        $arriba = dirname(__DIR__, 1);
        // Carga de la cabecera
        require_once $arriba."/Views/layout/header.php";
        // Carga el cuerpo de la vista
        require_once $arriba."/Views/$pageName.php";
        // Carga del footer
        require_once $arriba."/Views/layout/footer.php";
    }
     /**
     * Funcion render para hacer la carga de las paginas sin header
     *
     * @param string $pageName El nombre del archivo dentro de la carpeta "views" o vistas.
     * @param array|null $params carga de los parametros que va a recibir esa "view" o vista.
     * @return void
     */
    public function renderSinHeader(string $pageName, array $params = null): void
    {
        if ($params != null) {
            foreach ($params as $name => $value) {
                $$name = $value;
            }
        }
        $arriba = dirname(__DIR__, 1);
        // Carga el cuerpo de la vista
        require_once $arriba."/Views/$pageName.php";
        // Carga del footer
        require_once $arriba."/Views/layout/footer.php";
    }
    public function renderJSON(array $params) : void {
        
        echo json_encode($params);
    }
}
