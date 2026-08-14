<?php

declare(strict_types=1);

session_start();

use controller\Feedbacks;
use controller\ProdutoController;

require_once __DIR__ . '/../../controller/produto/ProdutoController.php';
require_once __DIR__ . '/../../controller/feedbacks/Feedbacks.php';

if (!isset($_SESSION['user'])) {
    header("Location: /controler_de_estoque/view/login/login.php");
    die;
}

$titulo = 'Produtos';
require __DIR__ . '/../partials/head.php';
?>
    <nav>
        <div class="menu">
            <ul>
                <div class="nav">
                    <li><a class="insert" href="adicionar.php">Inserir novo produto</a></li>
                    <li><a class="alert" href="/controler_de_estoque/view/estoque_controle/alerta.php">Alerta de Estoque Baixo</a></li>
                    <li><a class="logout" href="../login/logout.php" onclick = "return confirm('Tem certeza que deseja Sair ?')">Sair</a></li>
                </div>
            </ul>
        </div>
    </nav>

    
    <h1 id="titulo-produtos">Tabela de Produtos</h1>
    <div class="form">
        <form action="index.php" method="get">
            <input class="search" type="search" name="pesquisar" placeholder="Buscar produto...">
            <button class="button-search" type="submit">🔎</button>
            <button class="button-search-all" type="submit" class="btn all">Ver todos os produtos</button>
        </form>
    </div><br>


    <?php

    Feedbacks::feedback_login();
    Feedbacks::feedback_inserir();
    Feedbacks::feedback_remover();
    Feedbacks::feedback_atualizar();
    Feedbacks::feedback_details();

    session_write_close();

    $seach = $_GET['pesquisar'] ?? "";
    $dados = ProdutoController::index($seach);
    

    if (empty($dados)) {
        Feedbacks::feedback_index();
    } else {

        echo "<div class='table'>
                        <table>
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Produto</th>
                            <th>Preço</th>
                            <th>Quantidade</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody>";
        foreach ($dados as $date) {
            echo "<tr>";
                echo "<td data-label='ID'>" . (int)$date->id . "</td>";
                echo "<td data-label='Produto'>" . (string)$date->produto . "</td>";
                echo "<td data-label='Preço'> R$ " . number_format((float)$date->preco, 2, ',', '.') . "</td>";
                echo "<td data-label='Quantidade'>" . (int)$date->quantidade_max . "</td>";
                echo "<td data-label='Ações' class='acoes'>
                        <div class='buttons'>
                        <a href='ver.php?id=$date->id' class='btn-relatorio ver'>Relatório</a>
                        <a href='/controler_de_estoque/view/estoque_controle/entrada_estoque.php?id=$date->id' class='btn-entrada'>Entrada de Estoque</a>
                        <a href='/controler_de_estoque/view/estoque_controle/saida_estoque.php?id=$date->id' class='btn-baixa'>Saida de Estoque</a>
                        <a href='atualizar.php?id=$date->id' class='btn-atualizar'>Editar Produto</a>
                        <a href='remover.php?id=$date->id&pd=$date->produto' class='btn-remover' onclick='return confirm(\"Tem certezar que deseja Remover ?\")'>Remover Produto</a>
                        </div>
                     </td>";
            echo "</tr>";
        }
        echo "</tbody></table></div>";
    }
    ?>

<?php require __DIR__ . '/../partials/footer.php'; ?>