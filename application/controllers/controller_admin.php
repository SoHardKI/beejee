<?php
namespace application\controllers;
use application\core\controller;

class controller_admin extends controller
{
    public function action_index()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if(isset($_POST['login']) && isset($_POST['password'])) {
            if($_POST['login'] == 'admin' && $_POST['password'] == '123') {
                $_SESSION['admin'] = true;

                header("Location: /main");
            }
            $_SESSION['message'] = 'Неправильный логин или пароль';
        }
        $this->view->generate('login_view.php', 'template_view.php');
    }

    public function action_logout()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        unset($_SESSION['admin']);
        header("Location: /main");
    }
}