<?php

class BlogController extends Controller
{

    public $menu = [];
    
    public function listAction()
    {
        $this->menu = [1, 2, 3];
        //$template = new Template();
        //$template->view();
        echo 'Hello from BlogController:list';
    }
}
