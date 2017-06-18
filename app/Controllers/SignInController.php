<?php

use Core\Facades\DB;
use Core\Facades\View;
use Core\Facades\Route;

class SignInController extends Controller
{
    public function formAction()
    {
        return view('sign_in');
    }
    
    public function checkAction()
    {
        //Check all input data to be presented
        if (!isset($_POST['email']) || !isset($_POST['password'])) {
            return $this->sendJsonAnswer('error');
        }
        
        //Get user's and email from ajax request
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        //Get user name by email
        $name = $this->getUserNameByEmail($email);
        
        //Check if user with this email exists
        if ($name === false) {
            return $this->sendJsonAnswer('error');
        }
        
        //Check password correctness
        if ($this->checkUserHash($name, $password) === false) {
            return $this->sendJsonAnswer('error');
        }
        
        //Save user name to cookie
        $_SESSION['user']['name'] = $name;
        
        //Send answer to client
        return $this->sendJsonAnswer('success');
    }
    
    /**
     * Check user hash
     */
    private function checkUserHash($name, $password)
    {
        //Get user's password hash from by email
        $hash_res = DB::prepare("SELECT `hash` FROM `users` WHERE `name`=?")
            ->bindParam('s', $name)
            ->exec()
            ->getResult();
        
        //User with this email not exist
        if ($hash_res->numRows() == 0){
            return false;
        }
        
        //Verify is hash correct
        return password_verify($password, $hash_res->fetchColumn('hash'));
    }
    
    /**
     * Get user name by email
     */
    private function getUserNameByEmail($email) {
        //Query database
        $result = DB::prepare("SELECT `name` FROM `users` WHERE `email`=?")
            ->bindParam('s', $email)
            ->exec()
            ->getResult();
        
        //No user found
        if ($result->numRows() == 0) {
            return false;
        }
        
        //Return user name
        return $result->fetchColumn('name');
    }
}
