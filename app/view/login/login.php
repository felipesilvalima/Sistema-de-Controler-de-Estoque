<?php

declare(strict_types=1);

use controller\Feedbacks;
use controller\LoginController;
use Login\validation\ValidationLogin;
use model\Login;

require_once __DIR__ . '/../../controller/login_user/LoginController.php';
require_once __DIR__ . '/../../controller/feedbacks/Feedbacks.php';
require_once __DIR__ . '/../../validation/Login/ValidationLogin.php';

$user = $_REQUEST['user'] ?? null;
$password = $_REQUEST['password'] ?? null;
$btn =  $_REQUEST['btn'] ?? null;

if (isset($btn)) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $Login = new LoginController( strip_tags((string)$user), strip_tags((string)$password));
        $logar = $Login->User_login();
    }
}


$titulo  = 'Login';
$body_id = 'background';
require __DIR__ . '/../partials/head.php';
?>

    <div class="form-login">
        <h1 id="titulo_login">Login</h1>
        <form action="login.php" method="post">
            <code>
                <?= Feedbacks::feedback_login(); ?>
            </code>
            <label class="label-input" for="user">Email</label><br>
            <input class="input-login" type="email" name="user" placeholder="Digite seu Email"><br>

            <label class="label-input" for="password">Senha</label><br>
            <input class="input-login" type="password" name="password" placeholder="Digite sua Senha"><br>

            <input class="input-button" type="submit" value="Entrar" name="btn" class="btn entrar">
        </form>
        <a class="button-acessar" href="/controler_de_estoque/view/loginAdm/login.php">Acessar como Administrador</a>
    </div>
    <img id="img-estoque" src="../../view/css/img/estoque.png" alt="Ilustração de estoque">
<?php require __DIR__ . '/../partials/footer.php'; ?>