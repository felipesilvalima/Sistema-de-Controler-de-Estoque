<?php declare(strict_types=1); 

namespace controller;

use model\Movimentacao as Movimentacao;

require_once __DIR__.'/../../model/movimentacao/Movimentacao.php';

class MovimentacaoController 
{
    // Registra a inserção de um produto no estoque
    public static function insercao($produto, $quantidade, $id_produto, $user_id)
    {
        $tipo = "Inserção do Produto: $produto";
        $data = date("d/m/Y");
        Movimentacao::movimentacao_de_estoque($tipo, $data, $id_produto, $quantidade, $user_id);
    }
    
    // Registra a remoção de um produto do estoque
    public static function remocao($produto_id, $produto, $user_id)
    {
        $tipo = "Remoção do Produto: $produto";
        $data = date("d/m/Y");
        Movimentacao::movimentacao_de_estoque($tipo, $data, $produto_id, 1, $user_id);
    }
    
    // Registra a entrada de produtos no estoque
    public static function entrada($produto, $quantidade, $produto_id, $user_id)
    {
        $tipo = "Entrada do Produto: $produto";
        $data = date("d/m/Y");
        Movimentacao::movimentacao_de_estoque($tipo, $data, $produto_id, $quantidade, $user_id);
    }
    
    // Registra a saída/baixa de produtos no estoque
    public static function saida($produto, $quantidade, $produto_id, $user_id)
    {
        $tipo = "Baixa no Produto: $produto";
        $data = date("d/m/Y");
        Movimentacao::movimentacao_de_estoque($tipo, $data, $produto_id, $quantidade, $user_id);
    }
    
    // Registra alteração nos dados de um produto no estoque
    public static function update_product($produto, $quantidade, $produto_id, $user_id)
    {
        $tipo = "Alteração no Produto: $produto";
        $data = date("d/m/Y");
        Movimentacao::movimentacao_de_estoque($tipo, $data, $produto_id, $quantidade, $user_id);
    }
    
 
}