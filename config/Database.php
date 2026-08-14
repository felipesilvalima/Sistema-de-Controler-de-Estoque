<?php declare(strict_types=1);

namespace config;

use Exception;
use PDO;
use PDOException;

class Database
{
    public static ?PDO $connect = null;

    public static function connect(): PDO
    {

        try
        {
            if(!self::$connect)// SI NÃO EXISTIR CONEXÃO
            {
                self::load_env(); // CARREGAR AS CREDENCIAIS DO env.php

                $dsn = "mysql:host=".getenv('DB_HOST').";dbname=".getenv('DB_NAME').";charset=".getenv('DB_CHARSET');

                self::$connect = new PDO($dsn, getenv('DB_USER'), getenv('DB_PASSWORD'));// CRIAR UMA CONEXÃO
                self::$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//SETANDO ALGUNS PARÂMETROS DE ERRORS PARA MINHA CONEXÃO
            }

            return self::$connect; // RETORNAR A CONEXÃO

        }
            catch(PDOException $error)
            {
                throw new Exception("Error:".$error->getMessage());
            }
    }

    // CARREGA O ARQUIVO DE CREDENCIAIS (NÃO VERSIONADO)
    private static function load_env(): void
    {
        $env = __DIR__.'/../env.php';

        if(!file_exists($env))
        {
            throw new Exception("Arquivo env.php não encontrado na raiz do projeto. Copie env.example.php para env.php e preencha as credenciais.");
        }

        require_once $env;
    }
}
