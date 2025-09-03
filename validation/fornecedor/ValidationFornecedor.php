<?php declare(strict_types=1); 

namespace fornecedor\validation;

use controller\ProdutoController;

require_once __DIR__.'/../../controller/ProdutoController.php';

class ValidationFornecedor
{
    public static function validation_fornecedor_fields($fornecedor,$cpf,$telefone,$endereco)
    {
        if(empty($fornecedor) || empty($cpf) || empty($telefone) || empty($endereco))
        {
            ProdutoController::feedback_systm('fields_empty',"Preencher todos os campos vazios!");
             return true;
        }
    }
}