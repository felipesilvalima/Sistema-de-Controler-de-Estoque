<?php declare(strict_types=1);

use controller\Controler_estoqueController;
use controller\Feedbacks;

session_start();

require_once __DIR__.'/../../controller/Controler_estoqueController.php';
require_once __DIR__.'/../../controller/Feedbacks.php';

if(!isset($_SESSION['user']))
{
    header("Location: /controler_de_estoque/view/login/login.php");
    die;
}

$alert = Controler_estoqueController::Alert_controll();

  if($alert)
  {
     Feedbacks::feedback_alerta_de_estoque();
  }

    else
    {
        Feedbacks::feedback_alerta_de_estoque();
    }


?>

<a href="/controler_de_estoque/view/Produtos/index.php">Voltar</a>