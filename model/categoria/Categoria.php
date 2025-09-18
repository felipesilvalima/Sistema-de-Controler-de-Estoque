<?php declare(strict_types=1); 

namespace model;

use Exception;
use PDO;
use PDOException;

require_once __DIR__.'/../conexao/DB.php';
class Categoria extends DB
{
    protected static function categoria_get($categoria)
    {

     try 
     {
        $sql = "SELECT id,categoria FROM categoria WHERE id != :categoria";
        $stm = DB::connect()->prepare($sql);
        $stm->bindValue(':categoria',$categoria, PDO::PARAM_INT);
        $stm->execute();
        
        $data = $stm->fetchAll(PDO::FETCH_OBJ);

        if(!empty($data))
        {
            return $data;
        }
            else
            {
                throw new Exception("Error: na consultar no metodo (categoria_get) ");
            }

     }
      catch (PDOException $error) 
      {
         throw new Exception("Error:". $error->getMessage());
      } 
    }
}