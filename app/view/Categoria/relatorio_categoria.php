<?php declare(strict_types=1);

use controller\CategoriaController;
require_once __DIR__.'/../../controller/categoria/CategoriaController.php';

$id = $_REQUEST['id'];

 $categoria = CategoriaController::categoria_relatorio((int)$id);


 echo" <p><strong>ID:</strong> $categoria->id</p>";
 echo" <p><strong>Categoria:</strong> $categoria->categoria</p>";
 echo"<details>
        <summary><strong>Descição</strong></summary>
        <p>$categoria->descricao</p>
     </details>";


 ?>
 <a href="lista_de_categoria.php">Voltar</a> <br><br>


