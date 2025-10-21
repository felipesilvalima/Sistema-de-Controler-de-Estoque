<?php declare(strict_types=1); 

namespace model;

use Exception;
use PDO;
use PDOException;

require_once __DIR__.'/../conexao/DB.php';
class Categoria extends DB
{
    // Retorna todas as categorias, exceto a informada
    public static function categoria_list(int $categoria): array
    {
        try 
        {
            $sql = "SELECT id, categoria, descricao FROM categoria WHERE id != :categoria";
            $stm = DB::connect()->prepare($sql);
            $stm->bindValue(':categoria', $categoria, PDO::PARAM_INT);
            $stm->execute();

            $data = $stm->fetchAll(PDO::FETCH_OBJ);

            if (!empty($data)) {
                return $data;
            }

            throw new Exception("Nenhuma categoria encontrada no método categoria_list.");
        } 
        catch (PDOException $error) 
        {
            throw new Exception("Erro no método categoria_list: " . $error->getMessage());
        }
    }

    // Retorna uma categoria específica pelo ID
    public static function categoria_get(int $id): object
    {
        try 
        {
            $sql = "SELECT id, categoria, descricao FROM categoria WHERE id = :id";
            $stm = DB::connect()->prepare($sql);
            $stm->bindValue(':id', $id, PDO::PARAM_INT);
            $stm->execute();

            $data = $stm->fetch(PDO::FETCH_OBJ);

            if (!empty($data)) {
                return $data;
            }

            throw new Exception("Categoria não encontrada no método categoria_get.");
        } 
        catch (PDOException $error) 
        {
            throw new Exception("Erro no método categoria_get: " . $error->getMessage());
        }
    }
}