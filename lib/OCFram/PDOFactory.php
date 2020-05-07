<?php
namespace OCFram;

use PDO;

class PDOFactory
{
    public static function getMysqlConnexion()
    {
        $db = new \PDO('mysql:host=localhost;dbname=youssefapp', 'root', 'kurosaki');
        $db->setAttribute(\PDO::ERRMODE_WARNING, \PDO::ERRMODE_EXCEPTION);

        return $db;
    }
}