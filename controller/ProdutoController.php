<?php declare(strict_types=1); 

namespace controller;

use Exception;
use model\Produto;
require_once __DIR__.'/../model/Produto.php';
require_once __DIR__.'/../controller/MovimentacaoController.php';
use PDOException;

class ProdutoController
{

    public static function index($search)
    {
        try 
        {
          $datas =  Produto::get_date($search); 
            
          if(!empty($datas))  
          {
             http_response_code(200);//requisição foi processada com sucesso
             return $datas; 
          }

            else 
            {
                http_response_code(404);//O recurso solicitado não existe
                ProdutoController::feedback_systm('Encontrado',"Produto não encontrado!"); 
                return false; 
            }

        } 
            catch (PDOException $error) 
            {
                throw new Exception("Error:".$error->getMessage());
            }
    }

    public static function detalhes($id)
    {

        try
        {
            $line = Produto::get_id($id); 

            while(!isset($line->id) || empty($id)) 
            {
                 http_response_code(404);//O recurso solicitado não existe
                ProdutoController::feedback_systm('existe',"Produto não encontrado!"); 
                return false;
            }

              http_response_code(200);//requisição foi processada com sucesso
              return $line; 
        }
            catch(PDOException $error)
            {
                throw new Exception("Error:".$error->getMessage());
            }
        
    }


    public static function Atulaizar($id,$produto,$preco,$quantidade,$quantidade_min,$descricao,$unidade_medida,$categoria,$fornecedor)
    {
        try 
        {
           
            $update = Produto::update_date($id,$produto,$preco, $quantidade, $quantidade_min,$descricao,$unidade_medida,1,1); 

                if($update)
                {
                    http_response_code(204);//Recurso alterado com sucesso.
                    ProdutoController::feedback_systm('update_true',"Atulizado com sucesso");
                    MovimentacaoController::update_product($produto,$quantidade); 
                    return true; 
                }
                
 
        } 
            catch (PDOException $error) 
            {
              throw new Exception("Error:".$error->getMessage());      
            }
    }

    public static function inseir($produto_name, $preco_pd, $quant_pd, $quantidade_min,$descrição,$unidade_medida,$categoria,$fornecedor,$user)
    {

        try 
        {
            $line = Produto::verificarProduto($produto_name);
            
            while($line)  
            {
                ProdutoController::feedback_systm('existe',"Produto já existe!"); 
                return false; 
                http_response_code(409);//O recurso já existe, tentativa de duplicação
            }

            $inserir = Produto::inserir_produto($produto_name, $preco_pd, $quant_pd, $quantidade_min,$descrição,$unidade_medida,$categoria,$fornecedor,$user); 
            
            if($inserir)
            {
                ProdutoController::feedback_systm('inserido',"Inserido com sucesso");
                MovimentacaoController::insercao($produto_name, $quant_pd,$user);
                return true;  
                http_response_code(201);//recurso criado com sucesso
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
             http_response_code(204);//Recurso alterado com sucesso
            ProdutoController::feedback_systm('remover',"Removido com sucesso");
            MovimentacaoController::remocao($id,$produto,$user_id);
            return true; 
        }
    }

    public static function categorias()
    {
        try 
        {  
            $data = Produto::categoria_get(); 
            
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

    public static function fornecedores()
    {
        try 
        {  
            $data = Produto::fornecedor_get(); 
            
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


    public static function feedback_systm(string $name_session, string $messagem): void
    {
         session_start(); 
         $_SESSION[$name_session] =  $messagem; 
    }
}
