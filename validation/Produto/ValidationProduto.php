<?php declare(strict_types=1); 

namespace validation\Produto;

use controller\ProdutoController;
require_once __DIR__.'/../../controller/produto/ProdutoController.php';

class ValidationProduto
{
    

    public static function validation_inserir_fields(array $dados)
    {
        if(empty($dados['produto']) || empty($dados['preco']) || empty($dados['quantidade']) || empty($dados['quantidade_min']) || empty($dados['descricao']) || empty($dados['unidade_med'])  || empty($dados['categoria'])  || empty($dados['fornecedor']))
        {
             ProdutoController::feedback_systm('fields_empty',"Preencher todos os campos vazios!");
             return true;
        }
    }

    public static function validation_entrada(int $entrada)
    {
        if(empty($entrada))
        {
             ProdutoController::feedback_systm('fields_empty_estoque',"Preencha o campo vazio!");
             return true;
        }
    }

    public static function validation_saida(int $saida)
    {
        if(empty($saida))
        {
             ProdutoController::feedback_systm('fields_empty_estoque',"Preencha o campo vazio!");
             return true;
        }
    }

   

    
}