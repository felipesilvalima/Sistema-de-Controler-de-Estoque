<?php declare(strict_types=1);

use controller\LoginController;
require_once __DIR__.'/../../controller/login_adm/LoginAdmController.php';

$logout = LoginController::logout();

if($logout)
{
    header("Location: login.php");
}

?>
