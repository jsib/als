<?php

use Core\Facades\DB;
use Core\Facades\View;
use Core\Facades\Route;

class UserController extends Controller
{
    public function addAction()
    {
        $hash =  password_hash('qwe123', PASSWORD_BCRYPT);
        
        dump(DB::prepare("UPDATE `users` SET `password`=? WHERE `name`=?")
            ->bindParam('s', $hash)
            ->bindParam('s', 'ivan')
            ->exec()
            ->affectedRows());
        dump($hash);
    }
}
