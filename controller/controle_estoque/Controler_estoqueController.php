<?php declare(strict_types=1); 

namespace controller;

use Exception;
use model\Controler_estoque as Controler_estoque;
use model\Produto;
use PDOException;
use validation\Produto\ValidationProduto;

require_once __DIR__.'/../../model/controle_estoque/Controler_estoque.php';
require_once __DIR__.'/../../controller/produto/ProdutoController.php';
require_once __DIR__.'/../../controller/movimentacao/MovimentacaoController.php';
require_once __DIR__.'/../../validation/Produto/ValidationProduto.php';

class Controler_estoqueController 
{
    private int $id;
    private string $produto_name;
    private float $preco;
    private int $quantidade_max;
    private string $descricao;
    private int $quantidade_min;
    private string $unidade_medida;
    private int $categoria_id;
    private int $fornecedor_id;
    private int $user_id;

    public function __construct(array $dados)
    {
        $this->produto_name = $dados['produto'];
        $this->preco = $dados['preco'];
        $this->quantidade_max = $dados['quantidade'];
        $this->quantidade_min = $dados['quantidade_min'];
        $this->descricao = $dados['descricao'];
        $this->unidade_medida = $dados['unidade_med'];
        $this->categoria_id = $dados['categoria'];
        $this->fornecedor_id = $dados['fornecedor'];
    }

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
                         $alerta_estoque = 1;
                         http_response_code(200);//requisição foi processada com sucesso
                         Controler_estoqueController::feedback_systm_alert('estoque_alert',"Produto: ". $data->produto);
                     }
                 }
                    if($alerta_estoque == 0)
                    {
                        session_write_close();
                         http_response_code(200);//requisição foi processada com sucesso
                        ProdutoController::feedback_systm('estoque_not_alert',"Sem Alerta de estoque baixo!!"); 
                    }
             }
                 else
                 {
                    http_response_code(204);//recurso encontrado, mas não há conteúdo para retornar.
                     ProdutoController::feedback_systm('estoque_error',"O seu estoque está vázio!!");
                 }
            
        } 
            catch (PDOException $error) 
            {
                 new Exception("Error no método (Alert_controll).  Error: ".$error->getMessage());
            }
   }


    public function Entrada_estoque($id,$user_id)
    {
        try 
        {
            $validacao = ValidationProduto::validation_entrada($this->quantidade_max);  

            if(!$validacao)
            {

                $quantidade_max = ProdutoController::detalhes($id);
               
                if (!$quantidade_max) 
                {
                    header("Location: /controler_de_estoque/view/Produtos/index.php");
                    die;
                }
    
                $quantidade_entrada = $this->quantidade_max;
                $this->quantidade_max += $quantidade_max->quantidade_max;
               
                $entrada = Controler_estoque::update_date_estoque(
                    $id,
                    $this->produto_name,
                    $this->preco,
                    $this->quantidade_max,
                    $this->quantidade_min,
                    $this->descricao,
                    $this->unidade_medida,
                    $this->categoria_id,
                    $this->fornecedor_id,
                    $user_id
                ); 
    
                    if($entrada)
                    {
                        ProdutoController::feedback_systm('update_true',"Quantidade Inserida com sucesso");
                        MovimentacaoController::entrada(
                        $this->produto_name,
                        $quantidade_entrada,
                        $id,
                        $user_id
                        );
                        header("Location: /controler_de_estoque/view/Produtos/index.php");
                        die;  
                    }
                        else 
                        {
                            ProdutoController::feedback_systm('update_false'," Error ao inserir Quantidade");
                        } 
            }
            
        } 
            catch (PDOException $error) 
            {
              throw new Exception("Error:".$error->getMessage());      
            }
    }

    public function Saida_estoque($id,$user_id)
    {
        try 
        {
            $validacao = ValidationProduto::validation_entrada($this->quantidade_max);

            if(!$validacao)
            {

                $quantidade_max = ProdutoController::detalhes($id);
    
                if (!$quantidade_max) 
                {
                    header("Location: /controler_de_estoque/view/Produtos/index.php");
                    die;
                }
    
                $quantidade_saida = $this->quantidade_max;
    
                $this->quantidade_max = $quantidade_max->quantidade_max - $quantidade_saida; 
                
                if( $this->quantidade_max < 0)
                {
                    $this->quantidade_max = 0;
                }
               
                $entrada = Controler_estoque::update_date_estoque(
                    $id,
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
                        ProdutoController::feedback_systm('update_false',"Quantidade removida com sucesso");
                        MovimentacaoController::saida(
                        $this->produto_name,
                        $quantidade_saida,
                        $id,
                        $user_id
                        );
                        header("Location: /controler_de_estoque/view/Produtos/index.php");
                        die; 
                    
                    }
                        else 
                        {
                            ProdutoController::feedback_systm('update_false'," Error ao remover Quantidade");
                        }      
            }
          
 
        } 
            catch (PDOException $error) 
            {
              throw new Exception("Error:".$error->getMessage());      
            }
    }

    public static function feedback_systm_alert(string $name_session, string $messagem): void
    {
         $_SESSION[$name_session][] =  $messagem;
    }

}