<?php declare(strict_types=1); 

namespace config;

use Exception;
use PDO;
use PDOException;

class Database
{
    public static $connect = null;

    public static function connect(): object
    {
         
        try
        {
            if(!self::$connect)// SI NÃO EXISTIR CONEXÃO
            {
                $connect = new PDO("mysql: host=".getenv('HOST')."; dbname".getenv('DB')."; charset=".getenv('CHARSET')."", getenv('USER'), getenv('PASSWORD'));// CRIAR UMA CONEXÃO
                $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//SETANDO ALGUNS PARÂMETROS DE ERRORS PARA MINHA CONEXÃO
            }

            return self::$connect; // RETORNAR A CONEXÃO

        }
            catch(PDOException $error)
            {
                throw new Exception("Error:".$error->getMessage());
            }
    }
}