<?php declare(strict_types=1); 

namespace controller;

use model\Movimentacao;
require_once __DIR__.'/../model/Movimentacao.php';

class MovimentacaoController
{
    public static function insercao($produto, $quantidade,$id_produto,$user_id)
    {
        $tipo = "Inserção do Produto: $produto";
        $data = date("d/m/Y");
        Movimentacao::movimentacao_de_estoque($tipo,$data, $id_produto, $quantidade,$user_id);
    }

    public static function insercao_fornecedor($fornecedor,$produto_id,$user_id)
    {
        $tipo = "Inserção do Fornecedor: $fornecedor";
        $data = date("d/m/Y");
        Movimentacao::movimentacao_de_estoque($tipo,$data, $produto_id, 1,$user_id);
    }

    public static function remocao($produto_id,$produto,$user_id)
    {
        $tipo = "Remoção do Produto: $produto";
        $data = date("d/m/Y");
        Movimentacao::movimentacao_de_estoque($tipo,$data, $produto_id, 1,$user_id);
    }

    public static function entrada($produto,$quantidade) //faltar alterar
    {
        $tipo = "Entrada do Produto: $produto";
        $data = date("d/m/Y");
        $produto_id = 2;
        $user_id = 2;
        Movimentacao::movimentacao_de_estoque($tipo,$data, $produto_id, $quantidade,$user_id);
    }

    public static function saida($produto,$quantidade) //faltar alterar
    {
        $tipo = "Baixa no Produto: $produto";
        $data = date("d/m/Y");
        $produto_id = 2;
        $user_id = 2;
        Movimentacao::movimentacao_de_estoque($tipo,$data, $produto_id, $quantidade,$user_id);
    }

    public static function update_product($produto,$quantidade) //faltar alterar
    {
        $tipo = "Alteração no Produto: $produto";
        $data = date("d/m/Y");
        $produto_id = 2;
        $user_id = 2;
        Movimentacao::movimentacao_de_estoque($tipo,$data, $produto_id, $quantidade,$user_id);
    }

    public static function update_fornec($fornecedor) //faltar alterar
    {
        $tipo = "Alteração no Fornecedor: $fornecedor";
        $data = date("d/m/Y");
        $produto_id = 2;
        $user_id = 2;
        Movimentacao::movimentacao_de_estoque($tipo,$data, $produto_id, 1,$user_id);
    }

     public static function remocao_fornecedor($fornecedor) //faltar alterar
    {
        $tipo = "Remoção do Fornecedor: $fornecedor";
        $data = date("d/m/Y");
        $produto_id = 2;
        $user_id = 2;
        Movimentacao::movimentacao_de_estoque($tipo,$data, $produto_id, 1,$user_id);
    }
}