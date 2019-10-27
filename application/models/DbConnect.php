<?php

namespace model;

require_once 'config/ConfigDb.php';

use config\ConfigDb;
use PDO;

class DbConnect
{
    public $DbConnect;

    public function __construct(ConfigDb $configDb)
    {
        try {
            $dsn = "mysql:host=" . $configDb->host . ";dbname=" . $configDb->dbName . ";charset=" . $configDb->charset;
            $opt = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $this->DbConnect = new PDO($dsn, $configDb->user, $configDb->password, $opt);
        } catch (\PDOException $exception) {
            return $exception->getMessage();
        }

    }
}