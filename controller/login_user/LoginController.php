<?php declare(strict_types=1); 

namespace controller;

use Exception;
use model\Login as Login;
use PDOException;

require_once __DIR__.'/../../model/login_user/Login.php';
require_once __DIR__.'/../../controller/login_user/LoginController.php';

class LoginController extends Login
{
    private string $login;
    private string $password;

    public function __construct($login, $password)
    {
       $this->login = $login; 
       $this->password = $password; 
    }

   public function User_login(): bool
   {     
        try 
        {

           $line = Login::login($this->login); 

           while($line == null)
           {  
                http_response_code(404); //O recurso solicitado não existe 
               ProdutoController::feedback_systm('user_invalido',"Usuário não existe");
               return false; 
           }

           $password_hash = $line->password;
           $user_id = $line->id;
           
           $password_verify = password_verify((string)$this->password, (string)$password_hash); 
            
            if($password_verify) 
            {
                http_response_code(200); //requisição foi processada com sucesso
                ProdutoController::feedback_systm('autenticado',"Usuário logado com sucesso"); 
                $_SESSION['user'] = $user_id; 
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