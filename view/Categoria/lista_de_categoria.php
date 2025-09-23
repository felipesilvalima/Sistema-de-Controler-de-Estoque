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

foreach($categorias as $categoria )
{
    echo "
    <table border=1>
    <thead align='center'>
    <tr>
        <th>Categoria</th>
        <th>Descrição</th>
    </tr>
    </thead>
    <tbody align='center'>
    <tr>
        <td>$categoria->categoria</td>
        <td rowspan='3'><details>
                <summary>Descrição</summary>
                <p>$categoria->descricao</p>
            </details></td>
    </tr>
</tbody>
</table>";
}
?>
<a href="/controler_de_estoque/view/adm/index.php">Voltar</a>
