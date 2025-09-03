<?php declare(strict_types=1);

use controller\MovimentacaoController;
use controller\ProdutoController;

session_start();

require_once __DIR__.'/../../controller/ProdutoController.php';

if(!isset($_SESSION['user']))
{
    header("Location: /controler_de_estoque/view/login/login.php");
    die;
}

(int)$id = $_REQUEST['id'] ?? 0;
(string)$produto = $_REQUEST['pd'] ?? null;
(string)$user_id =  $_SESSION['user'] ?? null;

$remover = ProdutoController::remover_id($id,$produto,$user_id);

if($remover)
{
    header("Location: index.php");
    die;
}
