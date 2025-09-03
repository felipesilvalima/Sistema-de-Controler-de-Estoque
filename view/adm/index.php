<?php declare(strict_types=1);

  session_start();

use controller\AdmController;
use controller\Feedbacks;
use controller\ProdutoController;

require_once __DIR__.'/../../controller/ProdutoController.php';
require_once __DIR__.'/../../controller/AdmController.php';
require_once __DIR__.'/../../controller/Feedbacks.php';

if(!isset($_SESSION['user']))
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
        <h1>Tabela de Usuários</h1>
        <a href="/controler_de_estoque/view/loginadm/login.php" class="btn sair">Sair</a>
    </div>

    <div class="form">
    <form action="index.php" method="get">
        <input type="search" name="pesquisar" placeholder="Buscar Usuário...">
        <button type="submit" class="btn search">Procurar</button>
        <button type="submit" class="btn all">Ver todos os usuários</button>
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
                $dados =  AdmController::index($pesquisar);
                  
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
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Senha</th>
                            <th>Ações</th>
                        </tr>";
                        foreach($dados as $date)
                        { 
                            echo "<tr>"; 

                            echo "<td>".(int)$date->id."</td>";
                            echo "<td>".(string)$date->name."</td>";
                            echo "<td>".(string)$date->email."</td>";
                            echo "<td><details>
                            <summary>Ver senha</summary>
                             ".(string)$date->password."
                            </details></td>";
                            echo "<td>
                            <div class='buttons'>
                            <a href=adicionar.php class='btn add'>Inserir novo Usuário</a>
                            <a href='atualizar.php?id=$date->id' class='btn atualizar'>Editar Usuário</a>
                            <a href='movimentacao.php' class='btn add'>Movimentação do sistema</a>
                            <a href='remover.php?id=$date->id&pd=$date->name' class='btn remover'>Remover Usuário</a>
                            </div></td>";

                            echo "</tr>";
                        }      
                    } 
                    ?>     

        </table>
    </div>

</body>
</html>