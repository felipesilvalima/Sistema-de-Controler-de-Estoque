<?php declare(strict_types=1);

use controller\Feedbacks;
use controller\FornecedorController;
require_once __DIR__.'/../../controller/fornecedor/FornecedorController.php';
require_once __DIR__.'/../../controller/feedbacks/Feedbacks.php';

session_start();

if(!isset($_SESSION['user_adm']))
{
    header("Location: /controler_de_estoque/view/loginAdm/login.php");
    die;
}

$id = $_REQUEST['id'] ?? 0; 

session_write_close();


$details = FornecedorController::get_forneceController((int)$id);

$btn = $_REQUEST['btn'] ?? null;

 if(isset($_SESSION['update_false']))
 {
    echo $_SESSION['update_false'];
    unset($_SESSION['update_false']);
 }

if(isset($btn))
{
    $dados = [
        'fornecedor' => (string)$fornecedor_name = $_REQUEST['for'] ?? $details->fornecedor,
        'cpf' => (int)$cpf = $_REQUEST['cpf'] ?? $details->cpf,
        'telefone' => (int)$telefone = $_REQUEST['tel'] ?? $details->telefone,
        'endereco' => (string)$endereco = $_REQUEST['endereco'] ?? $details->endereco
    ];


    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $fornecedor = new FornecedorController($dados);
        $update_date = $fornecedor->update_forneceController((int)$id);
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