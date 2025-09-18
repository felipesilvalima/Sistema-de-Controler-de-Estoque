<?php declare(strict_types=1); 

namespace model;

use Exception;
use PDO;
use PDOException;

require_once __DIR__.'/../conexao/DB.php';

class Controler_estoque extends DB
{
    
    protected static function get_quant_min_max()
    {
        try 
        {
            $sql = "SELECT quantidade_max, quantidade_min, produto FROM produtos ORDER BY id";
            $stm = DB::connect()->prepare($sql);
            $stm->execute();

            $datas = $stm->fetchAll(PDO::FETCH_OBJ);
            
            if(!empty($datas))
            {
                return $datas;
            }
                else
                {
                    return null;
                }
            
        } 
            catch (PDOException $error) 
            {
                throw new Exception("Error:".$error->getMessage());
            }
    }


     protected static function update_date_estoque($id,$pd,$pc,$qt,$qt_min,$des,$um,$cat,$for)
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
}