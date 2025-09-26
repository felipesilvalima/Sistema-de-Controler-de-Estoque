<?php declare(strict_types=1);
session_start();
use controller\FornecedorController;
require_once __DIR__.'/../../controller/fornecedor/FornecedorController.php';

if(!isset($_SESSION['user_adm']))
{
    header("Location: /controler_de_estoque/view/loginAdm/login.php");
    die;
}

$id = $_REQUEST['id'] ?? 0;

session_write_close();

$relatorio = FornecedorController::get_forneceController((int)$id);

        echo "<div class='detalhes-produto'>
        <h1>Relátorio do Fornecedor</h1>
        <p><strong>ID:</strong> ". $relatorio->id ."</p>
        <p><strong>Fornecedor:</strong> ". $relatorio->fornecedor ."</p>
        <p><strong>Cpf:</strong> ". preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/','$1.$2.$3-$4',(string)$relatorio->cpf) ."</p>
        <p><strong>Telefone:</strong> ". preg_replace('/(\d{2})(\d{5})(\d{4})/','($1) $2-$3',(string)$relatorio->telefone) ." </p>
        <details>
        <summary><strong>Endereço</strong></summary>
         <p>$relatorio->endereco</p>
        </details> <br>
        <a href='lista_de_fornecedor.php' class='btn voltar'>Voltar</a>
      </div>";
    