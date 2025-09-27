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
session_write_close();
(int)$cpf = $_REQUEST['cpf'] ?? 0;
(string)$password = $_REQUEST['password'] ?? null;
$btn =  $_REQUEST['btn'] ?? null;

if(isset($btn))
{
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $Login = new LoginAdmController((int)$cpf, (string)$password);
        $logar = $Login->User_login();   
    }

}

?>

<link rel="stylesheet" href="../css/styles.css">
<body id="background">
    <div class="form-login">
        <h1 id="titulo_adm">Login Administração</h1>
        <form action="login.php" method="post">
            <code>
               <?= Feedbacks::feedback_login(); ?> 
            </code>
            <label class="label-input-adm" for="cpf">Cpf</label>
            <input class="input-login" type="number" name="cpf" placeholder="Digite seu cpf"> <br><br>
    
            <label class="label-input-adm" for="password">Senha</label>
            <input class="input-login" type="password" name="password" placeholder="Digite sua Senha"> <br><br>
    
            <input class="input-button" type="submit" value="Entrar" name="btn" class="btn entrar">
        </form>
        <div class="input-button-voltar">
            <a  href="/controler_de_estoque/view/produtos/index.php">Voltar para Controler de Produtos</a>
</div>
    </div>
    <img id="img-estoque" src="../../view/css/img/estoque.png" alt="estoque" width="48%">
</body>
