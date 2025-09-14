<?php declare(strict_types=1); 

namespace controller;

use Exception;
use model\LoginAmd;
use PDOException;

require_once __DIR__.'/../model/LoginAmd.php';

class LoginAmdController
{
     public static function User_login($cpf, $password)
   {     
        try 
        {

           $line = LoginAmd::login($cpf); 

           while($line == null)
           {   
                http_response_code(404); //O recurso solicitado não existe
               ProdutoController::feedback_systm('user_invalido',"Usuário não existe"); 
               return false; 
           }

           $password_hash = $line->senha;
           $user_id = $line->id;
           
           $password_verify = password_verify((string)$password, (string)$password_hash); 
            
            if($password_verify) 
            {
                http_response_code(200); //requisição foi processada com sucesso
                ProdutoController::feedback_systm('autenticado',"Usuário logado com sucesso"); 
                $_SESSION['user_adm'] = $user_id; 
                return true;  
            }
                else 
                {
                    http_response_code(401); //error de Auteticação 
                    ProdutoController::feedback_systm('user_invalido',"Usuário inválido"); 
                    return false; 
                }
        } 

        catch (PDOException $error) 
        {
            throw new Exception("Error:".$error->getMessage());
        }
   }

   public static function logout()
   {
      session_start(); 
      session_unset(); 
      
     return session_destroy(); 
   }
}