<?php

namespace application\core;

use application\controllers\controller_admin;
use application\controllers\controller_main;

class route
{
    static function start()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        // контроллер и действие по умолчанию
        $controller_name = 'main';
        $action_name = 'index';

        $routes = explode('/', $_SERVER['REQUEST_URI']);
        // получаем имя контроллера
        if (!empty($routes[1])) {
            $controller_name = $routes[1];
        }

        // получаем имя экшена
        if (!empty($routes[2])) {
            $action_name = $routes[2];
        }

        $model_name = 'model_' . $controller_name;
        $controller_file = 'controller_' . strtolower($controller_name) . '.php';
        $controller_name = 'application\controllers\controller_' . $controller_name;
        $action_name = 'action_' . $action_name;

        $model_file = strtolower($model_name) . '.php';
        $model_path = "application/models/" . $model_file;

        if (file_exists($model_path)) {
            include "application/models/" . $model_file;
        }

        // подцепляем файл с классом контроллера

        $controller_path = "application/controllers/" . $controller_file;
        if (file_exists($controller_path)) {
            include "application/controllers/" . $controller_file;
        } else {
            Route::ErrorPage404();
        }

        // создаем контроллер
        $controller = new $controller_name;

        $action = $action_name;
        if (method_exists($controller, $action)) {
            if($controller_name == 'application\controllers\controller_main' && $action == 'action_index') {
                $controller->$action();
            } else {
                $controller->$action();
            }
        } else {
            // здесь также разумнее было бы кинуть исключение
            Route::ErrorPage404();
        }

    }

    function ErrorPage404()
    {
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:' . $host . '404');
    }
}