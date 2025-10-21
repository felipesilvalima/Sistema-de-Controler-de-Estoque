<?php declare(strict_types=1); 

namespace Login\validation;

use controller\ProdutoController;
require_once __DIR__.'/../../controller/produto/ProdutoController.php';

class ValidationLogin
{
     public static function validation_login_fields($user,$password)
    {
        if(empty($user) || empty($password))
        {
            ProdutoController::feedback_systm('fields_empty',"Preencher todos os campos vazios!");
             return true;
        }
    }
}