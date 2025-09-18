<?php declare(strict_types=1);

use controller\Feedbacks;
use controller\LoginController;
use Login\validation\ValidationLogin;
use model\Login;

require_once __DIR__.'/../../controller/login_user/LoginController.php';
require_once __DIR__.'/../../controller/feedbacks/Feedbacks.php';
require_once __DIR__.'/../../validation/Login/ValidationLogin.php';

(string)$user = $_REQUEST['user'] ?? null;
(string)$password = $_REQUEST['password'] ?? null;
$btn =  $_REQUEST['btn'] ?? null;

if(isset($btn))
{
    $validation_fields = ValidationLogin::validation_login_fields($user,$password);

    if($validation_fields)
    {     
        Feedbacks::feedback_validation_login();  
    }
    
    elseif($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $Login = new LoginController();
        $logar = $Login->User_login($user, $password);

        if($logar)
        {
           header("Location: /controler_de_estoque/view/Produtos/index.php");
           die;
        }
            else
            {
               Feedbacks::feedback_login();
            }
    }

}


?>

<link rel="stylesheet" href="../css/styles.css">
<div class="form-login">
    <h1>Login</h1>
    <form action="login.php" method="post">
        <label for="user">Email:</label>
        <input type="email" name="user" placeholder="Digite seu Email">

        <label for="password">Senha:</label>
        <input type="password" name="password" placeholder="Digite sua Senha">

        <input type="submit" value="Entrar" name="btn" class="btn entrar">
    </form>
</div>
