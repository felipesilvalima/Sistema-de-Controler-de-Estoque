<?php declare(strict_types=1); 

namespace model;

use Exception;
use PDO;
use PDOException;

require_once __DIR__.'/../conexao/DB.php';

class Fornecedor extends DB
{
    protected static function register_fornec($fornecedor,$cpf,$tel,$endereco)
    {
        try 
        {
           $sql = "INSERT INTO fornecedor (fornecedor, cpf, telefone, endereco) VALUES (:fornecedor, :cpf, :telefone, :endereco)";
           $stm = DB::connect()->prepare($sql);
           $stm->bindParam(':fornecedor',$fornecedor,PDO::PARAM_STR);
           $stm->bindParam(':cpf',$cpf,PDO::PARAM_INT);
           $stm->bindParam(':telefone',$tel,PDO::PARAM_INT);
           $stm->bindParam(':endereco',$endereco,PDO::PARAM_STR);
           $stm->execute();

            if($stm)
            {
                return true;
            }
                else
                {
                    return false;
                }
            
        } 
            catch (PDOException $error) 
            {
                throw new Exception("Error no metodo (register_fornec): ".$error->getMessage());
            }
    }

    protected static function verify_fornecedor($fornecedor)
    {
        try 
        {
           $sql = "SELECT fornecedor FROM fornecedor WHERE fornecedor = :fornecedor";
           $stm = DB::connect()->prepare($sql);
           $stm->bindParam(':fornecedor',$fornecedor,PDO::PARAM_STR);
           $stm->execute();
           
            if($stm && $stm->rowCount() > 0)
            {
                return true;
            }
                else
                {
                    return false;
                }

        } 
            catch (PDOException $error) 
            {
                throw new Exception("Error no metodo (verify_forneceodr): ".$error->getMessage());
            }
    }

    protected static function verify_cpf($cpf)
    {
        try 
        {
           $sql = "SELECT cpf FROM fornecedor WHERE cpf = :cpf";
           $stm = DB::connect()->prepare($sql);
           $stm->bindParam(':cpf',$cpf,PDO::PARAM_INT);
           $stm->execute();

            if($stm && $stm->rowCount() > 0)
            {    
                return true;
            }

        } 
            catch (PDOException $error) 
            {
                throw new Exception("Error no metodo (verify_forneceodr): ".$error->getMessage());
            }
    }

    protected static function list_fornec()
    {
        try 
        {
           $sql = "SELECT * FROM fornecedor ORDER BY id";
           $stm = DB::connect()->prepare($sql);
           $stm->execute();

            if($stm && $stm->rowCount() > 0)
            {
               $datas = $stm->fetchAll(PDO::FETCH_OBJ);
                return $datas;
            }
                else
                {
                    return false;
                }

        } 
            catch (PDOException $error) 
            {
                throw new Exception("Error no metodo (verify_forneceodr): ".$error->getMessage());
            }
    }

    protected static function get_fornec($id)
    {
        try 
        {
           $sql = "SELECT * FROM fornecedor WHERE id = :id";
           $stm = DB::connect()->prepare($sql);
           $stm->bindParam(':id',$id, PDO::PARAM_INT);
           $stm->execute();

            if($stm && $stm->rowCount() > 0)
            {
               $datas = $stm->fetch(PDO::FETCH_OBJ);
                return $datas;
            }
                else
                {
                    return false;
                }

        } 
            catch (PDOException $error) 
            {
                throw new Exception("Error no metodo (verify_forneceodr): ".$error->getMessage());
            }
    }

    protected static function update_fornecedor($id,$fornecedor,$cpf,$telefone,$edereco)
    {
        try 
        {
           $sql = "UPDATE fornecedor SET fornecedor =:fornecedor, cpf = :cpf, telefone = :telefone, endereco = :endereco WHERE id = :id";
           $stm = DB::connect()->prepare($sql);
           $stm->bindParam(':id',$id, PDO::PARAM_INT);
           $stm->bindParam(':fornecedor',$fornecedor, PDO::PARAM_STR);
           $stm->bindParam(':cpf',$cpf, PDO::PARAM_INT);
           $stm->bindParam(':telefone',$telefone, PDO::PARAM_INT);
           $stm->bindParam(':endereco',$edereco, PDO::PARAM_STR);
           $stm->execute();

            if($stm)
            {
                return true;
            }
                else
                {
                    return false;
                }

        } 
            catch (PDOException $error) 
            {
                throw new Exception("Error no metodo (verify_forneceodr): ".$error->getMessage());
            }
    }

     protected static function remover_idFornercedor($id)
    {
     try 
     {
        $sql = "DELETE FROM fornecedor WHERE id = :id";
        $stm = DB::connect()->prepare($sql);
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        
        if($stm)
        {
            return true;
        }
            else
            {
                throw new Exception("Error: na remoção do produto no metodo (remover_idFornercedor) ");
            }

     }
      catch (PDOException $error) 
      {
         throw new Exception("Error:". $error->getMessage());
      } 
    }

    protected static function fornecedor_get($fornecedor)
    {

     try 
     {
        $sql = "SELECT id,fornecedor FROM fornecedor WHERE fornecedor != :fornecedor";
        $stm = DB::connect()->prepare($sql);
        $stm->bindParam(':fornecedor', $fornecedor, PDO::PARAM_STR);
        $stm->execute();
        
        $data = $stm->fetchAll(PDO::FETCH_OBJ);

        if(!empty($data))
        {
            return $data;
        }
            else
            {
                throw new Exception("Error: na consultar no metodo (fornecedor_get) ");
            }

     }
      catch (PDOException $error) 
      {
         throw new Exception("Error:". $error->getMessage());
      } 
    }

}