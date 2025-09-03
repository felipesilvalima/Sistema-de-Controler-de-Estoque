<?php declare(strict_types=1); 

namespace model;

use Exception;
use PDO;
use PDOException;

class DB
{
     
    public static function connect()
    {
        //PARÂMETROS DE CONEXÃO COM BANCO
         $localhost = "localhost";
         $db = "crud_novo";
         $user = "root";
         $password = "";
         $charset = "UTF8";
         
         //VARIAVEL DE CONEXÃO
         $connect = null;
        
        try
        {
            if(!$connect)// SI NÃO EXISTIR CONEXÃO
            {
                $connect = new PDO("mysql: host=$localhost; dbname=$db; charset=$charset", $user, $password);// CRIAR UMA CONEXÃO
                $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//SETANDO ALGUNS PARÂMETROS DE ERRORS PARA MINHA CONEXÃO
            }

            return $connect; // RETORNAR A CONEXÃO

        }
            catch(PDOException $error)
            {
                throw new Exception("Error:".$error->getMessage());
            }
    }

   
}
