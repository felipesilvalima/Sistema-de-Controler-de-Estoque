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
    private float $preco;
    private int $quantidade_max;
    private int $quantidade_min;
    private string $descricao;
    private string $unidade_medida;
    private int $categoria_id;
    private int $fornecedor_id;
    private int $user_id;

    public function __construct(array $dados)
    {
        $this->produto_name = $dados[''];
        $this->preco = $dados[''];
        $this->quantidade_max = $dados[''];
        $this->quantidade_min = $dados[''];
        $this->descricao = $dados[''];
        $this->unidade_medida = $dados[''];
        $this->categoria_id = $dados[''];
        $this->fornecedor_id = $dados[''];
        $this->user_id = $dados[''];
    }

    public static function index($seach): array
    {
        try 
        {

          $datas =  Produto::get_date($seach); 
            
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

    public static function detalhes($id_produto): object
    {
        try
        {
            $line = Produto::get_id($id_produto); 
            
            if (!isset($line->id) || empty($id_produto)) 
            {
                 http_response_code(404);//O recurso solicitado não existe
                ProdutoController::feedback_systm('existe',"Produto não encontrado!"); 
                return $line;
            }
                else 
                {
                    http_response_code(200);//requisição foi processada com sucesso
                    return $line; 
                }

        }
            catch(PDOException $error)
            {
                throw new Exception("Error:".$error->getMessage());
            }
        
    }


    public function Atulaizar($id): bool
    {
        try 
        {
           
            $update = Produto::update_date(
            $id,
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

                if($update)
                {
            
                    ProdutoController::feedback_systm('update_true',"Atulizado com sucesso");

                    MovimentacaoController::update_product(
                        $this->produto_name,
                        $this->quantidade_max,
                        $id,
                        $this->user_id
                    ); 
                    return true; 
                }
              
                return false; 
 
        } 
            catch (PDOException $error) 
            {
              throw new Exception("Error:".$error->getMessage());      
            }
    }

    public function inseir()
    {

        try 
        {
            
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

    public static function remover_id($id,$produto,$user_id)
    {
    
        $remover = Produto::remover($id); 

        if($remover) 
        {
            
            ProdutoController::feedback_systm('remover',"Removido com sucesso");

            MovimentacaoController::remocao(
            $id,
            $produto,
            $user_id
            );
            return true; 
        }
    }

    public static function feedback_systm(string $name_session, string $messagem): void
    {
         session_start(); 
         $_SESSION[$name_session] =  $messagem; 
    }

     
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getQuantidade_min()
    {
        return $this->quantidade_min;
    }
 
    public function setQuantidade_min($quantidade_min)
    {
        $this->quantidade_min = $quantidade_min;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }
 
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    public function getUnidade_medida()
    {
        return $this->unidade_medida;
    }

    public function setUnidade_medida($unidade_medida)
    {
        $this->unidade_medida = $unidade_medida;
    }

    public function getCategoria_id()
    {
        return $this->categoria_id;
    }

    public function setCategoria_id($categoria_id)
    {
        $this->categoria_id = $categoria_id;
    }

    public function getFornecedor_id()
    {
        return $this->fornecedor_id;
    }
 
    public function setFornecedor_id($fornecedor_id)
    {
        $this->fornecedor_id = $fornecedor_id;
    }
 
    public function getUser_id()
    {
        return $this->user_id;
    }

    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;
    }
}
