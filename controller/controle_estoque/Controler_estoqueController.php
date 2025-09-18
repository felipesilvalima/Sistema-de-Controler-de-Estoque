<?php declare(strict_types=1); 

namespace controller;

use Exception;
use model\Controler_estoque as Controler_estoque;
use model\Produto;
use PDOException;

require_once __DIR__.'/../../model/controle_estoque/Controler_estoque.php';
require_once __DIR__.'/../../controller/produto/ProdutoController.php';
require_once __DIR__.'/../../controller/movimentacao/MovimentacaoController.php';

class Controler_estoqueController extends Controler_estoque
{
    private int $id;
    private string $produto_name;
    private string $descricao;
    private float $preco;
    private int $quantidade_max;
    private int $quantidade_min;
    private string $unidade_medida;
    private int $categoria_id;
    private int $fornecedor_id;
    private int $user_id;

   public static function Alert_controll(): bool
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


    public function Entrada_estoque($id,$produto,$preco,$quantidade,$quantidade_min,$descricao,$unidade_medida,$categoria,$fornecedor, $user_id)
    {
        try 
        {
            $this->id = $id;
            $this->produto_name = $produto;
            $this->preco = $preco;
            $this->quantidade_max = $quantidade;
            $this->quantidade_min = $quantidade_min;
            $this->descricao = $descricao;
            $this->unidade_medida = $unidade_medida;
            $this->categoria_id = $categoria;
            $this->fornecedor_id = $fornecedor;
            $this->user_id = $user_id;
            
            $produtoController = new ProdutoController();
            $quantidade_max = $produtoController->detalhes($id);
            $quantidade_entrada = $this->quantidade_max;
            $this->quantidade_max += $quantidade_max->quantidade_max;
           
            $entrada = Controler_estoque::update_date_estoque(
                $this->id,
                $this->produto_name,
                $this->preco,
                $this->quantidade_max,
                $this->quantidade_min,
                $this->descricao,
                $this->unidade_medida,
                $this->categoria_id,
                $this->fornecedor_id,
                $this->user_id
            ); 

                if($entrada)
                {
                    ProdutoController::feedback_systm('update_true',"Quantidade Inserida com sucesso");
                    MovimentacaoController::entrada(
                    $this->produto_name,
                    $quantidade_entrada,
                    $this->id,
                    $this->user_id
                );  
                    return true; 
                }
                
 
        } 
            catch (PDOException $error) 
            {
              throw new Exception("Error:".$error->getMessage());      
            }
    }

    public function Saida_estoque($id,$produto,$preco,$quantidade,$quantidade_min,$descricao,$unidade_medida,$categoria,$fornecedor, $user_id)
    {
        try 
        {
          
            $this->id = $id;
            $this->produto_name = $produto;
            $this->preco = $preco;
            $this->quantidade_max = $quantidade;
            $this->quantidade_min = $quantidade_min;
            $this->descricao = $descricao;
            $this->unidade_medida = $unidade_medida;
            $this->categoria_id = $categoria;
            $this->fornecedor_id = $fornecedor;
            $this->user_id = $user_id;

            $produtoController = new ProdutoController();
            $quantidade_max = $produtoController->detalhes($id);
            $quantidade_saida = $this->quantidade_max;

            $this->quantidade_max = $quantidade_max->quantidade_max - $quantidade_saida; 
            
            if( $this->quantidade_max < 0)
            {
                $this->quantidade_max = 0;
            }
           
            $entrada = Controler_estoque::update_date_estoque(
                $this->id,
                $this->produto_name,
                $this->preco,
                $this->quantidade_max,
                $this->quantidade_min,
                $this->descricao,
                $this->unidade_medida,
                $this->categoria_id,
                $this->fornecedor_id
            ); 

                if($entrada)
                {
                     http_response_code(200);//requisição foi processada com sucesso
                    ProdutoController::feedback_systm('update_true',"Quantidade removida com sucesso");
                    MovimentacaoController::saida(
                    $this->produto_name,
                    $quantidade_saida,
                    $this->id,
                    $this->user_id
                ); 
                    return true; 
                }
                
 
        } 
            catch (PDOException $error) 
            {
              throw new Exception("Error:".$error->getMessage());      
            }
    }
}