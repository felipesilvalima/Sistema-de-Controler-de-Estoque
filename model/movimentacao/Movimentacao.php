<?php declare(strict_types=1); 

namespace model;

use Exception;
use PDO;
use PDOException;

require_once __DIR__.'/../conexao/DB.php';

class Movimentacao extends DB
{
   // Registra uma movimentação no estoque (inserção, remoção, entrada, saída, alteração)
   public static function movimentacao_de_estoque($tipo, $data, $produto_id, $quantidade, $user_id)
   {
       try 
       {
           // Preparando a query de inserção na tabela de movimentação de estoque
           $sql = "INSERT INTO movimentacao_estoque (tipo, data, quantidade, produto_id, usuario_responsavel_id)
                   VALUES(:tipo, :data, :quantidade, :produto, :usuario)";
           $stm = DB::connect()->prepare($sql);
           $stm->bindParam(':tipo', $tipo, PDO::PARAM_STR);               // tipo de movimentação
           $stm->bindParam(':data', $data, PDO::PARAM_STR);               // data da movimentação
           $stm->bindParam(':quantidade', $quantidade, PDO::PARAM_INT);   // quantidade movimentada
           $stm->bindParam(':produto', $produto_id, PDO::PARAM_STR);      // id do produto
           $stm->bindParam(':usuario', $user_id, PDO::PARAM_STR);         // id do usuário responsável
           $stm->execute();
   
           if($stm) // inserção bem-sucedida
           {
               return true;
           }
           else // erro inesperado
           {
               throw new Exception("Error: na inserção de movimentação no método (movimentacao_de_estoque)");
           }
       }
       catch (PDOException $error) // captura erro do banco
       {
           throw new Exception("Error:".$error->getMessage());
       }
   }
   
}