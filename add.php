<?php declare(strict_types=1);

use controller\ProdutoController;

require_once __DIR__.'/controller/produto/ProdutoController.php';

 $dados = 
             [
                'produto' => "",
                'preco' =>  0,
                'quantidade' => 0,
                'quantidade_min' => 0,
                'descricao' => "",
                'unidade_med' => "",
                'categoria' => 0,
                'fornecedor' => 0
             ];

$produto = new ProdutoController($dados);
$produto->inseir(2);
