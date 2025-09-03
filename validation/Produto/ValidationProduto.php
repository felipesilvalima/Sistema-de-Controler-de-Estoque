<?php declare(strict_types=1); 

namespace validation\Produto;

use controller\ProdutoController;
require_once __DIR__.'/../../controller/ProdutoController.php';

class ValidationProduto
{
    

    public static function validation_inserir_fields($produto,$preco,$quantidade,$quantidade_min,$descrição,$unidade_medida,$categoria,$fornecedor,$user)
    {
        if(empty($produto) || empty($preco) || empty($quantidade) || empty($quantidade_min) || empty($descrição) || empty($unidade_medida)  || empty($categoria)  || empty($fornecedor) || empty($user))
        {
             ProdutoController::feedback_systm('fields_empty',"Preencher todos os campos vazios!");
             return true;
        }
    }

   

    
}