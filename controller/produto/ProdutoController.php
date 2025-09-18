<?php declare(strict_types=1); 

namespace controller;

use Exception;
use model\Produto as Produto;
use model\Movimentacao as Movimentacao;

require_once __DIR__.'/../../model/produto/Produto.php';
require_once __DIR__.'/../../controller/movimentacao/MovimentacaoController.php';
use PDOException;

class ProdutoController extends Produto
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


    public function index($seach): array
    {
        try 
        {
          $this->produto_name = $seach;
          $datas =  Produto::get_date($this->produto_name); 
            
          if(!empty($datas))  
          {
             http_response_code(200);//requisição foi processada com sucesso
             return $datas; 
          }

            else 
            {
                http_response_code(404);//O recurso solicitado não existe
                ProdutoController::feedback_systm('Encontrado',"Produto não encontrado!"); 
                return $datas; 
            }
        } 

            catch (PDOException $error) 
            {
                throw new Exception("Error:".$error->getMessage());
            }
    }

    public function detalhes($id_produto): object
    {
        try
        {
            $this->id = $id_produto;
            $line = Produto::get_id($this->id); 
            
            if (!isset($line->id) || empty($this->id)) 
            {
                 http_response_code(404);//O recurso solicitado não existe
                ProdutoController::feedback_systm('existe',"Produto não encontrado!"); 
                return $line;
            }

              http_response_code(200);//requisição foi processada com sucesso
              return $line; 
        }
            catch(PDOException $error)
            {
                throw new Exception("Error:".$error->getMessage());
            }
        
    }


    public function Atulaizar($id,$produto_name,$preco,$quantidade,$quantidade_min,$descricao,$unidade_medida, $categoria,$fornecedor,$user_id)
    {
        try 
        {
            $this->id = $id;
            $this->produto_name = $produto_name;
            $this->preco = $preco;
            $this->quantidade_max = $quantidade;
            $this->quantidade_min = $quantidade_min;
            $this->descricao = $descricao;
            $this->unidade_medida = $unidade_medida;
            $this->categoria_id = $categoria;
            $this->fornecedor_id = $fornecedor;
            $this->user_id = $user_id;
           
            $update = Produto::update_date(
            $this->id,
            $this->produto_name,
            $this->preco,
            $this->quantidade_max,
            $this->quantidade_min,
            $this->descricao,
            $this->unidade_medida,
            $this->categoria_id,
            $this->fornecedor_id,
            $this->fornecedor_id 
            ); 

                if($update)
                {
            
                    ProdutoController::feedback_systm('update_true',"Atulizado com sucesso");
                    MovimentacaoController::update_product(
                     $this->produto_name,
                     $this->quantidade_max,
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

    public function inseir($produto_name, $preco_pd, $quant_pd, $quantidade_min,$descricao,$unidade_medida,$categoria,$fornecedor,$user)
    {

        try 
        {

            $this->produto_name = $produto_name;
            $this->preco = $preco_pd;
            $this->quantidade_max = $quant_pd;
            $this->quantidade_min = $quantidade_min;
            $this->descricao = $descricao;
            $this->unidade_medida = $unidade_medida;
            $this->categoria_id = $categoria;
            $this->fornecedor_id = $fornecedor;
            $this->user_id = $user;
            
            $line = Produto::verificarProduto($this->produto_name);
            
            while($line)  
            {
                ProdutoController::feedback_systm('existe',"Produto já existe!"); 
                http_response_code(409);//O recurso já existe, tentativa de duplicação
                return false; 
            }

            $inserir = Produto::inserir_produto(
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
            
            if($inserir)
            {
                ProdutoController::feedback_systm('inserido',"Inserido com sucesso");
                $data = Produto::last_product();
                $this->id = $data->id;
                MovimentacaoController::insercao(
                $this->produto_name,
                $this->quantidade_max,
                $this->id,
                $this->user_id);
                return true;  
            }
                
                 
        }
            catch (PDOException $error) 
            {
                throw new Exception("Error:" .$error->getMessage());
            }
    }

    public function remover_id($id,$produto,$user_id)
    {
        $this->id = $id;
        $this->produto_name = $produto;
        $this->user_id = $user_id;

        $remover = Produto::remover($this->id); 

        if($remover) 
        {
            
            ProdutoController::feedback_systm('remover',"Removido com sucesso");
            MovimentacaoController::remocao(
            $this->id,
            $this->produto_name,
            $this->user_id
            );
            return true; 
        }
    }

    public static function feedback_systm(string $name_session, string $messagem): void
    {
         session_start(); 
         $_SESSION[$name_session] =  $messagem; 
    }
}
