<?php declare(strict_types=1);

  session_start();

use controller\AdmController;
use controller\Feedbacks;
use controller\ProdutoController;

require_once __DIR__.'/../../controller/produto/ProdutoController.php';
require_once __DIR__.'/../../controller/ADM/AdmController.php';
require_once __DIR__.'/../../controller/feedbacks/Feedbacks.php';

if(!isset($_SESSION['user_adm']))
{
    header("Location: /controler_de_estoque/view/loginAdm/logout.php");
    die;
}

$titulo = 'Movimentação';
require __DIR__.'/../partials/head.php';
?>
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
          Feedbacks::limpa_fornec();
          
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
                        <table>
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tipo</th>
                            <th>Data</th>
                            <th>Quantidade</th>
                            <th>Produto</th>
                            <th>Usuário</th>
                        </tr>
                        </thead>
                        <tbody>";
                        foreach($dados as $date)
                        { 
                            echo "<tr>"; 

                            echo "<td data-label='ID'>".(int)$date->id."</td>";
                            echo "<td data-label='Tipo'>".(string)$date->tipo."</td>";
                            echo "<td data-label='Data'>".(string)$date->data."</td>";
                            echo "<td data-label='Quantidade'>".(int)$date->quantidade."</td>";
                            echo "<td data-label='Produto'>".(int)$date->produto_id."</td>";
                            echo "<td data-label='Usuário'>".(int)$date->usuario_responsavel_id."</td>";

                            echo "</tr>";
                        }
                        echo "</tbody></table></div>";
                    }
                    ?>

<?php require __DIR__.'/../partials/footer.php'; ?>