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
        public function index() {
            $this->pages->render("pages/base/index");
        }
    }
?>