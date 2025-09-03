<?php

declare(strict_types=1);

use controller\Feedbacks;
use controller\FornecedorController;

require_once __DIR__ . '/../../controller/FornecedorController.php';
require_once __DIR__ . '/../../controller/Feedbacks.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: /controler_de_estoque/view/login/login.php");
    die;
}

$dados = FornecedorController::list_forneceController();

 Feedbacks::feedback_details();
 Feedbacks::feedback_atualizar();
 Feedbacks::feedback_remover();

if (!$dados) {
    Feedbacks::fornecedor_list();
} else {

    echo "<div class='table'>
                              <table border='1'>
                              <tr>
                                  <th>ID</th>
                                  <th>Fornecedor</th>
                                  <th>Cpf</th>
                                  <th>Telefone</th>
                                  <th>Ações</th>
                              </tr>";
    foreach ($dados as $date) {

        echo "<tr>";

        echo "<td>" . (int)$date->id . "</td>";
        echo "<td>" . (string)$date->fornecedor . "</td>";
        echo "<td>" . (string)$date->cpf . "</td>";
        echo "<td>" . (string)$date->telefone . "</td>";
        echo "<td>
            <a href='relatorio.php?id=$date->id'>Relatório</a>
             <a href='update_fornecedor.php?id=$date->id'>Editar Fornecedor</a>
              <a href='remover_fornecedor.php?id=$date->id&pd=$date->fornecedor'>Remover Fornecedor</a>
            
            </td>";

        echo "</tr>";
    }
}

?>
</table>
<a href="/controler_de_estoque/view/fornecedor/cadastrar_fornecedor.php">Cadastrar fornecedor</a> <br><br>
<a href="/controler_de_estoque/view/Produtos/index.php">Voltar</a>