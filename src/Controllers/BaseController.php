<?php
    namespace Controllers;
use Lib\Pages;
use Lib\Security;

    class BaseController{
        private Pages $pages;
        public function __construct()
        {
            $this->pages = new Pages();
        }
        /**
         * Carga de la pantalla principal
         * 
         * @return void
         */
        public function index():void {
            $this->pages->render("pages/base/index");
        }
    }
?>