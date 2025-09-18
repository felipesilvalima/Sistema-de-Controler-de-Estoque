<?php declare(strict_types=1);

use controller\Feedbacks;
use controller\LoginAdmController;
use controller\LoginController;
use Login\validation\ValidationLogin;
session_start();
require_once __DIR__.'/../../controller/login_adm/LoginAdmController.php';
require_once __DIR__.'/../../controller/feedbacks/Feedbacks.php';
require_once __DIR__.'/../../validation/Login/ValidationLogin.php';

if(!isset($_SESSION['user']))
{
    header("Location:  /controler_de_estoque/view/login/login.php");
    die;
}

(int)$cpf = $_REQUEST['cpf'] ?? 0;
(string)$password = $_REQUEST['password'] ?? null;
$btn =  $_REQUEST['btn'] ?? null;

if(isset($btn))
{
    $validation_fields = ValidationLogin::validation_login_fields($cpf,$password);

    if($validation_fields)
    {     
        Feedbacks::feedback_validation_login();  
    }
    
    elseif($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $logar = LoginAdmController::User_login($cpf, $password);

        if($logar)
        {
           header("Location: /controler_de_estoque/view/adm/index.php");
           die;
        }
            else
            {
               Feedbacks::feedback_login();
            }
    }

}


?>


<div class="form-login">
    <h1>Login Administração</h1>
    <form action="login.php" method="post">
        <label for="cpf">Cpf:</label>
        <input type="number" name="cpf" placeholder="Digite seu cpf"> <br><br>

        <label for="password">Senha:</label>
        <input type="password" name="password" placeholder="Digite sua Senha"> <br><br>

        <input type="submit" value="Entrar" name="btn" class="btn entrar">
    </form>
    <a href="/controler_de_estoque/view/produtos/index.php">Voltar para Controler de Produtos</a>
</div>
