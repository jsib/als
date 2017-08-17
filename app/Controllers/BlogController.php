<?php

use Core\Facades\DB;
use Core\Facades\View;
use Core\Facades\Route;
use Core\Facades\Auth;

class BlogController extends Controller
{
    public function mainPageAction()
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

        //Add images information to array
        foreach ($posts as $el_id => $post) {
            $post_id = $post['id'];
            if (file_exists(UPLOAD_PATH . $post_id . ".png")) {
                $posts[$el_id]['image'] = true;
            } else {
                $posts[$el_id]['image'] = false;
            }
        }
        
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

        if (file_exists(UPLOAD_PATH . $post_id . ".png")) {
            $post['image'] = true;
        } else {
            $post['image'] = false;
        }
        
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
        foreach(['id', 'username', 'email', 'text', 'image', 'status'] as $fieldName) {
            if (!isset($_POST[$fieldName])) {
                return $this->sendJsonAnswer('error', 'Fill "' . $fieldName .'"" field.');
            }
        }

        //Get post's properties
        $id = $this->getData('id');
        $username = $this->getData('username');
        $email = $this->getData('email');
        $text = $this->getData('text');
        $img_data_url = $this->getData('image');
        $status = $this->getData('status');

        //If new image was uploaded
        if ($img_data_url != '') {
            //Convert and write image's data url to file
            $this->base64_to_png($img_data_url, UPLOAD_PATH . $id . ".png");
        }

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
                `status`=?
            WHERE
                `id`=?
        ")
            ->bindParam('s', $username)
            ->bindParam('s', $email)
            ->bindParam('s', $text)
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

    //Upload image to server
    public function uploadImageAction()
    {
        $this->base64_to_png($_POST['base64_string'], "/var/www/beejee/web/uploaded.png");

        //Answer
        return $this->sendJson(['result' => 'success', 'post' => $_POST]);
    }

    private function base64_to_png($base64_string, $output_file) {
        // open the output file for writing
        $ifp = fopen( $output_file, 'wb' );

        // split the string on commas
        // $data[ 0 ] == "data:image/png;base64"
        // $data[ 1 ] == <actual base64 string>
        $data = explode( ',', $base64_string );

        // we could add validation here with ensuring count( $data ) > 1
        fwrite( $ifp, base64_decode( $data[ 1 ] ) );

        // clean up the file resource
        fclose( $ifp );

        return $output_file;
    }
}
