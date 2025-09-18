<?php declare(strict_types=1); 

namespace model;

require_once __DIR__.'/../conexao/DB.php';

use Exception;
use PDO;
use PDOException;

class Produto extends DB
{
    protected static function get_date($seach)
    {
        try
        {
            $sql = "SELECT * FROM produtos WHERE produto LIKE :search ORDER BY id";
            $stm = DB::connect()->prepare($sql);
            $stm->bindValue(':search', '%'.$seach.'%', PDO::PARAM_STR);
            $stm->execute();

            $dates = $stm->fetchAll(PDO::FETCH_OBJ);
            $datas_total = $stm->rowCount();

            if($datas_total > 0)
            {
                return $dates;
            }
                else
                {
                    return null;
                }
               
        }
            catch(PDOException $error)
            {
                throw new Exception("Error:". $error->getMessage());
            }
    }


    protected static function get_id($id)
    {
        try
        {
            $sql = "SELECT produtos.id,produtos.produto,produtos.descricao,produtos.preco,produtos.quantidade_max,produtos.quantidade_min,produtos.unidade_medida,produtos.categoria_id,produtos.fornecedor_id,produtos.usuario_id, categoria.categoria,fornecedor.fornecedor
             FROM produtos INNER JOIN categoria ON produtos.categoria_id = categoria.id INNER JOIN fornecedor ON produtos.fornecedor_id = fornecedor.id WHERE produtos.id = :id";
            $stm = DB::connect()->prepare($sql);
            $stm->bindParam(':id', $id, PDO::PARAM_STR);
            $stm->execute();
            
            $line = $stm->fetch(PDO::FETCH_OBJ);
            $line_total = $stm->rowCount();
            
            if($line_total > 0)
            {
                return $line;
            }
                else
                {
                    return null;
                }

        }
            catch(PDOException $error)
            {
                throw new Exception("Error:". $error->getMessage());
            }
    }

    protected static function update_date($id,$produto,$preco,$quantidade,$quantidade_min,$descricao,$unidade_medida, $categoria,$fornecedor)
    {
        try 
        {

            $sql = "UPDATE produtos SET produto=:produto, preco=:preco, quantidade_max = :quantidade, quantidade_min=:quantidade_min, descricao=:descricao, unidade_medida=:unidade_medida, categoria_id=:categoria_id, fornecedor_id=:fornecedor_id WHERE id = :id";
            $stm = DB::connect()->prepare($sql);
            $stm->bindParam(':id',$id, PDO::PARAM_INT);
            $stm->bindParam(':produto',$produto, PDO::PARAM_STR);
            $stm->bindParam(':preco',$preco, PDO::PARAM_STR);
            $stm->bindParam(':quantidade',$quantidade, PDO::PARAM_INT);
            $stm->bindParam(':quantidade_min',$quantidade_min, PDO::PARAM_INT);
            $stm->bindParam(':descricao',$descricao, PDO::PARAM_STR);
            $stm->bindParam(':unidade_medida',$unidade_medida, PDO::PARAM_STR);
            $stm->bindParam(':categoria_id',$categoria, PDO::PARAM_INT);
            $stm->bindParam(':fornecedor_id',$fornecedor, PDO::PARAM_INT);
            $stm->execute();
             
            if($stm)
            {
                return true;
            }
                else
                {
                    throw new Exception("Error: na Atualização do produto no metodo (update_date) ");
                }

        } 
            catch (PDOException $error) 
            {
                throw new Exception("error:".$error->getMessage());
            }
    }

    protected static function inserir_produto($produto_name, $preco_pd, $quant_pd,$quantidade_min,$descricao,$unidade_medida,$categoria,$fornecedor,$user)
    {
        try 
        {
        
            $sql = "INSERT INTO produtos (produto, preco, quantidade_max, quantidade_min, descricao, unidade_medida, categoria_id, fornecedor_id, usuario_id) VALUES(:pd, :pc, :qt, :qt_min, :descr, :um, :ct, :fc, :user)";
            $stm = DB::connect()->prepare($sql);
            $stm->bindParam(':pd', $produto_name, PDO::PARAM_STR);
            $stm->bindParam(':pc', $preco_pd, PDO::PARAM_STR);
            $stm->bindParam(':qt', $quant_pd, PDO::PARAM_INT);
            $stm->bindParam(':qt_min', $quantidade_min, PDO::PARAM_INT);
            $stm->bindParam(':descr', $descricao, PDO::PARAM_STR);
            $stm->bindParam(':um', $unidade_medida, PDO::PARAM_STR);
            $stm->bindParam(':ct', $categoria, PDO::PARAM_INT);
            $stm->bindParam(':fc', $fornecedor, PDO::PARAM_INT);
            $stm->bindParam(':user', $user, PDO::PARAM_INT);
            $stm->execute();
    
            if($stm)
            {
                return true;
            }
                else
                {
                    throw new Exception("Error: na inserção do produto no metodo (inserir_produto) ");
                }

        }
         catch (PDOException $error) 
         {
           throw new Exception("Error:".$error->getMessage());
         }

    }

    protected static function verificarProduto($produto_name)
    {
        try 
        {
            $sql = "SELECT produto FROM produtos WHERE produto = :prod_name";
            $stm = DB::connect()->prepare($sql);
            $stm->bindParam(':prod_name', $produto_name, PDO::PARAM_STR);
            $stm->execute();

            if($stm->rowCount() > 0)
            {
                return  true;
            }
                else
                {
                    return false;
                }
        }
        
         catch (PDOException $error) 
         {
           throw new Exception("Error:".$error->getMessage());
         }
    }

    protected static function remover($id)
    {
     try 
     {
        $sql = "DELETE FROM produtos WHERE id = :id";
        $stm = DB::connect()->prepare($sql);
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        
        if($stm)
        {
            return true;
        }
            else
            {
                throw new Exception("Error: na remoção do produto no metodo (remover) ");
            }

     }
      catch (PDOException $error) 
      {
         throw new Exception("Error:". $error->getMessage());
      } 
    }

    protected static function last_product()
    {

     try 
     {
        $sql = "SELECT id FROM produtos ORDER BY id DESC";
        $stm = DB::connect()->prepare($sql);
        $stm->execute();
        
        $data = $stm->fetch(PDO::FETCH_OBJ);

        if(!empty($data))
        {
            return $data;
        }
            else
            {
                throw new Exception("Error: na consultar no metodo (last_product) ");
            }

     }
      catch (PDOException $error) 
      {
         throw new Exception("Error:". $error->getMessage());
      } 
    }

}