<?php declare(strict_types=1); 

namespace controller;

use Exception;
use model\Categoria;
use PDOException;

require_once __DIR__.'/../model/Categoria.php';
class CategoriaController
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