<?php declare(strict_types=1);
session_start();
use controller\FornecedorController;
require_once __DIR__.'/../../controller/FornecedorController.php';

if(!isset($_SESSION['user_adm']))
{
    header("Location: /controler_de_estoque/view/loginAdm/login.php");
    die;
}

(int)$id = $_REQUEST['id'] ?? 0;

session_write_close();

$relatorio = FornecedorController::get_forneceController($id);

if(!$relatorio)
{
    header("Location: lista_de_fornecedor.php");
    die;
}
    else
    {
        echo "<div class='detalhes-produto'>
        <h1>Relátorio do Fornecedor</h1>
        <p><strong>ID:</strong> ". $relatorio->id ."</p>
        <p><strong>Fornecedor:</strong> ". $relatorio->fornecedor ."</p>
        <p><strong>Cpf:</strong> ". $relatorio->cpf ."</p>
        <p><strong>Telefone:</strong> ". $relatorio->telefone ." </p>
        <details>
        <summary><strong>Endereço</strong></summary>
         <p>$relatorio->endereco</p>
        </details> <br>
        <a href='lista_de_fornecedor.php' class='btn voltar'>Voltar</a>
      </div>";
    }