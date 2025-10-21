<?php declare(strict_types=1); 

namespace model;

use Exception;
use PDO;
use PDOException;
require_once __DIR__.'/../conexao/DB.php';

class Login extends DB
{
  // Busca um usuário pelo e-mail para login
  public static function login($user)
  {
      try 
      {
          // Preparando query para buscar usuário na tabela 'user'
          $sql = "SELECT * FROM user WHERE email = :email";
          $stm = DB::connect()->prepare($sql);
          $stm->bindParam(':email', $user, PDO::PARAM_STR); // vincula o e-mail à query
          $stm->execute();
  
          // Recupera o usuário como objeto
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