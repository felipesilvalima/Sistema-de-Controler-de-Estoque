<?php declare(strict_types=1);

session_start();

use controller\ProdutoController;
require_once __DIR__.'/../../controller/produto/ProdutoController.php';

?>
<link rel="stylesheet" href="../css/styles.css">
<?php

if(!isset($_SESSION['user']))
{
    header("Location: /controler_de_estoque/view/login/login.php");
    die;
}

 $id_produto = $_REQUEST['id'] ?? 0;
 $date = ProdutoController::detalhes((int)$id_produto);
 
    if(empty($date))
    {
        header("Location: index.php");
        die;  
    }

      echo "<div class='detalhes-produto'>
        <h1>Relátorio do Produto</h1>
        <p><strong>ID:</strong> ". $date->id ."</p>
        <p><strong>Produto:</strong> ". $date->produto ."</p>
         <details>
         <summary><strong>Descrição</strong></summary>
          <p>$date->descricao</p>
         </details>
        <p><strong>Preço:</strong> R$ ". number_format((float)$date->preco,2, '.', ',') ."</p>
        <p><strong>Quantidade:</strong> ". $date->quantidade_max ."</p>
        <p><strong>Quantidade Minima:</strong> ". $date->quantidade_min ."</p>
        <p><strong>Unidade de Médida:</strong> ". $date->unidade_medida ."</p>
        <p><strong>Categoria:</strong> ". $date->categoria ."</p>
        <p><strong>Fornecedor:</strong> ". $date->fornecedor ." </p>
        <a href='index.php' class='btn voltar'>Voltar</a>
      </div>";

    
       
        
      
        


