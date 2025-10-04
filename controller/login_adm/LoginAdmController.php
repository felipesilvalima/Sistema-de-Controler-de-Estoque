<?php declare(strict_types=1); 

namespace controller;

use Exception;
use Login\validation\ValidationLogin;
use model\LoginAdm as LoginAdm;
use PDOException;

require_once __DIR__.'/../../model/login_adm/LoginAdm.php';
require_once __DIR__.'/../../validation/Login/ValidationLogin.php';
require_once __DIR__.'/../../controller/produto/ProdutoController.php';

class LoginAdmController 
{

    private int $cpf;
    private string $password;

    public function __construct($cpf, $password)
    {
       $this->cpf = $cpf; 
       $this->password = $password;  
    }

     public function User_login()
   {     
        try 
        {
            $validation_fields = ValidationLogin::validation_login_fields($this->cpf,$this->password);

            if(!$validation_fields)
            {

                $line = LoginAdm::login($this->cpf); 
     
                if($line == null)
                {   
                     http_response_code(404); //O recurso solicitado não existe
                    ProdutoController::feedback_systm('user_invalido',"Usuário não existe"); 
                    return false; 
                }
                     else 
                     {      
                         $password_hash = $line->senha;
                         $user_id = $line->id;
                        
                          $password_verify = password_verify((string)$this->password, (string)$password_hash); 
                         
                         if($password_verify) 
                         {
                             http_response_code(200); //requisição foi processada com sucesso
                             ProdutoController::feedback_systm('autenticado',"Usuário logado com sucesso"); 
                             $_SESSION['user_adm'] = $user_id;
                             header("Location: /controler_de_estoque/view/adm/index.php");
                             die;      
                         }
                             else 
                             {
                                 http_response_code(401); //error de Auteticação 
                                 ProdutoController::feedback_systm('user_invalido',"Usuário inválido"); 
                             }
                     }
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