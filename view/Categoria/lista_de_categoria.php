<?php declare(strict_types=1);
session_start();

use controller\CategoriaController;

if(!isset($_SESSION['user_adm']))
{
    header("Location: /controler_de_estoque/view/loginadm/logout.php");
    die;
}

require_once __DIR__.'/../../controller/categoria/CategoriaController.php';

$categorias = CategoriaController::categorias("");

?>

    <table border='1'>
    <thead align='center'>
    <tr>
        <th>ID</th>
        <th>Categoria</th>
        <th>Descrição</th>
        <th>Ações</th>
    </tr>
    </thead>
    <tbody align='center'>
    <?php
    
        foreach($categorias as $categoria )
        {
          echo"
        <tr>
            <td>$categoria->id</td>
            <td>$categoria->categoria</td>
            <td>
                <details>
                    <summary>Descrição</summary>
                    <p>$categoria->descricao</p>
                </details>
            </td>
            <td>
                <a href='relatorio_categoria.php?id=$categoria->id'>Relatório</a>
                <a href='?id=$categoria->id'>Editar Categoria</a>
                <a href='?id=$categoria->id'>Remover Categoria</a>
            </td>
        </tr>";
        }
    ?>
</tbody>
</table>
<a href="">Inserir nova Categoria</a>
<a href="/controler_de_estoque/view/adm/index.php">Voltar</a>
