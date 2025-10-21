<?php declare(strict_types=1); 

namespace controller;

use Exception;
use Login\validation\ValidationLogin;
use model\Login as Login;
use PDOException;

require_once __DIR__.'/../../model/login_user/Login.php';
require_once __DIR__.'/../../controller/login_user/LoginController.php';
require_once __DIR__.'/../../validation/Login/ValidationLogin.php';

class LoginController 
{
    private string $login;
    private string $password;

    public function __construct($login, $password)
    {
       $this->login =  $login; 
       $this->password = $password; 
    }

   // Realiza o login do usuário
   public function User_login()
   {     
       try 
       {
           // Valida campos de login e senha
           $validation_fields = ValidationLogin::validation_login_fields($this->login, $this->password);
   
           if(!$validation_fields)
           {
               // Busca usuário pelo login
               $line = Login::login($this->login); 
   
               if($line == null)
               {  
                   http_response_code(404); // Usuário não encontrado
                   ProdutoController::feedback_systm('user_invalido', "Usuário não existe");
                   return false; 
               }
               else
               {
                   $password_hash = $line->password;
                   $user_id = $line->id;
   
                   // Verifica senha informada
                   $password_verify = password_verify((string)$this->password, (string)$password_hash); 
   
                   if($password_verify) 
                   {
                       http_response_code(200); // Login bem-sucedido
                       ProdutoController::feedback_systm('autenticado', "Usuário logado com sucesso"); 
                       $_SESSION['user'] = $user_id; 
                       header("Location: /controler_de_estoque/view/Produtos/index.php");
                       die;  
                   }
                   else 
                   {
                       http_response_code(401); // Senha incorreta
                       ProdutoController::feedback_systm('user_invalido', "Usuário inválido");  
                   }
               }
           }
       } 
       catch (PDOException $error) 
       {
           throw new Exception("Error:" . $error->getMessage());
       }
   }
   
   // Realiza o logout do usuário
   public static function logout()
   {
       session_start(); 
       session_unset(); 
       return session_destroy(); // Encerra a sessão
   }
   
}