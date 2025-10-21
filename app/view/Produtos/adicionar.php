<?php declare(strict_types=1);


session_start();

use controller\CategoriaController;
use controller\Feedbacks;
use controller\FornecedorController;
use controller\MovimentacaoController;
use controller\ProdutoController;
use model\Produto;
use validation\Produto\ValidationProduto;

require_once __DIR__.'/../../controller/produto/ProdutoController.php';
require_once __DIR__.'/../../controller/feedbacks/Feedbacks.php';
require_once __DIR__.'/../../validation/Produto/ValidationProduto.php';
require_once __DIR__.'/../../controller/movimentacao/MovimentacaoController.php';
require_once __DIR__.'/../../controller/categoria/CategoriaController.php';
require_once __DIR__.'/../../controller/fornecedor/FornecedorController.php';

if(!isset($_SESSION['user']))
{
    header("Location: /controler_de_estoque/view/login/login.php");
    die;
}

$btn = $_REQUEST['btn'] ?? null;
$user_id = $_SESSION['user'];

if(isset($btn))
{
    session_write_close();
    
    $dados = [
     'produto' => (string)$produto_name = $_REQUEST['pd']  ?? null,
     'preco' =>  (float)$preco = $_REQUEST['pc']  ?? null,
     'quantidade' => (int)$quantidade = $_REQUEST['qt']  ?? 0,
     'quantidade_min' => (int)$quantidade_min = $_REQUEST['qt_min']  ?? 0,
     'descricao' => (string)$descricao = $_REQUEST['descricao']  ?? null,
     'unidade_med' => (string)$unidade_medida = $_REQUEST['unidade_med']  ?? null,
     'categoria' => (int)$categoria = $_REQUEST['categoria'] ?? 0,
     'fornecedor' => (int)$fornecedor = $_REQUEST['fornecedor'] ?? 0
    ];

        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $produto = new ProdutoController($dados);
            $inseir = $produto->inseir($user_id);
        }
        
    
}

?>

<link rel="stylesheet" href="../css/styles.css">
<body id="background-index">
    <?= Feedbacks::feedback_validation_inserir(); ?>
    <div class="form-adicionar">
        <h1 class="titulo-adicionar">Adicionar Produto</h1>
        <form action="adicionar.php" method="post">
            <label class="label-adicionar" for="pd">Produto:</label>
            <input class="input-adicionar" type="text" name="pd" placeholder="Nome do Produto">
    
            <label class="label-adicionar"  for="descricao">Descrição:</label>
            <textarea class="input-descricao" name="descricao" placeholder="Descrição do produto..." cols="50" rows="5"></textarea>
    
            <label class="label-adicionar" for="pc">Preço:</label>
            <input class="input-adicionar" type="number" name="pc" placeholder="Preço do Produto">
    
            <label class="label-adicionar" for="qt">Quantidade:</label>
            <input class="input-adicionar" type="number" name="qt" placeholder="Quantidade">
    
            <label class="label-adicionar" for="qt_min">Quantidade_minima:</label>
            <input class="input-adicionar" type="number" name="qt_min" placeholder="Quantidade_minima">
    
            <label class="label-adicionar" for="unidade_med">Unidade de Médida:</label>
            <input class="input-adicionar" type="text" name="unidade_med" placeholder="Unidade de Médida">
    
            <label class="label-adicionar" for="categoria">Categoria:</label>
            <select class="select-adicionar" name="categoria" required>
            <option selected disabled>Adicione uma Categoria</option>
            <?php 
    
            $datas_categoria = CategoriaController::categorias("");
    
            foreach($datas_categoria as $data)
            {
                echo" <option value='$data->id'>$data->categoria</option> ";
            }
            ?>
            </select>
    
            <label class="label-adicionar" for="fornecedor">Fornecedor:</label>
            <select class="select-adicionar" name="fornecedor" required>
            <option selected disabled>Adicione um Fornecedor</option>
            <?php
                $datas_fornecedores = FornecedorController::fornecedores("");
    
                foreach($datas_fornecedores as $data)
                {
                    echo" <option value='$data->id'>$data->fornecedor</option> ";
                }
            ?>
            </select>
                <div class="button-adicionar">
                    <input type="submit" value="Inserir" name="btn" class="btn-inserir">
                    <input type="reset" value="Limpar" class="btn-limpar">
                    <a href="index.php" class="voltar">Voltar</a>
                </div>
        </form>
    </div>
</body>

