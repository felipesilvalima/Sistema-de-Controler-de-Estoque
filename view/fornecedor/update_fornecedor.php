<?php declare(strict_types=1);

use controller\Feedbacks;
use controller\FornecedorController;
require_once __DIR__.'/../../controller/FornecedorController.php';
require_once __DIR__.'/../../controller/Feedbacks.php';

session_start();

if(!isset($_SESSION['user_adm']))
{
    header("Location: /controler_de_estoque/view/loginAdm/login.php");
    die;
}

(int)$id = $_REQUEST['id'] ?? 0; 

session_write_close();

$details = FornecedorController::get_forneceController($id);

if (!$details) 
{
     header("Location: lista_de_fornecedor.php");
     die;
}

$btn = $_REQUEST['btn'] ?? null;
$fornecedor = $_REQUEST['for'] ?? $details->fornecedor;
$cpf = $_REQUEST['cpf'] ?? $details->cpf;
$telefone = $_REQUEST['tel'] ?? $details->telefone;
$endereco = $_REQUEST['endereco'] ?? $details->endereco;

 if(isset($_SESSION['update_false']))
 {
    echo $_SESSION['update_false'];
    unset($_SESSION['update_false']);
 }

if(isset($btn))
{
   if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $update_date = FornecedorController::update_forneceController($id,$fornecedor,$cpf,$telefone,$endereco);
        
        if(!$update_date)
        {
              Feedbacks::feedback_atualizar(); 
        }

        if(isset($update_date) && $update_date)
        {
            header("Location: lista_de_fornecedor.php");
            die;  
        }
    } 
}

?>



<div class="form-update">
    <h1>Atualizar Fornecedor</h1>
    <form action="update_fornecedor.php" method="post">
        <label for="id">ID:</label>
        <input type="number" name="id" value="<?=$details->id ?>" readonly> <br><br>

        <label for="for">Fornecedor:</label>
        <input type="text" name="for" value="<?=$details->fornecedor ?>"> <br><br>
        
        <label for="cpf">Cpf:</label>
        <input type="number" name="cpf" value="<?= $details->cpf ?>"> <br><br>
         
        <label for="tel">Telefone:</label>
        <input type="number" name="tel" value="<?=$details->telefone?>"> <br><br>
        
        <label for="endereco">Endereço:</label>
        <textarea name="endereco"  cols="50" rows="5"><?=$details->endereco?></textarea> <br><br>

        <input type="submit" value="Atualizar" name="btn" class="btn atualizar">
    </form>
    <a href="lista_de_fornecedor.php" class="btn voltar">Voltar</a>
</div>