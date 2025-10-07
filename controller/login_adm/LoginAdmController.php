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

    // Realiza o login do usuário administrador
    public function User_login()
    {     
        try 
        {
            // Valida campos de CPF e senha
            $validation_fields = ValidationLogin::validation_login_fields($this->cpf, $this->password);
    
            if(!$validation_fields)
            {
                // Busca usuário administrador pelo CPF
                $line = LoginAdm::login($this->cpf); 
    
                if($line == null)
                {   
                    http_response_code(404); // Usuário não encontrado
                    ProdutoController::feedback_systm('user_invalido', "Usuário não existe"); 
                    return false; 
                }
                else 
                {      
                    $password_hash = $line->senha;
                    $user_id = $line->id;
                    
                    // Verifica senha
                    $password_verify = password_verify((string)$this->password, (string)$password_hash); 
                    
                    if($password_verify) 
                    {
                        http_response_code(200); // Login bem-sucedido
                        ProdutoController::feedback_systm('autenticado', "Usuário logado com sucesso"); 
                        $_SESSION['user_adm'] = $user_id;
                        header("Location: /controler_de_estoque/view/adm/index.php");
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