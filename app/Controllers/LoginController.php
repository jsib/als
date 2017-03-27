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
        $user = 'myname';
        $result = DB::prepare('SELECT * FROM `users` WHERE `name` = ?')
            ->bindParam('s', $user)
            ->exec()
            ->getResult();
        
        dump(DB::numRows());
        
        $table = $result->fetch();
        
        dump($table);
        
        
        
        exit;
        //return view('blog', ['menu' => $menu]);
        return json_encode([
            'type' => 'error',
            'text' => 'Login failed, invalid email or password'
        ]);
        
    }
    

}
