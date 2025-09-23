<?php declare(strict_types=1);

use controller\AdmController;

require_once __DIR__.'/../../controller/ADM/AdmController.php';

$remover = AdmController::movimentacao_remove();

if($remover)
{
    header("Location: movimentacao.php");
    die;
}

?>
