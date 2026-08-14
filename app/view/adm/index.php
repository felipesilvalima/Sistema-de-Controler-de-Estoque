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

$titulo = 'Usuários';
require __DIR__.'/../partials/head.php';
?>
    <div class="titulo">
        <h1>Tabela de Usuários</h1>
        <a href="/controler_de_estoque/view/loginAdm/login.php" class="btn sair">Sair</a>
    </div>

    <div class="form">
    <form action="index.php" method="get">
        <input type="search" name="pesquisar" placeholder="Buscar Usuário...">
        <button type="submit" class="btn search">Procurar</button>
        <button type="submit" class="btn all">Ver todos os usuários</button>
        <a href='movimentacao.php' class='btn add'>Movimentação do sistema</a> 
        <a href=/controler_de_estoque/view/fornecedor/lista_de_fornecedor.php class='btn add'>Fornecedores</a> 
        <a href=/controler_de_estoque/view/Categoria/lista_de_categoria.php class='btn add'>Categorias</a> 
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
                        <table>
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Senha</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody>";
                        foreach($dados as $date)
                        { 
                            echo "<tr>"; 
                            echo "<td data-label='ID'>".(int)$date->id."</td>";
                            echo "<td data-label='Nome'>".(string)$date->name."</td>";
                            echo "<td data-label='Email'>".(string)$date->email."</td>";
                            echo "<td data-label='Ações' class='acoes'>
                            <div class='buttons'>
                            <a href=adicionar.php class='btn add'>Inserir novo Usuário</a> 
                            <a href='atualizar.php?id=$date->id' class='btn atualizar'>Editar Usuário</a> 
                            <a href='remover.php?id=$date->id&pd=$date->name' onclick='mensagemAlerta()' class='btn remover'>Remover Usuário</a>
                            </div></td>";
                            echo "</tr>";
                        }
                        echo "</tbody></table></div>";
                    }
                    ?>

<?php require __DIR__.'/../partials/footer.php'; ?>
<script>
    function mensagemAlerta(){
        alert('Tem certeza que deseja exlcuir ?')
    }
</script>