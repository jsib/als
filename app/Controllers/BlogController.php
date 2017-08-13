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
                ORDER BY `username` ASC'
        )
            ->exec()
            ->getResult();
        
        $posts = $posts_res->fetchAll();
        
        return view('blog', ['posts' => $posts]);
        
    }

    public function loadPostsAction()
    {
        $posts_res = DB::prepare(
            'SELECT * FROM `posts`'
        )
            ->exec()
            ->getResult();
        
        $posts = $posts_res->fetchAll();
        
        return $this->sendJson(['result' => 'success', 'posts' => $posts]);
    }

    
    public function showPostAction($post_id)
    {
        $posts_res = DB::prepare("
            SELECT
                * 
            FROM
                `posts`
            WHERE
                `id`=$post_id

        ")
            ->exec()
            ->getResult();
        
        $post = $posts_res->fetch();
        
        return $this->sendJson(['result' => 'success', 'post' => $post]);
        
    }
    
    public function addPostAction()
    {
        //Check all input data to be presented
        if (!isset($_POST['text'])) {
            return $this->sendJsonAnswer('error');
        }
        
        //Get post's properties
        $username = $this->getData('username');
        $email = $this->getData('email');
        $text = $this->getData('text');
        
        //Get user id which is signed in now
        $user_id = Auth::getSignedInUserId();
        
        //Query database
        DB::prepare(
            "INSERT INTO `posts` SET
                `username`=?,
                `email`=?,
                `text`=?"
        )
            ->bindParam('s', $username)
            ->bindParam('s', $email)
            ->bindParam('s', $text)
            ->exec();

        $id = DB::insertId();
        
        //Answer
        return $this->sendJson(['result' => 'success', 'id' => $id]);
    }

    public function editPostAction()
    {
        //Check if all input data are presented
        foreach(['id', 'username', 'email', 'text', 'picture', 'status'] as $fieldName) {
            if (!isset($_POST[$fieldName])) {
                return $this->sendJsonAnswer('error', 'Fill "' . $fieldName .'"" field.');
            }
        }

        //Get post's properties
        $id = $this->getData('id');
        $username = $this->getData('username');
        $email = $this->getData('email');
        $text = $this->getData('text');
        $picture = $this->getData('picture');
        $status = $this->getData('status');

        //Get user id which is signed in now
        $user_id = Auth::getSignedInUserId();
        
        //Query database
        DB::prepare("
            UPDATE
              `posts` 
            SET
                `username`=?,
                `email`=?,
                `text`=?,
                `picture`=?,                
                `status`=?
            WHERE
                `id`=?
        ")
            ->bindParam('s', $username)
            ->bindParam('s', $email)
            ->bindParam('s', $text)
            ->bindParam('s', $picture)
            ->bindParam('d', $status)
            ->bindParam('d', $id)
            ->exec();

        //Answer
        return $this->sendJson(['result' => 'success']);
    }


    public function removePostAction()
    {
        //Check all input data to be presented
        if (!isset($_POST['id'])) {
            return $this->sendJsonAnswer('error');
        }

        //Get post's properties
        $id = $this->getData('id');

        //Query database
        DB::prepare("
            DELETE FROM
                `posts`
            WHERE
                `id`=?
            LIMIT
                1
        ")
            ->bindParam('d', $id)
            ->exec();

        //Answer
        return $this->sendJson(['result' => 'success']);

    }
}
