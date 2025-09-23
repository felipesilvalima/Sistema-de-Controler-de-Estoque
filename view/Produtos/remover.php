<?php declare(strict_types=1);

use controller\MovimentacaoController;
use controller\ProdutoController;

session_start();

require_once __DIR__.'/../../controller/produto/ProdutoController.php';

if(!isset($_SESSION['user']))
{
    header("Location: /controler_de_estoque/view/login/login.php");
    die;
}

$id = $_REQUEST['id'] ?? 0;
$produto_name = $_REQUEST['pd'] ?? null;
$user_id =  $_SESSION['user'] ?? null;


$remover = ProdutoController::remover_id((int)$id,(string)$produto_name,(int)$user_id);

if($remover)
{
    header("Location: index.php");
    die;
}
