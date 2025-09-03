<?php declare(strict_types=1); 

namespace model;

require_once __DIR__.'/./DB.php';

use Exception;
use PDO;
use PDOException;

class Produto
{
    public static function get_date($seach)
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


    public static function get_id($id)
    {
        try
        {
            $sql = "SELECT * FROM produtos JOIN categoria,fornecedor WHERE produtos.id = :id AND categoria.id = produtos.categoria_id AND produtos.fornecedor_id = fornecedor.id";
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

    public static function update_date($id,$pd,$pc,$qt,$qt_min,$des,$um,$cat,$for)
    {
        try 
        {

            $sql = "UPDATE produtos SET produto=:pd, preco=:pc, quantidade_max=:qt, quantidade_min=:qt_min, descricao=:desc, unidade_medida=:um, categoria_id=:cat, fornecedor_id=:forn WHERE id = :id";
            $stm = DB::connect()->prepare($sql);
            $stm->bindParam(':id',$id, PDO::PARAM_INT);
            $stm->bindParam(':pd',$pd, PDO::PARAM_STR);
            $stm->bindParam(':pc',$pc, PDO::PARAM_STR);
            $stm->bindParam(':qt',$qt, PDO::PARAM_INT);
            $stm->bindParam(':desc',$des, PDO::PARAM_STR);
            $stm->bindParam(':um',$um, PDO::PARAM_STR);
            $stm->bindParam(':cat',$cat, PDO::PARAM_INT);
            $stm->bindParam(':forn',$for, PDO::PARAM_INT);
            $stm->bindParam(':qt_min',$qt_min, PDO::PARAM_INT);
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

    public static function inserir_produto($produto_name, $preco_pd, $quant_pd,$quantidade_min,$descrição,$unidade_medida,$categoria,$fornecedor,$user)
    {
        try 
        {
        
            $sql = "INSERT INTO produtos (produto, preco, quantidade_max, quantidade_min, descricao, unidade_medida, categoria_id, fornecedor_id, usuario_id) VALUES(:pd, :pc, :qt, :qt_min, :descr, :um, :ct, :fc, :user)";
            $stm = DB::connect()->prepare($sql);
            $stm->bindParam(':pd', $produto_name, PDO::PARAM_STR);
            $stm->bindParam(':pc', $preco_pd, PDO::PARAM_STR);
            $stm->bindParam(':qt', $quant_pd, PDO::PARAM_INT);
            $stm->bindParam(':qt_min', $quantidade_min, PDO::PARAM_INT);
            $stm->bindParam(':descr', $descrição, PDO::PARAM_STR);
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

    public static function verificarProduto($produto_name)
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

    public static function remover($id)
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

    public static function categoria_get()
    {
     try 
     {
        $sql = "SELECT id,categoria FROM categoria";
        $stm = DB::connect()->prepare($sql);
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

    public static function fornecedor_get()
    {
     try 
     {
        $sql = "SELECT id,fornecedor FROM fornecedor";
        $stm = DB::connect()->prepare($sql);
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