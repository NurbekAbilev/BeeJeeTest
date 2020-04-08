<?php

namespace App\Controller;
use Doctrine\ORM\Tools\Pagination\Paginator;
use App\Models\Task;

class LoginController extends Controller
{
    /**
     * Показ формы добавления задачи
     */
    public function show()
    {
        $data = [];
        if (isset($_GET['wrong'])){
            $data['wrong'] = true;
        }
        
        // dd($data);
        $this->twig->load('login.html')->display($data);
    }

    public function login()
    {
        
        if( $_POST['username'] == getenv('ADMIN_USERNAME') &&
            $_POST['password'] == getenv('ADMIN_PASSWORD')
        ){
            session_start();
            $_SESSION['logged_in'] = "yes";
            header("Status: 301 Moved Permanently");
            header("Location: /");
            exit;
        }

        header("Status: 301 Moved Permanently");
        header("Location: /login?wrong");
        exit;
    }

    public function logout()
    {
        
        session_destroy();
        header("Status: 301 Moved Permanently");
        header("Location: /");
        exit;
    }

}