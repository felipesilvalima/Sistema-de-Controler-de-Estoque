<?php declare(strict_types=1); 

namespace controller;

use Exception;
use model\Produto as Produto;
use model\Movimentacao as Movimentacao;

require_once __DIR__.'/../../model/produto/Produto.php';
require_once __DIR__.'/../../controller/movimentacao/MovimentacaoController.php';
use PDOException;
use validation\Produto\ValidationProduto;

class ProdutoController
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
            // Busca produtos por termo de pesquisa
            $datas = Produto::get_date($seach); 
            
            if(!empty($datas))  
            {
                http_response_code(200); // Sucesso na requisição
                return $datas; 
            }
            else 
            {
                http_response_code(404); // Produto não encontrado
                ProdutoController::feedback_systm('Encontrado', "Produto não encontrado!");
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
            // Busca produto pelo ID
            $line = Produto::get_id($id_produto); 
            
            if (!isset($line->id) || empty($id_produto)) 
            {
                http_response_code(404); // Produto não encontrado
                ProdutoController::feedback_systm('existe', "Produto não encontrado!");
                header("Location: index.php");
                die;
            }
            else 
            {
                http_response_code(200); // Sucesso
                return $line; 
            }
        }
        catch(PDOException $error)
        {
            throw new Exception("Error:".$error->getMessage());
        }
    }
    
    public function Atulaizar($id, $user_id): bool
    {
        try 
        {
            // Recupera detalhes do produto
            $details = ProdutoController::detalhes((int)$id);
    
            if (empty($details))
            {
                header("Location: /controler_de_estoque/view/Produtos/index.php");
                die;
            }
    
            // Atualiza produto no banco
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
                ProdutoController::feedback_systm('update_true', "Atualizado com sucesso");
                MovimentacaoController::update_product(
                    $this->produto_name,
                    $this->quantidade_max,
                    $id,
                    $user_id
                );    
            }
            else
            {
                ProdutoController::feedback_systm('update_false', "Erro ao Atualizar Produto");
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
            // Prepara dados do produto
            $dados = [
                'produto' => $this->produto_name,
                'preco' => $this->preco,
                'quantidade' => $this->quantidade_max,
                'quantidade_min' => $this->quantidade_min,
                'descricao' => $this->descricao,
                'unidade_med' => $this->unidade_medida,
                'categoria' => $this->categoria_id,
                'fornecedor' => $this->fornecedor_id
            ];
    
            // Valida campos obrigatórios
            $validation_fields = ValidationProduto::validation_inserir_fields($dados);
    
            if(!$validation_fields)
            {
                // Verifica se o produto já existe
                $line = Produto::verificarProduto($this->produto_name);
    
                if($line)  
                {
                    ProdutoController::feedback_systm('existe', "Produto já existe!");
                    http_response_code(409); // Conflito (duplicação)
                    header("Location: index.php");
                    die; 
                }
    
                // Insere produto no banco
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
                    ProdutoController::feedback_systm('inserido', "Inserido com sucesso");
                    $data = Produto::last_product();
    
                    // Registra movimentação
                    MovimentacaoController::insercao(
                        $this->produto_name,
                        $this->quantidade_max,
                        $this->id = $data->id,
                        $user_id
                    );  
                }
                else
                {
                    ProdutoController::feedback_systm('inserir_error', "Erro ao Inserir Produto");
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
    
    public static function remover_id($id, $produto, $user_id)
    {
        // Remove produto pelo ID
        $remover = Produto::remover($id); 
    
        if($remover) 
        {
            ProdutoController::feedback_systm('remover', "Removido com sucesso");
    
            // Registra movimentação de remoção
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
        // Cria sessão para mensagens de feedback
        session_start(); 
        $_SESSION[$name_session] = $messagem;  
    }
    

}
