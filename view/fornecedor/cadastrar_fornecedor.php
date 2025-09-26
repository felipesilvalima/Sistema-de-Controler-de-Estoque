<?php declare(strict_types=1);

use controller\Feedbacks;
use controller\FornecedorController;
use fornecedor\validation\ValidationFornecedor;

require_once __DIR__.'/../../controller/fornecedor/FornecedorController.php';
require_once __DIR__.'/../../validation/fornecedor/ValidationFornecedor.php';
require_once __DIR__.'/../../controller/feedbacks/Feedbacks.php';

session_start();

if(!isset($_SESSION['user_adm']))
{
    header("Location: /controler_de_estoque/view/loginAdm/login.php");
    die;
}

session_write_close();

 $dados = [
        'fornecedor' => (string)$fornecedor_name = $_REQUEST['fornec'] ?? null,
        'cpf' => (int)$cpf = $_REQUEST['cpf'] ?? null,
        'telefone' => (int)$telefone = $_REQUEST['tel'] ?? null,
        'endereco' => (string)$endereco = $_REQUEST['ender'] ?? null
    ];

    
if(isset($_REQUEST['btn']))
{
   
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $fornecedor = new FornecedorController($dados);
        $inserir = $fornecedor->Inserir_fornecedor();
        
        $feedbacks = 
        [
            Feedbacks::fornecedor_inserir_verify(), // feedback de verificação de registro existente no DB
            Feedbacks::feedback_validation_form_limit(), // feedback do limite dos campos
            Feedbacks::feedback_validation_inserir() // feedback de campos vazios    
        ];

        foreach($feedbacks as $feedback)
        {
            $feedback;
        }
        
    }
}


?>

<form action="cadastrar_fornecedor.php" method="post">
    <label for="fornec">Fornecedor</label>
    <input type="text" name="fornec" placeholder="Insirar um Fornecedor"> <br><br>
    <label for="cpf">Cpf</label>
    <input type="number" name="cpf" placeholder="Insirar o Cpf"> <br><br>
    <label for="number">Telefone</label>
    <input type="number" name="tel" placeholder="Insirar o Telefone"> <br><br>
    <label for="ender">Endereço</label>
    <textarea name="ender" rows="5" cols="30"></textarea> <br><br>
    <input type="submit" value="Inserir" name="btn"> <br><br>
    <input type="reset" value="Limpar">
</form>
<a href="lista_de_fornecedor.php">Voltar</a>
