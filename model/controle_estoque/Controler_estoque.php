<?php declare(strict_types=1); 

namespace model;

use Exception;
use PDO;
use PDOException;

require_once __DIR__.'/../conexao/DB.php';

class Controler_estoque extends DB
{
    
    // Retorna todas as quantidades máximas e mínimas dos produtos
    public static function get_quant_min_max()
    {
        try 
        {
            $sql = "SELECT quantidade_max, quantidade_min, produto FROM produtos ORDER BY id";
            $stm = DB::connect()->prepare($sql);
            $stm->execute();

            $datas = $stm->fetchAll(PDO::FETCH_OBJ);

            return !empty($datas) ? $datas : null;
        } 
        catch (PDOException $error) 
        {
            throw new Exception("Erro no método get_quant_min_max: ".$error->getMessage());
        }
    }

    // Atualiza dados de estoque de um produto
    public static function update_date_estoque($id, $produto, $preco, $quant_max, $quant_min, $descricao, $unidade_medida, $categoria_id, $fornecedor_id)
    {
        try 
        {
            $sql = "UPDATE produtos 
                    SET produto = :produto, preco = :preco, quantidade_max = :quant_max, quantidade_min = :quant_min, 
                        descricao = :descricao, unidade_medida = :unidade_medida, categoria_id = :categoria_id, fornecedor_id = :fornecedor_id 
                    WHERE id = :id";
            
            $stm = DB::connect()->prepare($sql);
            $stm->bindParam(':id', $id, PDO::PARAM_INT);
            $stm->bindParam(':produto', $produto, PDO::PARAM_STR);
            $stm->bindParam(':preco', $preco, PDO::PARAM_STR);
            $stm->bindParam(':quant_max', $quant_max, PDO::PARAM_INT);
            $stm->bindParam(':quant_min', $quant_min, PDO::PARAM_INT);
            $stm->bindParam(':descricao', $descricao, PDO::PARAM_STR);
            $stm->bindParam(':unidade_medida', $unidade_medida, PDO::PARAM_STR);
            $stm->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);
            $stm->bindParam(':fornecedor_id', $fornecedor_id, PDO::PARAM_INT);

            $stm->execute();

            if ($stm) return true;

            throw new Exception("Erro na atualização do produto no método update_date_estoque.");
        } 
        catch (PDOException $error) 
        {
            throw new Exception("Erro no método update_date_estoque: ".$error->getMessage());
        }
    }
}