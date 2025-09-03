<?php declare(strict_types=1);

use controller\FornecedorController;

session_start();

require_once __DIR__.'/../../controller/FornecedorController.php';

if(!isset($_SESSION['user']))
{
    header("Location: /controler_de_estoque/view/login/login.php");
    die;
}
session_write_close();

(int)$id = $_REQUEST['id'] ?? 0;
(string)$fornecedor = $_REQUEST['pd'] ?? null;

$remover = FornecedorController::remover_fornecedor($id,$fornecedor);

if($remover)
{
    header("Location: lista_de_fornecedor.php");
    die;
}