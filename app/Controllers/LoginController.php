<?php

use Core\Facades\DB;
use Core\Facades\View;

class LoginController extends Controller
{
    public function checkAction()
    {
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
        }
        //DB::query('SELECT * FROM `users` ORDER BY `name` ASC');
        
        //$menu = DB::fetchAll(MYSQLI_ASSOC);
        
        //return view('blog', ['menu' => $menu]);
        return json_encode([
            'type' => 'error',
            'text' => 'Login failed, invalid email or password'
        ]);
        
    }
}
