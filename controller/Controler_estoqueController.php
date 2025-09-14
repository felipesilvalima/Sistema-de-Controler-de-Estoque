<?php declare(strict_types=1); 

namespace controller;

use Exception;
use model\Controler_estoque;
use model\Produto;
use PDOException;

require_once __DIR__.'/../model/Controler_estoque.php';
require_once __DIR__.'/../controller/ProdutoController.php';
require_once __DIR__.'/../controller/MovimentacaoController.php';

class Controler_estoqueController
{

   public static function Alert_controll()
   {
        try 
        {
            $datas =  Controler_estoque::get_quant_min_max();
            
             if($datas > 0)
             {
                 $alerta_estoque = 0;

                 foreach($datas as $data)
                 {
                     if($data->quantidade_max <= $data->quantidade_min)
                     {
                         session_write_close();
                         $alerta_estoque = 1;
                         http_response_code(200);//requisição foi processada com sucesso
                         echo "O produto $data->produto está com estoque baixo!!<br>"; 
                     }
                 }
                    if($alerta_estoque == 0)
                    {
                         http_response_code(200);//requisição foi processada com sucesso
                        echo "Sem Alerta de estoque baixo!!<br>"; 
                    }
     
                 return true;
             }
                 else
                 {
                    http_response_code(204);//recurso encontrado, mas não há conteúdo para retornar.
                     ProdutoController::feedback_systm('estoque_error',"O seu estoque está vázio!!");
                     return false;
                 }
            
        } catch (PDOException $error) {
            throw new Exception("Error no método (Alert_controll).  Error: ".$error->getMessage());
        }
   }


    public static function Entrada_estoque($id,$produto,$preco,$quantidade,$quantidade_min,$descricao,$unidade_medida,$categoria,$fornecedor, $user_id)
    {
        try 
        {
            
            $quantidade_max = ProdutoController::detalhes($id);
            $quantidade_entrada = $quantidade;
            $quantidade += $quantidade_max->quantidade_max;
           
            $entrada = Controler_estoque::update_date_estoque($id,$produto,$preco, $quantidade, $quantidade_min,$descricao,$unidade_medida,$categoria,$fornecedor); 

                if($entrada)
                {
                    ProdutoController::feedback_systm('update_true',"Quantidade Inserida com sucesso");
                    $produto_id = $id;
                    MovimentacaoController::entrada($produto,$quantidade_entrada,$produto_id, $user_id);  
                    return true; 
                }
                
 
        } 
            catch (PDOException $error) 
            {
              throw new Exception("Error:".$error->getMessage());      
            }
    }

    public static function Saida_estoque($id,$produto,$preco,$quantidade,$quantidade_min,$descricao,$unidade_medida,$categoria,$fornecedor, $user_id)
    {
        try 
        {
            
            $quantidade_max = ProdutoController::detalhes($id);
            $quantidade_saida = $quantidade;
            $quantidade_new = $quantidade_max->quantidade_max;
            $quantidade_new -= $quantidade; 
            
            if($quantidade_new < 0)
            {
                $quantidade_new = 0;
            }
           
            $entrada = Controler_estoque::update_date_estoque($id,$produto,$preco, $quantidade_new, $quantidade_min,$descricao,$unidade_medida,$categoria,$fornecedor); 

                if($entrada)
                {
                     http_response_code(200);//requisição foi processada com sucesso
                    ProdutoController::feedback_systm('update_true',"Quantidade removida com sucesso");
                    $produto_id = $id;
                    MovimentacaoController::saida($produto,$quantidade_saida,$produto_id,$user_id); 
                    return true; 
                }
                
 
        } 
            catch (PDOException $error) 
            {
              throw new Exception("Error:".$error->getMessage());      
            }
    }
}