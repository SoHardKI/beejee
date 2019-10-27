<?php

namespace application\controllers;

use application\core\controller;
use application\core\view;
use application\models\model_main;
use PDO;

class controller_main extends controller
{
    public function __construct()
    {
        $this->model = new model_main();
        $this->view = new view();
    }

    function action_index()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $data = $this->model->get_data(isset($_POST['sort']) ? $_POST['sort'] : null);
        $this->view->generate('main_view.php', 'template_view.php', $data);
    }

    public function action_update()
    {
        $data = $this->model->get_one_task($_POST['id']);
        if (isset($_POST['text'])) {
            session_start();
            if (!isset($_SESSION['admin'])) {
                $_SESSION['message'] = 'У вас нет прав, залогиньтесь!';

                $host = 'http://' . $_SERVER['HTTP_HOST'] . '/admin/index';
                header('Location:' . $host);
            } else {
                $this->model->updateTask($_POST);
                header("Location: /main");
            }
        } else {
            $this->view->generate('update_view.php', 'template_view.php', $data);
        }
    }

    public function action_create()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!empty($_POST)) {
            if (preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i",
                $_POST['email'])) {
                $result = $this->model->createTask($_POST);

                if ($result == true) {
                    $_SESSION['create_task'] = 'Задача успешно создана!';
                    header("Location: /main/index");
                } else {
                    $_SESSION['create_task'] = $result;
                }
            } else {
                $_SESSION['create_task'] = 'Неправильный email';
            }
        }
        $this->view->generate('create_view.php', 'template_view.php');
    }
}