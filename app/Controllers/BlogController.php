<?php

use Core\Facades\DB;
use Core\Facades\View;
use Core\Facades\Route;

class BlogController extends Controller
{
    public function listPostsAction()
    {
        $posts_res = DB::prepare('SELECT * FROM `posts` ORDER BY `created_at` ASC')
            ->exec()
            ->getResult();
        
        $posts = $posts_res->fetchAll();
        
        return view('blog', ['posts' => $posts]);
        
    }
    
    public function showPostAction($post_id)
    {
        dump($post_id);
    }
}
