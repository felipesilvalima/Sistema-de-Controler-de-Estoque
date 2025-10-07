<?php declare(strict_types=1); 

namespace controller;

use Exception;
use model\Categoria as Categoria;
use PDOException;

require_once __DIR__.'/../../model/categoria/Categoria.php';
class CategoriaController
{
   
   // Lista categorias filtrando por nome
   public static function categorias($categoria)
   {
       try 
       {  
           $data = Categoria::categoria_list($categoria); // busca categorias
   
           if(empty($data)) // não encontrou
           {
               http_response_code(404); // recurso não existe
               ProdutoController::feedback_systm('existe', "Categorias não encontrado!"); 
               header("Location: lista_de_categoria.php");
               die;
           }  
           else // encontrou
           {
               http_response_code(200); // sucesso
               return $data; 
           }
   
       } 
       catch (PDOException $error) 
       {
           throw new Exception("Error:".$error->getMessage());
       }
   }
   
   // Busca categoria específica para relatório
   public static function categoria_relatorio($id)
   {
       try 
       {  
           $data = Categoria::categoria_get($id); // pega categoria por id
   
           if(!isset($id) || empty($data->id)) // não existe
           {
               http_response_code(404); // recurso não existe
               ProdutoController::feedback_systm('existe', "Categoria não encontrado!"); 
               header("Location: lista_de_categoria.php");
               die;
           }
           else // encontrado
           {
               http_response_code(200); // sucesso
               return $data; 
           }
   
       } 
       catch (PDOException $error) 
       {
           throw new Exception("Error:".$error->getMessage());
       }
   }
   
}