<?php declare(strict_types=1); 

namespace controller;

use Exception;
use fornecedor\validation\ValidationFornecedor;
use model\Fornecedor as Fornecedor;
use PDOException;

require_once __DIR__.'/../../model/fornecedor/Fornecedor.php';
require_once __DIR__.'/../../controller/produto/ProdutoController.php';
require_once __DIR__.'/../../validation/fornecedor/ValidationFornecedor.php';

class FornecedorController extends Fornecedor
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

    public function Inserir_fornecedor()
    {
        try 
        {
            $dados = 
            [
                'fornecedor' => $this->fornecedor,
                'cpf' => $this->cpf,
                'telefone' => $this->telefone,
                'endereco' => $this->endereco
            ];

            $validacao_campos = ValidationFornecedor::validation_fornecedor_fields($dados); // verificar se os campos estão vazios

            if(!$validacao_campos)
            {
                $verificando_fornecedor = FornecedorController::verify_fonecedorController($dados['fornecedor']); // verificando se o fornencedor já existe no BD
                session_write_close();
                $verificando_cpf = FornecedorController::verify_cpfController($dados['cpf']); // verificando se o cpf já existe no BD
                session_write_close();
                $validacao_limit_cpf = ValidationFornecedor::validation_cpf($dados['cpf']); // verificando se o cpf tem 11 digitos
                   
                    if($verificando_fornecedor || $verificando_cpf || $validacao_limit_cpf) // se não passa pela validação retornar falso
                    {
                        return false;
                    }

                        $response = Fornecedor::register_fornec // se passa inserir regristros
                        (
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

    public static function verify_fonecedorController($fornecedor)
    {
        try 
        {

            $response = Fornecedor::verify_fornecedor($fornecedor);
    
            if($response)
            {
                http_response_code(409);//O recurso já existe, tentativa de duplicação
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

    public static function verify_cpfController($cpf)
    {

        try 
        {
            $response = Fornecedor::verify_cpf($cpf);
           
            if($response)
            {
                http_response_code(409);//O recurso já existe, tentativa de duplicação
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
                    http_response_code(404);//O recurso solicitado não existe
                    ProdutoController::feedback_systm('list_fornec',"Fornecedor não encontrado");
                    return false;
                }
             
        } 
            catch (PDOException $error) 
            {
               throw new Exception("Error no metodo (verify_cpfController): ".$error->getMessage());
            }
    }

    public static function get_forneceController($id)
    {
        try 
        {

            $response = Fornecedor::get_fornec($id);

            if(!isset($response->id) || empty($id)) 
            {
                http_response_code(404);//O recurso solicitado não existe
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
                http_response_code(204);//Recurso alterado com sucesso
                ProdutoController::feedback_systm('update_true',"Atulizado com sucesso");
               
            }  
                else 
                {
                    ProdutoController::feedback_systm('update_false',"error ao Atulizar");
                }
                
                header("Location: lista_de_fornecedor.php");
                die; 
        } 
            catch (PDOException $error) 
            {
               throw new Exception("Error no metodo (update_forneceController): " . $error->getMessage());
            }
    }

    public static function remover_fornecedor($id)
    {
        try
        {

            $remover = Fornecedor::remover_idFornercedor($id); 
    
            if($remover) 
            {
                http_response_code(204);//Recurso alterado com sucesso.
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

    public static function fornecedores($fornecedor)
    {
        try 
        {

             $data = Fornecedor::fornecedor_get($fornecedor); 
            
            if($data) 
            {
                http_response_code(200);//requisição foi processada com sucesso
                return $data; 
            }

        } 
            catch (PDOException $error) 
            {
                throw new Exception("Error:".$error->getMessage());
            }
    }

    
}