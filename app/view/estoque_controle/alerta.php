<?php declare(strict_types=1);

use controller\Controler_estoqueController;
use controller\Feedbacks;

session_start();

require_once __DIR__.'/../../controller/controle_estoque/Controler_estoqueController.php';
require_once __DIR__.'/../../controller/feedbacks/Feedbacks.php';

if(!isset($_SESSION['user']))
{
    header("Location: /controler_de_estoque/view/login/login.php");
    die;
}
session_write_close();

  Controler_estoqueController::Alert_controll();
$titulo = 'Alerta de Estoque';
require __DIR__.'/../partials/head.php';
?>
<h1 class="titulo-adicionar">Alerta de Estoque Baixo</h1>
<details class='mensagem-estoque-alert'>
     <summary style='color: black'>Produtos que estão com estoque baixo!!</summary>
      <?=  Feedbacks::feedback_alerta_de_estoque();?>
 </details>

<a class="voltar-estoque" href="/controler_de_estoque/view/Produtos/index.php">Voltar</a>
<?php require __DIR__.'/../partials/footer.php'; ?>
