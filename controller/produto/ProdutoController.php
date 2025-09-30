<?php declare(strict_types=1); 

namespace controller;

use Exception;
use model\Produto as Produto;
use model\Movimentacao as Movimentacao;

require_once __DIR__.'/../../model/produto/Produto.php';
require_once __DIR__.'/../../controller/movimentacao/MovimentacaoController.php';
use PDOException;
use validation\Produto\ValidationProduto;

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

    public static function index($seach)
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
                header("Location: index.php");
                die;
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


    public function Atulaizar($id,$user_id): bool
    {
        try 
        {

            $details =  ProdutoController::detalhes((int)$id);


                if (empty($details))
                {
                    header("Location: /controler_de_estoque/view/Produtos/index.php");
                    die;
                }
           
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
                    ); 

                        if($update)
                        {
            
                            ProdutoController::feedback_systm('update_true',"Atulizado com sucesso");
                            MovimentacaoController::update_product(
                                $this->produto_name,
                                $this->quantidade_max,
                                $id,
                                $user_id
                            );    
                        }

                            else
                            {
                                ProdutoController::feedback_systm('update_false',"Error ao Atulizar Produto");
                            }
              
                                header("Location: index.php");
                                die;  
 
        } 
            catch (PDOException $error) 
            {
              throw new Exception("Error:".$error->getMessage());      
            }
    }

    public function inseir($user_id)
    {

        try 
        {
             $dados = 
             [
                'produto' => $this->produto_name,
                'preco' =>  $this->preco,
                'quantidade' => $this->quantidade_max,
                'quantidade_min' => $this->quantidade_min,
                'descricao' => $this->descricao,
                'unidade_med' => $this->unidade_medida,
                'categoria' => $this->categoria_id,
                'fornecedor' => $this->fornecedor_id
             ];


            $validation_fields = ValidationProduto::validation_inserir_fields($dados);

            if(!$validation_fields)
            {

                $line = Produto::verificarProduto($this->produto_name);
            
                if($line)  
                {
                    ProdutoController::feedback_systm('existe',"Produto já existe!"); 
                    http_response_code(409);//O recurso já existe, tentativa de duplicação
                    header("Location: index.php");
                    die; 
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
                $user_id
                ); 
                
                if($inserir)
                {
                    ProdutoController::feedback_systm('inserido',"Inserido com sucesso");
                    $data = Produto::last_product();
    
                    MovimentacaoController::insercao(
                    $this->produto_name,
                    $this->quantidade_max,
                    $this->id = $data->id,
                    $user_id);  
                }
                    else
                    {
                        ProdutoController::feedback_systm('inserir_error'," Error ao Inserir Produto");
                    }
    
                    header("Location: index.php");
                    die;
                    
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

            header("Location: index.php");
            die; 
        }
    }

    public static function feedback_systm(string $name_session, string $messagem): void
    {
         session_start(); 
         $_SESSION[$name_session] =  $messagem; 
    }

}
