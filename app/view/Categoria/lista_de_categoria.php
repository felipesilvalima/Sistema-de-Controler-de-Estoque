<?php declare(strict_types=1);
session_start();

use controller\CategoriaController;

if(!isset($_SESSION['user_adm']))
{
    header("Location: /controler_de_estoque/view/loginAdm/logout.php");
    die;
}

require_once __DIR__.'/../../controller/categoria/CategoriaController.php';

$categorias = CategoriaController::categorias("");

$titulo = 'Categorias';
require __DIR__.'/../partials/head.php';
?>

<div class="titulo"><h1>Categorias</h1></div>

<div class="table">
    <table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Categoria</th>
        <th>Descrição</th>
        <th>Ações</th>
    </tr>
    </thead>
    <tbody>
    <?php
    
        foreach($categorias as $categoria )
        {
          echo"
        <tr>
            <td data-label='ID'>$categoria->id</td>
            <td data-label='Categoria'>$categoria->categoria</td>
            <td data-label='Descrição'>
                <details>
                    <summary>Descrição</summary>
                    <p>$categoria->descricao</p>
                </details>
            </td>
            <td data-label='Ações' class='acoes'>
                <div class='buttons'>
                <a href='relatorio_categoria.php?id=$categoria->id' class='btn ver'>Relatório</a>
                <span class='btn desabilitado' title='Tela ainda não implementada'>Editar</span>
                <span class='btn desabilitado' title='Tela ainda não implementada'>Remover</span>
                </div>
            </td>
        </tr>";
        }
    ?>
</tbody>
</table>
</div>
<div class="acoes-pagina">
    <span class="btn desabilitado" title="Tela ainda não implementada">Inserir nova Categoria</span>
    <a href="/controler_de_estoque/view/adm/index.php">Voltar</a>
</div>
<?php require __DIR__.'/../partials/footer.php'; ?>
