<?php declare(strict_types=1); 

namespace model;

use Exception;
use PDO;
use PDOException;
require_once __DIR__.'/../conexao/DB.php';
class LoginAdm extends DB
{
 // Busca um administrador pelo CPF para login
 public static function login($cpf)
 {
     try 
     {       
         // Preparando query para buscar administrador na tabela 'adm'
         $sql = "SELECT * FROM adm WHERE cpf = :cpf";
         $stm = DB::connect()->prepare($sql);
         $stm->bindParam(':cpf', $cpf, PDO::PARAM_STR); // vincula o CPF à query
         $stm->execute();
 
         // Recupera o administrador como objeto
         $line = $stm->fetch(PDO::FETCH_OBJ);
 
         if(!empty($line)) // se encontrou
         {
             return $line;
         }
         else // não encontrou
         {
             return null;
         }
     } 
     catch (PDOException $error) // captura erro de banco
     {
         throw new Exception("Error:". $error->getMessage());
     }
 }
 
}