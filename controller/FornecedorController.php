<?php declare(strict_types=1); 

namespace controller;

use Exception;
use model\Fornecedor;
use PDOException;

require_once __DIR__.'/../model/Fornecedor.php';
require_once __DIR__.'/../controller/ProdutoController.php';

class FornecedorController
{
    public static function Inserir_fornecedor($fornecedor,$cpf,$tel,$endereco,$user_id)
    {
        try 
        {
            $response = Fornecedor::register_fornec($fornecedor,$cpf,$tel,$endereco);
            
            if($response)
            {
                 http_response_code(201);//recurso inserido com sucesso
                ProdutoController::feedback_systm('forne',"Fornecedor inserido com sucesso");
                return true;
            }
                else
                {
                     http_response_code(500);//erro interno
                    ProdutoController::feedback_systm('forne_error',"Error ao inserir fornecedor");  
                    return false;
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
    
            while($response)
            {
                http_response_code(409);//O recurso já existe, tentativa de duplicação
                ProdutoController::feedback_systm('forne_inserir',"Esse Fornecedor já foi inserido");
                return true;
            }

            return false;
             
        } 
            catch (PDOException $error) 
            {
               throw new Exception("Error no metodo (Inserir_fornecedor): ".$error->getMessage());
            }
    }

    public static function verify_cpfController($cpf)
    {
        try 
        {
            $response = Fornecedor::verify_cpf($cpf);
        
            while($response)
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

            while(!isset($response->id) || empty($id)) 
            {
                http_response_code(404);//O recurso solicitado não existe
                ProdutoController::feedback_systm('existe',"Fornecedor não encontrado!"); 
                return false;
            }
    
            if(!empty($response))
            {
                return $response;
            }
             
        } 
            catch (PDOException $error) 
            {
               throw new Exception("Error no metodo (get_forneceController): ".$error->getMessage());
            }
    }

    public static function update_forneceController($id,$fornecedor,$cpf,$telefone,$edereco)
    {
        try 
        {
            $response = Fornecedor::update_fornecedor($id,$fornecedor,$cpf,$telefone,$edereco);

            if($response)
            {
                http_response_code(204);//Recurso alterado com sucesso
                ProdutoController::feedback_systm('update_true',"Atulizado com sucesso");
                return true;
            }       
        } 
            catch (PDOException $error) 
            {
               throw new Exception("Error no metodo (update_forneceController): ".$error->getMessage());
            }
    }

     public static function remover_fornecedor($id,$fornecedor)
    {
        $remover = Fornecedor::remover_idFornercedor($id); 

        if($remover) 
        {
            http_response_code(204);//Recurso alterado com sucesso.
            ProdutoController::feedback_systm('remover',"Removido com sucesso");
            return true; 
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