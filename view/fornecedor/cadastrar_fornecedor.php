<?php declare(strict_types=1);

use controller\Feedbacks;
use controller\FornecedorController;
use fornecedor\validation\ValidationFornecedor;

require_once __DIR__.'/../../controller/FornecedorController.php';
require_once __DIR__.'/../../validation/fornecedor/ValidationFornecedor.php';
require_once __DIR__.'/../../controller/Feedbacks.php';

session_start();

if(!isset($_SESSION['user']))
{
    header("Location: /controler_de_estoque/view/login/login.php");
    die;
}

session_write_close();

$fornecedor = $_REQUEST['fornec'] ?? null;
$cpf = $_REQUEST['cpf'] ?? null;
$telefone = $_REQUEST['tel'] ?? null;
$endereco = $_REQUEST['ender'] ?? null;
$user_id = $_SESSION['user'] ?? null;

if(isset($_REQUEST['btn']))
{

    $validation_fields = ValidationFornecedor::validation_fornecedor_fields($fornecedor,$cpf,$telefone,$endereco);
    
    
    if(!$validation_fields)
    {
        $verify_fornecedor = FornecedorController::verify_fonecedorController($fornecedor);
         session_write_close();
        $verify_fornecedor_cpf = FornecedorController::verify_cpfController($cpf);
        
        if($verify_fornecedor)
        {
            Feedbacks::fornecedor_inserir_verify();
        }
            elseif($verify_fornecedor_cpf)
            {
               Feedbacks::fornecedor_inserir_verify();
            }
    
                else
                {
    
                    $inserir = FornecedorController::Inserir_fornecedor($fornecedor,$cpf,$telefone,$endereco,$user_id);
                    
                    if($inserir)
                    {
                        Feedbacks::fornecedor_inserir();
                    }
                    
                        else
                        {
                            Feedbacks::fornecedor_inserir();
                        }
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
