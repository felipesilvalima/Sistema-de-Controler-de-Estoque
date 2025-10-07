<?php declare(strict_types=1); 

namespace model;

use Exception;
use PDO;
use PDOException;

require_once __DIR__.'/../conexao/DB.php';

class AdmModel extends DB
{
    public static function get_date_user(string $search): ?array
    {
        try {
            $sql = "SELECT * FROM user WHERE name LIKE :search ORDER BY id";
            $stm = DB::connect()->prepare($sql);
            $stm->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
            $stm->execute();

            $dates = $stm->fetchAll(PDO::FETCH_OBJ);
            return !empty($dates) ? $dates : null;

        } catch (PDOException $error) {
            throw new Exception("Erro no método get_date_user: " . $error->getMessage());
        }
    }

    // Busca movimentações de estoque por data
    public static function get_date_movimentacao(string $search): ?array
    {
        try {
            $sql = "SELECT * FROM movimentacao_estoque WHERE data LIKE :search ORDER BY id DESC";
            $stm = DB::connect()->prepare($sql);
            $stm->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
            $stm->execute();

            $dates = $stm->fetchAll(PDO::FETCH_OBJ);
            return !empty($dates) ? $dates : null;

        } catch (PDOException $error) {
            throw new Exception("Erro no método get_date_movimentacao: " . $error->getMessage());
        }
    }

    // Limpa todas as movimentações de estoque
    public static function movimentacao_limpa(): bool
    {
        try {
            $sql = "DELETE FROM movimentacao_estoque";
            $stm = DB::connect()->prepare($sql);
            $stm->execute();

            return $stm->rowCount() > 0;

        } catch (PDOException $error) {
            throw new Exception("Erro no método movimentacao_limpa: " . $error->getMessage());
        }
    }
 
}