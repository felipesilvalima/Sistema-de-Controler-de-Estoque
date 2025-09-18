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
            $data = Categoria::categoria_get($categoria); 
            
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