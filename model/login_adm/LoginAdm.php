<?php declare(strict_types=1); 

namespace model;

use Exception;
use PDO;
use PDOException;
require_once __DIR__.'/../conexao/DB.php';
class LoginAdm extends DB
{
     protected static function login($cpf)
   {
        try 
        {       
            $sql = "SELECT * FROM adm WHERE cpf = :cpf";
            $stm = DB::connect()->prepare($sql);
            $stm->bindParam(':cpf', $cpf, PDO::PARAM_STR);
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