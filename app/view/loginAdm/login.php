<?php

declare(strict_types=1);

use controller\Feedbacks;
use controller\LoginAdmController;
use controller\LoginController;
use Login\validation\ValidationLogin;

require_once __DIR__ . '/../../controller/login_adm/LoginAdmController.php';
require_once __DIR__ . '/../../controller/feedbacks/Feedbacks.php';
require_once __DIR__ . '/../../validation/Login/ValidationLogin.php';

(int)$cpf = $_REQUEST['cpf'] ?? 0;
(string)$password = $_REQUEST['password'] ?? null;
$btn =  $_REQUEST['btn'] ?? null;

if (isset($btn)) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $Login = new LoginAdmController((int)$cpf, (string)$password);
        $logar = $Login->User_login();
    }
}

$titulo  = 'Login do Administrador';
$body_id = 'background';
require __DIR__ . '/../partials/head.php';
?>
    <div class="form-login">
        <h1 id="titulo_adm">Administrador</h1>
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
        <a class="button-acessar" href="/controler_de_estoque/view/login/login.php">Acessar como Usuário</a>
    </div>
    <img id="img-estoque" src="../../view/css/img/login_adm.png.png" alt="Ilustração de administração">
<?php require __DIR__ . '/../partials/footer.php'; ?>