<?php declare(strict_types=1); 

namespace model;

use Exception;
use PDO;
use PDOException;
require_once __DIR__.'/../conexao/DB.php';

class Login extends DB
{
   public static function login($user)
   {
        try 
        {       
            $sql = "SELECT * FROM user WHERE email = :email";
            $stm = DB::connect()->prepare($sql);
            $stm->bindParam(':email', $user, PDO::PARAM_STR);
            $stm->execute();
            
            $line = $stm->fetch(PDO::FETCH_OBJ);
            
            if(!empty($line))
            {
                return $line;
            }

                else
                {
                    return null;
                }
        } 
            catch (PDOException $error) 
            {
                throw new Exception("Error:". $error->getMessage());
            }
   } 
}