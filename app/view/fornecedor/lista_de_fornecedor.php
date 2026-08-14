<?php

declare(strict_types=1);

use controller\Feedbacks;
use controller\FornecedorController;

require_once __DIR__ . '/../../controller/fornecedor/FornecedorController.php';
require_once __DIR__ . '/../../controller/feedbacks/Feedbacks.php';
session_start();

if (!isset($_SESSION['user_adm'])) {
    header("Location: /controler_de_estoque/view/loginAdm/login.php");
    die;
}

$dados = FornecedorController::list_forneceController();

$titulo = 'Fornecedores';
require __DIR__ . '/../partials/head.php';
?>
<div class="titulo"><h1>Fornecedores</h1></div>
<?php
 Feedbacks::feedback_details();
 Feedbacks::feedback_atualizar();
 Feedbacks::feedback_remover();
 Feedbacks::fornecedor_inserir();
 
if (!$dados) {
    Feedbacks::fornecedor_list();
} else {

    echo "<div class='table'>
                              <table>
                              <thead>
                              <tr>
                                  <th>ID</th>
                                  <th>Fornecedor</th>
                                  <th>Cpf</th>
                                  <th>Telefone</th>
                                  <th>Ações</th>
                              </tr>
                              </thead>
                              <tbody>";
    foreach ($dados as $date) {

        echo "<tr>";

        echo "<td data-label='ID'>" . (int)$date->id . "</td>";
        echo "<td data-label='Fornecedor'>" . (string)$date->fornecedor . "</td>";
        echo "<td data-label='Cpf'>" . preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/','$1.$2.$3-$4',(string)$date->cpf) . "</td>";
        echo "<td data-label='Telefone'>" . preg_replace('/(\d{2})(\d{5})(\d{4})/','($1) $2-$3',(string)$date->telefone) . "</td>";
        echo "<td data-label='Ações' class='acoes'>
            <div class='buttons'>
            <a href='relatorio.php?id=$date->id' class='btn ver'>Relatório</a>
            <a href='update_fornecedor.php?id=$date->id' class='btn atualizar'>Editar</a>
            <a href='remover_fornecedor.php?id=$date->id' class='btn remover'>Remover</a>
            </div>
            </td>";

        echo "</tr>";
    }

    // fecha table/div aqui dentro: sem dados, essas tags nem chegam a abrir
    echo "</tbody></table></div>";
}

?>
<div class="acoes-pagina">
    <a href="/controler_de_estoque/view/fornecedor/cadastrar_fornecedor.php">Inserir novo fornecedor</a>
    <a href="/controler_de_estoque/view/adm/index.php">Voltar</a>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>