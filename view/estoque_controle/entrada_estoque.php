<?php declare(strict_types=1); 

session_start();

use controller\Controler_estoqueController;
use controller\Feedbacks;
use controller\ProdutoController;

require_once __DIR__.'/../../controller/ProdutoController.php';
require_once __DIR__.'/../../controller/Controler_estoqueController.php';
require_once __DIR__.'/../../controller/Feedbacks.php';

if(!isset($_SESSION['user']))
{
    header("Location: /controler_de_estoque/view/login/login.php");
    die;
}

session_write_close();
$id = $_REQUEST['id'] ?? 0;
$produtoController = new ProdutoController();
$details =  $produtoController->detalhes((int)$id);


$btn = $_REQUEST['btn'] ?? null;
$produto = $_REQUEST['pd']  ?? $details->produto;
$preco = $_REQUEST['pc']  ?? $details->preco;
$quantidade = $_REQUEST['qt']  ?? $details->quantidade_max;
$quantidade_min = $_REQUEST['qt_min']  ?? $details->quantidade_min;
$descricao = $_REQUEST['descricao']  ?? $details->descricao;
$unidade_medida = $_REQUEST['unidade_med']  ?? $details->unidade_medida;
$categoria = $_REQUEST['categoria']  ?? $details->categoria_id;
$fornecedor = $_REQUEST['fornecedor']  ?? $details->fornecedor_id;
$user_id = $_SESSION['user'] ?? 0;

if (!$details) 
{
     header("Location: /controler_de_estoque/view/Produtos/index.php");
     die;
}

 if(isset($_SESSION['update_false']))
 {
    echo $_SESSION['update_false'];
    unset($_SESSION['update_false']);
 }


if(isset($btn))
{

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $Estoque = new Controler_estoqueController();

        $update_date = $Estoque->Entrada_estoque((int)$id,(string)$produto,(float)$preco,(int)$quantidade,(int)$quantidade_min,(string)$descricao,(string)$unidade_medida,(int)$categoria,(int)$fornecedor, (int)$user_id);
        
        if(!$update_date)
        {
              Feedbacks::feedback_atualizar(); 
        }

        if(isset($update_date) && $update_date  == true)
        {
            header("Location: /controler_de_estoque/view/Produtos/index.php");
            die;  
        }
    }
    
}

?>
<link rel="stylesheet" href="../css/styles.css">
<div class="form-update">
    <h1>Inserir Quantidade</h1>
    <form action="entrada_estoque.php" method="post">
        <label for="id">ID:</label>
        <input type="number" name="id" value="<?=$details->id ?>" readonly>

        <label for="qt">Quantidade:</label>
        <input type="number" name="qt" placeholder="Insirar uma quantidade">

       
        <input type="text" name="pd" value="<?=$details->produto ?>" hidden>
        <textarea name="descricao" placeholder="Descrição do produto..." cols="50" rows="5" value="<?=$details->descricao?>" hidden></textarea>
        <input type="text" name="pc" value="<?=number_format((float)$details->preco,2, '.' , ',')?>" hidden>
        <input type="number" name="qt_min" value="<?=$details->quantidade_min?>" hidden>
        <input type="text" name="unidade_med" placeholder="Unidade de Médida" value="<?=$details->unidade_medida?>" hidden>

        <select name="categoria" hidden>
        <option selected disabled>Adicione uma Categoria</option>
        <option value="<?=$details->categoria_id?>"><?=$details->categoria_id?></option>
        </select>

        <select name="fornecedor" hidden>
        <option selected disabled>Adicione um Fornecedor</option>
        <option value="<?=$details->fornecedor_id?>"><?=$details->fornecedor_id?></option>
        </select>

        <input type="submit" value="Inserir" name="btn" class="btn atualizar">
    </form>
    <a href="../Produtos/index.php" class="btn voltar">Voltar</a>
</div>