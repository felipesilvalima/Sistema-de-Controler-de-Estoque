<?php declare(strict_types=1);

use controller\FornecedorController;

session_start();

require_once __DIR__.'/../../controller/fornecedor/FornecedorController.php';

if(!isset($_SESSION['user_adm']))
{
    header("Location: /controler_de_estoque/view/loginAdm/login.php");
    die;
}
session_write_close();

$id = $_REQUEST['id'] ?? 0;

$fornecedor = new FornecedorController();

$remover = $fornecedor->remover_fornecedor((int)$id);

if($remover)
{
    header("Location: lista_de_fornecedor.php");
    die;
}