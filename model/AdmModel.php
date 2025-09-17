<?php declare(strict_types=1); 

namespace model;

use Exception;
use PDO;
use PDOException;

require_once __DIR__.'/DB.php';

class AdmModel extends DB
{
   public static function get_date_user($seach)
    {
        try
        {
            $sql = "SELECT * FROM user WHERE name LIKE :search ORDER BY id";
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

   public static function get_date_movimentacao($seach)
    {
        try
        {
            $sql = "SELECT * FROM movimentacao_estoque WHERE data LIKE :search ORDER BY id DESC";
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
 
}