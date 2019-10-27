<?php

namespace application\models;

use application\core\model;
use PDO;

class model_main extends model
{
    private $host = 'localhost';
    private $user = 'root';
    private $dbName = 'beejee';
    private $password = '123';
    private $charset = 'utf8';
    public $db;

    public function __construct()
    {
        $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbName . ";charset=" . $this->charset;
        $opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        $this->db = new PDO($dsn, $this->user, $this->password, $opt);
    }

    public function get_data($sort = null)
    {
        $sql = 'SELECT * FROM tasks';
        if (!isset($_SESSION)) {
            session_start();
        }

        //Проверка на изменение сортировки (ASC | DESC)
        if ($sort != null && isset($_SESSION['by'])) {
            //повторное нажатие на сортировку по тому же полю
            if ($sort == $_SESSION['by']) {
                if (isset($_SESSION['sort'])) {
                    //если по убыванию меняем на по возрастанию, и наоборот
                    if ($_SESSION['sort'] == 'DESC') {
                        $_SESSION['sort'] = 'ASC';
                    } else {
                        $_SESSION['sort'] = 'DESC';
                    }
                } else {
                    $_SESSION['sort'] = 'ASC';
                }
            } else {
                //запоминаем поле по которому сортируем
                $_SESSION['by'] = $sort;
                $_SESSION['sort'] = 'ASC';
            }

        } else {
            if ($sort == null && !isset($_SESSION['by'])) {
                $_SESSION['by'] = 'user_name';
                $_SESSION['sort'] = 'ASC';
            } else {
                if ($sort) {
                    $_SESSION['by'] = $sort;
                    $_SESSION['sort'] = 'ASC';
                }
            }
        }

        $sql = $sql . ' ORDER by ' . $_SESSION['by'] . ' ' . $_SESSION['sort'];

        $sql = $sql . ' LIMIT 3';
        if (isset($_POST['page'])) {
            $_SESSION['page'] = $_POST['page'];
        }

        if (!isset($_SESSION['page'])) {
            $_SESSION['page'] = 1;
        }

        $sql = $sql . ' OFFSET ' . (($_SESSION['page'] - 1) * 3);

        return $this->db->query($sql);
    }

    public function get_one_task($id)
    {
        $statement = $this->db->prepare('Select * From tasks Where id = :id');
        $statement->execute([
            ':id' => $id
        ]);
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    public function getCounttasks()
    {
        return $this->db->query('SELECT COUNT(*) FROM tasks')->fetchColumn();
    }

    public function updateTask($params)
    {
        $statement = $this->db->prepare('Select * From tasks Where id = :id');
        $statement->execute([
            ':id' => $params['id']
        ]);
        $result = $statement->fetchAll(PDO::FETCH_OBJ);
        $admin = 0;
        if (strcmp($params['text'], $result[0]->text) !== 0) {
            $admin = 1;
        }
        $statement = $this->db->prepare('UPDATE tasks Set text = :text, status = :status, admin = :admin WHERE id = :id');
        $statement->execute([
            ':id' => $params['id'],
            ':text' => $params['text'],
            ':status' => isset($params['status']) ? 1 : 0,
            ':admin' => $admin
        ]);
    }

    public function createTask($params)
    {
        try {
            $statement = $this->db->prepare('INSERT into tasks (user_name, email, text) values (:user_name, :email, :text)');
            $statement->execute([
                ':user_name' => $params['user_name'],
                ':email' => $params['email'],
                ':text' => isset($params['text']) ? $params['text'] : ''
            ]);

            return true;
        } catch (\PDOException $exception) {
            return $exception->getMessage();
        }
    }
}