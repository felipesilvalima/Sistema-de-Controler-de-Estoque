<?php declare(strict_types=1);

session_start();

use controller\CategoriaController;
use controller\Feedbacks;
use controller\FornecedorController;
use controller\ProdutoController;
require_once __DIR__.'/../../controller/ProdutoController.php';
require_once __DIR__.'/../../controller/Feedbacks.php';
require_once __DIR__.'/../../controller/CategoriaController.php';
require_once __DIR__.'/../../controller/FornecedorController.php';

if(!isset($_SESSION['user']))
{
    header("Location: /controler_de_estoque/view/login/login.php");
    die;
}

session_write_close();
(int)$id = $_REQUEST['id'] ?? 0;
$details =  ProdutoController::detalhes($id);


if (empty($details))
{
     header("Location: /controler_de_estoque/view/Produtos/index.php");
     die;
}


(string)$produto = $_REQUEST['pd']  ?? $details->produto;
(float)$preco = $_REQUEST['pc']  ?? $details->preco;
(int)$quantidade = $_REQUEST['qt']  ?? $details->quantidade_max;
(int)$quantidade_min = $_REQUEST['qt_min']  ?? $details->quantidade_min;
(string)$descricao = $_REQUEST['descricao']  ?? $details->descricao;
(string)$unidade_medida = $_REQUEST['unidade_med']  ?? $details->unidade_medida;
$categoria = $_REQUEST['categoria'] ?? $details->categoria_id;
$fornecedor = $_REQUEST['fornecedor'] ?? $details->fornecedor_id;


 if(isset($_SESSION['update_false']))
 {
    echo $_SESSION['update_false'];
    unset($_SESSION['update_false']);
 }

if(isset($_REQUEST['btn']))
{
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {

        $update_date = ProdutoController::Atulaizar($id,$produto,$preco,$quantidade,$quantidade_min,$descricao,$unidade_medida, (int)$categoria,(int)$fornecedor);

        if(!$update_date)
        {
              Feedbacks::feedback_atualizar(); 
        }

        if(isset($update_date) && $update_date  == true)
        {       
            header("Location: index.php");
            die;  
        }
    }
    
}
 
?>
<link rel="stylesheet" href="../css/styles.css">
<div class="form-update">
    <h1>Atualizar Produto</h1>
    <form action="atualizar.php" method="post">
        <label for="id">ID:</label>
        <input type="number" name="id" value="<?=$details->id ?>" readonly>

        <label for="pd">Produto:</label>
        <input type="text" name="pd" value="<?=$details->produto ?>">

        <label for="descricao">Descrição:</label>
        <textarea name="descricao" placeholder="Descrição do produto..." cols="50" rows="5"><?=$details->descricao?></textarea>

        <label for="pc">Preço:</label>
        <input type="text" name="pc" value="<?=number_format((float)$details->preco,2, '.' , ',')?>">

        <input type="number" name="qt" value="<?=$details->quantidade_max ?>" hidden>

        <label for="qt_min">Quantidade Minima</label>
        <input type="number" name="qt_min" value="<?=$details->quantidade_min?>">

        <label for="unidade_med">Unidade de Médida:</label>
        <input type="text" name="unidade_med" placeholder="Unidade de Médida" value="<?=$details->unidade_medida?>">

        <label for="categoria">Categoria:</label>
        <select name="categoria">
        <?php 

            $datas_categoria = CategoriaController::categorias($details->categoria_id); //todas as categorias

            echo "<option selected disabled value='$details->categoria_id'>$details->categoria</option>";
        
            foreach($datas_categoria as $data)
            {
                echo" <option value='$data->id'>$data->categoria</option> ";
            }
        ?>
        </select>

        <label for="fornecedor">Fornecedor:</label>
        <select name="fornecedor">
        <?php 

            $datas_fornecedores = FornecedorController::fornecedores($details->fornecedor_id);  //todas as fornecedores

            echo "<option selected disabled value='$details->fornecedor_id'>$details->fornecedor</option>";
        

            foreach($datas_fornecedores as $data)
            {
                echo" <option value='$data->id'>$data->fornecedor</option> ";
            }
        ?>
        </select>

        <input type="submit" value="Atualizar" name="btn">
    </form>
    <a href="index.php" class="btn voltar">Voltar</a>
</div>




