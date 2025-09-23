<?php declare(strict_types=1); 

namespace controller;

use Exception;
use model\LoginAdm as LoginAdm;
use PDOException;

require_once __DIR__.'/../../model/login_adm/LoginAdm.php';

class LoginAdmController extends LoginAdm
{

    private int $cpf;
    private string $password;

    public function __construct($cpf, $password)
    {
       $this->cpf = $cpf; 
       $this->password = $password;  
    }

     public function User_login(): bool
   {     
        try 
        {

           $line = LoginAdm::login($this->cpf); 

           while($line == null)
           {   
                http_response_code(404); //O recurso solicitado não existe
               ProdutoController::feedback_systm('user_invalido',"Usuário não existe"); 
               return false; 
           }

           $password_hash = $line->senha;
           $user_id = $line->id;
           
           $password_verify = password_verify((string)$this->password, (string)$password_hash); 
            
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