<?php

namespace App\Controllers;

use Framework\Viewer;

class Home {
    public function index() {
        $view = new Viewer();
        echo $view->render('shared/header', ['title' => 'Home']);
        echo $view->render('/Home/index');
    }
}
