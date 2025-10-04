<?php declare(strict_types=1);

session_start();

use controller\CategoriaController;
use controller\Feedbacks;
use controller\FornecedorController;
use controller\ProdutoController;
require_once __DIR__.'/../../controller/produto/ProdutoController.php';
require_once __DIR__.'/../../controller/feedbacks/Feedbacks.php';
require_once __DIR__.'/../../controller/categoria/CategoriaController.php';
require_once __DIR__.'/../../controller/fornecedor/FornecedorController.php';

if(!isset($_SESSION['user']))
{
    header("Location: /controler_de_estoque/view/login/login.php");
    die;
}

session_write_close();

$id = $_REQUEST['id'] ?? 0;
$details =  ProdutoController::detalhes((int)$id);
$user_id = $_SESSION['user'] ?? 0;

 if(isset($_SESSION['update_false']))
 {
    echo $_SESSION['update_false'];
    unset($_SESSION['update_false']);
 }
 
if(isset($_REQUEST['btn']))
{

    $dados = [
     'produto' => (string)$produto_name = $_REQUEST['pd']  ?? $details->produto,
     'preco' =>  (float)$preco = $_REQUEST['pc']  ?? $details->preco,
     'quantidade' => (int)$quantidade = $_REQUEST['qt']  ?? $details->quantidade_max,
     'quantidade_min' => (int)$quantidade_min = $_REQUEST['qt_min']  ?? $details->quantidade_min,
     'descricao' => (string)$descricao = $_REQUEST['descricao']  ?? $details->descricao,
     'unidade_med' => (string)$unidade_medida = $_REQUEST['unidade_med']  ?? $details->unidade_medida,
     'categoria' => (int)$categoria = $_REQUEST['categoria'] ?? $details->categoria_id,
     'fornecedor' => (int)$fornecedor = $_REQUEST['fornecedor'] ?? $details->fornecedor_id
    ];

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $produto = new ProdutoController($dados);
        $update_date = $produto->Atulaizar((int)$id,(int)$user_id);
    }
    
}
 
?>
<link rel="stylesheet" href="../css/styles.css">
<body id="background-index">
    <div class="form-adicionar">
        <h1 class="titulo-adicionar">Atualizar Produto</h1>
        <form action="atualizar.php" method="post">
            <label class="label-adicionar" for="id">ID:</label>
            <input class="input-adicionar" type="number" name="id" value="<?=$details->id ?>" readonly>
    
            <label class="label-adicionar" for="pd">Produto:</label>
            <input class="input-adicionar" type="text" name="pd" value="<?=$details->produto ?>">
    
            <label class="label-adicionar" for="descricao">Descrição:</label>
            <textarea class="input-descricao" name="descricao" placeholder="Descrição do produto..." cols="50" rows="5"><?=$details->descricao?></textarea>
    
            <label class="label-adicionar" for="pc">Preço:</label>
            <input class="input-adicionar" type="text" name="pc" value="<?=number_format((float)$details->preco,2, '.' , ',')?>">
    
            <input  type="number" name="qt" value="<?=$details->quantidade_max ?>" hidden>
    
            <label class="label-adicionar" for="qt_min">Quantidade Minima</label>
            <input class="input-adicionar" type="number" name="qt_min" value="<?=$details->quantidade_min?>">
    
            <label class="label-adicionar" for="unidade_med">Unidade de Médida:</label>
            <input class="input-adicionar" type="text" name="unidade_med" placeholder="Unidade de Médida" value="<?=$details->unidade_medida?>">
    
            <label class="label-adicionar" for="categoria">Categoria:</label>
            <select class="select-adicionar" name="categoria">
            <?php 
    
                $datas_categoria = CategoriaController::categorias((int)$details->categoria_id); //todas as categorias
    
                echo "<option selected disabled value='$details->categoria_id'>$details->categoria</option>";
            
                foreach($datas_categoria as $data)
                {
                    echo" <option value='$data->id'>$data->categoria</option> ";
                }
            ?>
            </select>
    
            <label class="label-adicionar" for="fornecedor">Fornecedor:</label>
            <select class="select-adicionar" name="fornecedor">
            <?php
    
                
                $datas_fornecedores = FornecedorController::fornecedores((string)$details->fornecedor);  //todas as fornecedores
    
                echo "<option selected disabled value='$details->fornecedor_id'>$details->fornecedor</option>";
            
    
                foreach($datas_fornecedores as $data)
                {
                    echo" <option value='$data->id'>$data->fornecedor</option> ";
                }
            ?>
            </select>
    
             <div class="button-adicionar">
                    <input type="submit" value="Atualizar" name="btn" class="btn-inserir">
                    <a href="index.php" class="voltar">Voltar</a>
             </div>
        </form>
    </div>
</body>




