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

 Feedbacks::feedback_details();
 Feedbacks::feedback_atualizar();
 Feedbacks::feedback_remover();
 Feedbacks::fornecedor_inserir();
 
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
        echo "<td>" . preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/','$1.$2.$3-$4',(string)$date->cpf) . "</td>";
        echo "<td>" . preg_replace('/(\d{2})(\d{5})(\d{4})/','($1) $2-$3',(string)$date->telefone) . "</td>";
        echo "<td>
            <a href='relatorio.php?id=$date->id'>Relatório</a>
            <a href='update_fornecedor.php?id=$date->id'>Editar Fornecedor</a>
            <a href='remover_fornecedor.php?id=$date->id'>Remover Fornecedor</a>
            
            </td>";

        echo "</tr>";
    }
}

?>
</table>
<a href="/controler_de_estoque/view/fornecedor/cadastrar_fornecedor.php">Inserir novo fornecedor</a> <br><br>
<a href="/controler_de_estoque/view/adm/index.php">Voltar</a>