<?php

use Core\Facades\DB;
use Core\Facades\View;

class BlogController extends Controller
{
    public function listAction()
    {
        echo 'Hello from BlogController:list';
        
        DB::query('SELECT * FROM `users` ORDER BY `name` ASC');
        
//        while ($row = DB::fetchRow()) {
//            dump($row);
//        }
        
        $menu = DB::fetchAll(MYSQLI_ASSOC);
        
        echo View::load('blog', ['menu' => $menu]);
        
    }
}
