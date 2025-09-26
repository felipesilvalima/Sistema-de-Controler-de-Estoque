<?php declare(strict_types=1); 

namespace fornecedor\validation;

use controller\ProdutoController;

require_once __DIR__.'/../../controller/produto/ProdutoController.php';

class ValidationFornecedor
{
    public static function validation_fornecedor_fields(array $dados)
    {
        if(empty($dados['fornecedor']) || empty($dados['cpf']) || empty($dados['telefone']) || empty($dados['endereco']))
        {
            ProdutoController::feedback_systm('fields_empty',"Preencher todos os campos vazios!");
             return true;
        }
    }

    public static function validation_cpf_limit($cpf)
    {
        if(strlen((string)$cpf) != 11)
        {
            ProdutoController::feedback_systm('fields_cpf_limit',"Cpf tem que ter 11 digitos!");
            return true;
        }
    }

    public static function validation_tel_limit($telefone)
    {
        if(strlen((string)$telefone) != 11)
        {
            ProdutoController::feedback_systm('fields_telefone_limit',"Telefone tem que ter 11 digitos!");
            return true;
        }
    }

}