<?php declare(strict_types=1); 

namespace model;

use Exception;
use PDO;
use PDOException;

require_once __DIR__.'/../conexao/DB.php';

class Movimentacao extends DB
{
    public static function movimentacao_de_estoque($tipo,$data, $produto_id, $quantidade,$user_id)
    {
         try 
        {
        
            $sql = "INSERT INTO movimentacao_estoque (tipo, data, quantidade, produto_id, usuario_responsavel_id) VALUES(:tipo, :data, :quantidade, :produto, :usuario)";
            $stm = DB::connect()->prepare($sql);
            $stm->bindParam(':tipo', $tipo, PDO::PARAM_STR);
            $stm->bindParam(':data', $data, PDO::PARAM_STR);
            $stm->bindParam(':quantidade', $quantidade, PDO::PARAM_INT);
            $stm->bindParam(':produto', $produto_id, PDO::PARAM_STR);
            $stm->bindParam(':usuario', $user_id, PDO::PARAM_STR);
            $stm->execute();
    
            if($stm)
            {
                return true;
            }
                else
                {
                    throw new Exception("Error: na inserção de movimentação no metodo (movimentacao_de_estoque) ");
                }

        }
         catch (PDOException $error) 
         {
           throw new Exception("Error:".$error->getMessage());
         }
    }
}