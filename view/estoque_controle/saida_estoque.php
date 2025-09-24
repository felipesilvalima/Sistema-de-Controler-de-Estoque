<?php declare(strict_types=1); 

session_start();

use controller\Controler_estoqueController;
use controller\Feedbacks;
use controller\ProdutoController;
use model\Controler_estoque;

require_once __DIR__.'/../../controller/produto/ProdutoController.php';
require_once __DIR__.'/../../controller/controle_estoque/Controler_estoqueController.php';
require_once __DIR__.'/../../controller/feedbacks/Feedbacks.php';

if(!isset($_SESSION['user']))
{
    header("Location: login.php");
    die;
}

session_write_close();

$id = $_REQUEST['id'] ?? 0;
$details =  ProdutoController::detalhes((int)$id);

$btn = $_REQUEST['btn'] ?? null;
$user_id = $_SESSION['user'] ?? 0;

 if(isset($_SESSION['update_false']))
 {
    echo $_SESSION['update_false'];
    unset($_SESSION['update_false']);
 }


if(isset($btn))
{

     $dados = [
     'produto' => (string)$produto_name = $details->produto,
     'preco' =>  (float)$preco =  $details->preco,
     'quantidade' => (int)$quantidade = $_REQUEST['qt']  ?? $details->quantidade_max,
     'quantidade_min' => (int)$quantidade_min = $details->quantidade_min,
     'descricao' => (string)$descricao = $details->descricao,
     'unidade_med' => (string)$unidade_medida = $details->unidade_medida,
     'categoria' => (int)$categoria = $details->categoria_id,
     'fornecedor' => (int)$fornecedor = $details->fornecedor_id
    ];

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $Estoque = new Controler_estoqueController($dados);
        $update_date = $Estoque->Saida_estoque((int)$id,(int)$user_id);
        
        Feedbacks::feedback_atualizar(); 
       
    }
    
}

?>
 <link rel="stylesheet" href="../css/styles.css">
<div class="form-update">
    <h1>Remover Quantidade</h1>
    <form action="saida_estoque.php" method="post">
        <label for="id">ID:</label>
        <input type="number" name="id" value="<?=$details->id ?>" readonly>

        <label for="qt">Remover quantidade</label>
        <input type="number" name="qt" placeholder="Remova Quantidade">

        <input type="submit" value="Remover" name="btn" class="btn atualizar">
    </form>
    <a href="/controler_de_estoque/view/Produtos/index.php" class="btn voltar">Voltar</a>
</div>