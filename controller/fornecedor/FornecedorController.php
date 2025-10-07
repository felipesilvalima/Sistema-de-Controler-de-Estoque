<?php declare(strict_types=1); 

namespace controller;

use Exception;
use fornecedor\validation\ValidationFornecedor;
use model\Fornecedor as Fornecedor;
use PDOException;

require_once __DIR__.'/../../model/fornecedor/Fornecedor.php';
require_once __DIR__.'/../../controller/produto/ProdutoController.php';
require_once __DIR__.'/../../validation/fornecedor/ValidationFornecedor.php';

class FornecedorController 
{
    private int $id;
    private string $fornecedor;
    private int $cpf;
    private int $telefone;
    private string $endereco;

    public function __construct($dados)
    {
        $this->fornecedor = $dados['fornecedor'];
        $this->cpf = $dados['cpf'];
        $this->telefone = $dados['telefone'];
        $this->endereco = $dados['endereco'];
    }

    // Insere um novo fornecedor
    public function Inserir_fornecedor()
    {
        try 
        {
            // Dados do fornecedor
            $dados = [
                'fornecedor' => $this->fornecedor,
                'cpf' => $this->cpf,
                'telefone' => $this->telefone,
                'endereco' => $this->endereco
            ];
    
            // Valida campos obrigatórios
            $validacao_campos = ValidationFornecedor::validation_fornecedor_fields($dados);
    
            if(!$validacao_campos)
            {
                // Verifica se fornecedor já existe
                $verificando_fornecedor = FornecedorController::verify_fonecedorController($dados['fornecedor']);
                session_write_close();
    
                // Verifica CPF e limites de CPF e telefone
                $verificando_cpf = FornecedorController::verify_cpfController($dados['cpf']);
                $validacao_limit_cpf = ValidationFornecedor::validation_cpf_limit($dados['cpf']);
                session_write_close();
                $validacao_limit_tel = ValidationFornecedor::validation_tel_limit($dados['telefone']);
    
                // Se alguma validação falhar, retorna falso
                if($verificando_fornecedor || $verificando_cpf || $validacao_limit_cpf || $validacao_limit_tel)
                {
                    return false;
                    die;
                }
    
                // Insere fornecedor no banco
                $response = Fornecedor::register_fornec(
                    $this->fornecedor,
                    $this->cpf,
                    $this->telefone,
                    $this->endereco
                );
    
                if($response)
                {
                    ProdutoController::feedback_systm('forne',"Fornecedor inserido com sucesso"); 
                }
                else
                {
                    ProdutoController::feedback_systm('forne_error',"Error ao inserir fornecedor");  
                }
    
                header("Location: lista_de_fornecedor.php");
                die;
            }
    
        } 
        catch (PDOException $error) 
        {
           throw new Exception("Error no metodo (Inserir_fornecedor): ".$error->getMessage());
        }
    }
    
    // Verifica se fornecedor já existe
    public static function verify_fonecedorController($fornecedor)
    {
        try 
        {
            $response = Fornecedor::verify_fornecedor($fornecedor);
    
            if($response)
            {
                http_response_code(409); // Recurso já existe
                ProdutoController::feedback_systm('forne_inserir',"Esse Fornecedor já foi inserido");
                return true;
            }
    
            return false;
             
        } 
        catch (PDOException $error) 
        {
           throw new Exception("Error no metodo (verify_fonecedorController): ".$error->getMessage());
        }
    }
    
    // Verifica se CPF já existe
    public static function verify_cpfController($cpf)
    {
        try 
        {
            $response = Fornecedor::verify_cpf($cpf);
    
            if($response)
            {
                http_response_code(409); // Recurso já existe
                ProdutoController::feedback_systm('forne_cpf',"Esse Cpf já foi inserido");
                return true;
            }
    
            return false;
             
        } 
        catch (PDOException $error) 
        {
           throw new Exception("Error no metodo (verify_cpfController): ".$error->getMessage());
        }
    }
    
    // Lista todos os fornecedores
    public static function list_forneceController()
    {
        try 
        {
            $response = Fornecedor::list_fornec();
    
            if(!empty($response))
            {
                return $response;
            }
            else
            {
                http_response_code(404); // Nenhum fornecedor encontrado
                ProdutoController::feedback_systm('list_fornec',"Fornecedor não encontrado");
                return false;
            }
             
        } 
        catch (PDOException $error) 
        {
           throw new Exception("Error no metodo (list_forneceController): ".$error->getMessage());
        }
    }
    
    // Retorna fornecedor específico por ID
    public static function get_forneceController($id)
    {
        try 
        {
            $response = Fornecedor::get_fornec($id);
    
            if(!isset($response->id) || empty($id)) 
            {
                http_response_code(404); // Fornecedor não encontrado
                ProdutoController::feedback_systm('existe',"Fornecedor não encontrado!"); 
                header("Location: lista_de_fornecedor.php");
                die;
            }
            else
            {
                return $response;
            }
             
        } 
        catch (PDOException $error) 
        {
           throw new Exception("Error no metodo (get_forneceController): ".$error->getMessage());
        }
    }
    
    // Atualiza fornecedor existente
    public function update_forneceController($id)
    {
        try 
        {
            $response = Fornecedor::update_fornecedor(
                $id,
                $this->fornecedor,
                $this->cpf,
                $this->telefone,
                $this->endereco  
            );
    
            if($response)
            {
                http_response_code(204); // Recurso alterado com sucesso
                ProdutoController::feedback_systm('update_true',"Atualizado com sucesso");
            }  
            else 
            {
                ProdutoController::feedback_systm('update_false',"Error ao atualizar");
            }
    
            header("Location: lista_de_fornecedor.php");
            die; 
        } 
        catch (PDOException $error) 
        {
           throw new Exception("Error no metodo (update_forneceController): " . $error->getMessage());
        }
    }
    
    // Remove fornecedor por ID
    public static function remover_fornecedor($id)
    {
        try
        {
            $remover = Fornecedor::remover_idFornercedor($id); 
    
            if($remover) 
            {
                http_response_code(204); // Recurso removido com sucesso
                ProdutoController::feedback_systm('remover',"Removido com sucesso");
                header("Location: lista_de_fornecedor.php");
                die;
            }
        }
        catch(PDOException $error)
        {
            throw new Exception("Error no metodo (remover_fornecedor): " . $error->getMessage());
        }
    }
    
    // Busca fornecedor pelo nome
    public static function fornecedores($fornecedor)
    {
        try 
        {
            $data = Fornecedor::fornecedor_get($fornecedor); 
            
            if($data) 
            {
                http_response_code(200); // Requisição processada com sucesso
                return $data; 
            }
    
        } 
        catch (PDOException $error) 
        {
            throw new Exception("Error:".$error->getMessage());
        }
    }
    

    
}