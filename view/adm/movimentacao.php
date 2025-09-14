<?php declare(strict_types=1);

  session_start();

use controller\AdmController;
use controller\Feedbacks;
use controller\ProdutoController;

require_once __DIR__.'/../../controller/ProdutoController.php';
require_once __DIR__.'/../../controller/AdmController.php';
require_once __DIR__.'/../../controller/Feedbacks.php';

if(!isset($_SESSION['user_adm']))
{
    header("Location: /controler_de_estoque/view/loginadm/logout.php");
    die;
}

 ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controler de estoque</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="titulo">
        <h1>Tabela de Movimentação</h1>
         <a href="index.php" class="btn search">Voltar</a>
    </div>

    <div class="form">
    <form action="movimentacao.php" method="get">
        <input type="search" name="pesquisar" placeholder="Buscar Movimentações...">
        <button type="submit" class="btn search">Procurar</button>
        <button type="submit" class="btn all">Ver todos as Movimentações</button>
    </form>
    </div><br>

        <?php 

          Feedbacks::feedback_login();
          Feedbacks::feedback_inserir(); 
          Feedbacks::feedback_remover(); 
          Feedbacks::feedback_atualizar();
          Feedbacks::feedback_details();
          
                session_write_close();
                
                $pesquisar = $_GET['pesquisar'] ?? "";
                $dados =  AdmController::movimentacao($pesquisar);
                  
                if(empty($dados))
                {
                    Feedbacks::feedback_index();
                }
                  else
                    {

                        echo"<div class='table'>
                        <table border='1'>
                        <tr>
                            <th>ID</th>
                            <th>Tipo</th>
                            <th>Data</th>
                            <th>Quantidade</th>
                            <th>Produto</th>
                            <th>Usuário</th>
                        </tr>";
                        foreach($dados as $date)
                        { 
                            echo "<tr>"; 

                            echo "<td>".(int)$date->id."</td>";
                            echo "<td>".(string)$date->tipo."</td>";
                            echo "<td>".(string)$date->data."</td>";
                            echo "<td>".(int)$date->quantidade."</td>";
                            echo "<td>".(int)$date->produto_id."</td>";
                            echo "<td>".(int)$date->usuario_responsavel_id."</td>";

                            echo "</tr>";
                        }      
                    } 
                    ?>     

        </table>
    </div>

</body>
</html>