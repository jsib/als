<?php

use Core\Facades\DB;
use Core\Facades\View;
use Core\Facades\Route;
use Core\Facades\Auth;

class BlogController extends Controller
{
    public function listPostsAction()
    {
        $posts_res = DB::prepare(
            'SELECT * FROM `posts`
                ORDER BY `created_at` DESC'
        )
            ->exec()
            ->getResult();
        
        $posts = $posts_res->fetchAll();
        
        return view('blog', ['posts' => $posts]);
        
    }

    public function loadPostsAction()
    {
        $posts_res = DB::prepare('SELECT * FROM `posts`')
            ->exec()
            ->getResult();
        
        $posts = $posts_res->fetchAll();
        
        return $this->sendJson(['result' => 'success', 'posts' => $posts]);
    }

    
    public function showPostAction($post_id)
    {
        dump($post_id);
    }
    
    public function addPostAction()
    {
        //Check all input data to be presented
        if (!isset($_POST['text'])) {
            return $this->sendJsonAnswer('error');
        }
        
        //Get post's properties
        $title = $this->getData('title');
        $text = $this->getData('text');
        
        //Get user id which is signed in now
        $user_id = Auth::getSignedInUserId();
        
        //Query database
        DB::prepare(
            "INSERT INTO `posts` SET
                `user_id`=?,
                `created_at`=?,
                `title`=?,
                `text`=?"
        )
            ->bindParam('d', $user_id)
            ->bindParam('s', date("Y-m-d H:i:s"))
            ->bindParam('s', $title)
            ->bindParam('s', $text)
            ->exec();
        
        //Answer
        return $this->sendJson(['result' => 'success']);
    }
}
