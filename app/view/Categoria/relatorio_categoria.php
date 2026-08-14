<?php declare(strict_types=1);

use controller\CategoriaController;
require_once __DIR__.'/../../controller/categoria/CategoriaController.php';

$id = $_REQUEST['id'];

 $categoria = CategoriaController::categoria_relatorio((int)$id);

 $titulo = 'Relatório da Categoria';
 require __DIR__.'/../partials/head.php';

 echo "<div class='detalhes-produto'>";
 echo" <h1>Relatório da Categoria</h1>";
 echo" <p><strong>ID:</strong> $categoria->id</p>";
 echo" <p><strong>Categoria:</strong> $categoria->categoria</p>";
 echo"<details>
        <summary><strong>Descrição</strong></summary>
        <p>$categoria->descricao</p>
     </details>";
 echo" <a href='lista_de_categoria.php' class='btn voltar'>Voltar</a>";
 echo "</div>";

 require __DIR__.'/../partials/footer.php';

