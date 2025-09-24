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


if(isset($_REQUEST['btn']))
{
    $dados = [
        'fornecedor' => (string)$fornecedor_name = $_REQUEST['fornec'] ?? null,
        'cpf' => (int)$cpf = $_REQUEST['cpf'] ?? null,
        'telefone' => (int)$telefone = $_REQUEST['tel'] ?? null,
        'endereco' => (string)$endereco = $_REQUEST['ender'] ?? null
    ];

    $validation_fields = ValidationFornecedor::validation_fornecedor_fields($dados);
    $validation_field_cpf = ValidationFornecedor::validation_cpf($dados['cpf']);
    
    
    if(!$validation_fields)
    {
 
        $verify_fornecedor = FornecedorController::verify_fonecedorController($dados['fornecedor']);

         session_write_close();

        $verify_fornecedor_cpf = FornecedorController::verify_cpfController($dados['cpf']);

        if($verify_fornecedor)
        {
            Feedbacks::fornecedor_inserir_verify();
        }
            elseif($verify_fornecedor_cpf || $validation_field_cpf)
            {
               Feedbacks::fornecedor_inserir_verify();
               Feedbacks::feedback_validation_forn_cpf();
            }
    
                else
                {
                    $fornecedor = new FornecedorController($dados);
                    $inserir = $fornecedor->Inserir_fornecedor();
                }
    
    }
        else
        {
            Feedbacks::feedback_validation_inserir();
        }
}


?>

<form action="cadastrar_fornecedor.php" method="post">
    <label for="fornec">Fornecedor</label>
    <input type="text" name="fornec" placeholder="Insirar um Fornecedor"> <br><br>
    <label for="cpf">Cpf</label>
    <input type="number" name="cpf" placeholder="Insirar o Cpf"> <br><br>
    <label for="tel">Telefone</label>
    <input type="tel" name="tel" placeholder="Insirar o Telefone"> <br><br>
    <label for="ender">Endereço</label>
    <textarea name="ender" rows="5" cols="30"></textarea> <br><br>
    <input type="submit" value="Inserir" name="btn"> <br><br>
    <input type="reset" value="Limpar">
</form>
<a href="lista_de_fornecedor.php">Voltar</a>
