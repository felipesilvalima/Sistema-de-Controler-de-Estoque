<?php declare(strict_types=1); 

namespace controller;

use Exception;
use model\Categoria as Categoria;
use PDOException;

require_once __DIR__.'/../../model/categoria/Categoria.php';
class CategoriaController extends Categoria
{
   
    public static function categorias($categoria)
    {
        try 
        {  
            $data = Categoria::categoria_list($categoria);

            if(empty($data))
            {
                http_response_code(404);//O recurso solicitado não existe
                ProdutoController::feedback_systm('existe',"Categorias não encontrado!"); 
                header("Location: lista_de_categoria.php");
                die;
            }  
                else
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

    public static function categoria_relatorio($id)
    {
        try 
        {  
            $data = Categoria::categoria_get($id);
            
            if(!isset($id) || empty($data->id))
            {
                http_response_code(404);//O recurso solicitado não existe
                ProdutoController::feedback_systm('existe',"Categoria não encontrado!"); 
                header("Location: lista_de_categoria.php");
                die;
            }
                else
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