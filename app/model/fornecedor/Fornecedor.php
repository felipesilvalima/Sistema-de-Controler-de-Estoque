<?php declare(strict_types=1); 

namespace model;

use Exception;
use PDO;
use PDOException;

require_once __DIR__.'/../conexao/DB.php';

class Fornecedor extends DB
{
   // Inserir um novo fornecedor
    public static function register_fornec($fornecedor, $cpf, $tel, $endereco)
    {
        try 
        {
            $sql = "INSERT INTO fornecedor (fornecedor, cpf, telefone, endereco) VALUES (:fornecedor, :cpf, :telefone, :endereco)";
            $stm = DB::connect()->prepare($sql);
            $stm->bindParam(':fornecedor', $fornecedor, PDO::PARAM_STR);
            $stm->bindParam(':cpf', $cpf, PDO::PARAM_INT);
            $stm->bindParam(':telefone', $tel, PDO::PARAM_INT);
            $stm->bindParam(':endereco', $endereco, PDO::PARAM_STR);
            $stm->execute();

            return $stm ? true : false;
        } 
        catch (PDOException $error) 
        {
            throw new Exception("Erro no método register_fornec: ".$error->getMessage());
        }
    }

    // Verifica se o fornecedor já existe pelo nome
    public static function verify_fornecedor($fornecedor)
    {
        try 
        {
            $sql = "SELECT fornecedor FROM fornecedor WHERE fornecedor = :fornecedor";
            $stm = DB::connect()->prepare($sql);
            $stm->bindParam(':fornecedor', $fornecedor, PDO::PARAM_STR);
            $stm->execute();

            return ($stm && $stm->rowCount() > 0);
        } 
        catch (PDOException $error) 
        {
            throw new Exception("Erro no método verify_fornecedor: ".$error->getMessage());
        }
    }

    // Verifica se o CPF já está cadastrado
    public static function verify_cpf($cpf)
    {
        try 
        {
            $sql = "SELECT cpf FROM fornecedor WHERE cpf = :cpf";
            $stm = DB::connect()->prepare($sql);
            $stm->bindParam(':cpf', $cpf, PDO::PARAM_STR);
            $stm->execute();

            return ($stm && $stm->rowCount() > 0);
        } 
        catch (PDOException $error) 
        {
            throw new Exception("Erro no método verify_cpf: ".$error->getMessage());
        }
    }

    // Listar todos os fornecedores
    public static function list_fornec()
    {
        try 
        {
            $sql = "SELECT * FROM fornecedor ORDER BY id";
            $stm = DB::connect()->prepare($sql);
            $stm->execute();

            return ($stm && $stm->rowCount() > 0) ? $stm->fetchAll(PDO::FETCH_OBJ) : false;
        } 
        catch (PDOException $error) 
        {
            throw new Exception("Erro no método list_fornec: ".$error->getMessage());
        }
    }

    // Obter um fornecedor pelo ID
    public static function get_fornec($id)
    {
        try 
        {
            $sql = "SELECT * FROM fornecedor WHERE id = :id";
            $stm = DB::connect()->prepare($sql);
            $stm->bindParam(':id', $id, PDO::PARAM_INT);
            $stm->execute();

            return ($stm && $stm->rowCount() > 0) ? $stm->fetch(PDO::FETCH_OBJ) : false;
        } 
        catch (PDOException $error) 
        {
            throw new Exception("Erro no método get_fornec: ".$error->getMessage());
        }
    }

    // Atualiza os dados de um fornecedor
    public static function update_fornecedor($id, $fornecedor, $cpf, $telefone, $endereco)
    {
        try 
        {
            $sql = "UPDATE fornecedor SET fornecedor = :fornecedor, cpf = :cpf, telefone = :telefone, endereco = :endereco WHERE id = :id";
            $stm = DB::connect()->prepare($sql);
            $stm->bindParam(':id', $id, PDO::PARAM_INT);
            $stm->bindParam(':fornecedor', $fornecedor, PDO::PARAM_STR);
            $stm->bindParam(':cpf', $cpf, PDO::PARAM_INT);
            $stm->bindParam(':telefone', $telefone, PDO::PARAM_INT);
            $stm->bindParam(':endereco', $endereco, PDO::PARAM_STR);
            $stm->execute();

            return $stm ? true : false;
        } 
        catch (PDOException $error) 
        {
            throw new Exception("Erro no método update_fornecedor: ".$error->getMessage());
        }
    }

    // Remover um fornecedor pelo ID
    public static function remover_idFornercedor($id)
    {
        try 
        {
            $sql = "DELETE FROM fornecedor WHERE id = :id";
            $stm = DB::connect()->prepare($sql);
            $stm->bindParam(':id', $id, PDO::PARAM_INT);
            $stm->execute();

            return $stm ? true : throw new Exception("Erro na remoção no método remover_idFornercedor");
        } 
        catch (PDOException $error) 
        {
            throw new Exception("Erro no método remover_idFornercedor: ".$error->getMessage());
        }
    }

    // Retorna todos os fornecedores exceto o passado como parâmetro
    public static function fornecedor_get($fornecedor)
    {
        try 
        {
            $sql = "SELECT id, fornecedor FROM fornecedor WHERE fornecedor != :fornecedor";
            $stm = DB::connect()->prepare($sql);
            $stm->bindParam(':fornecedor', $fornecedor, PDO::PARAM_STR);
            $stm->execute();

            $data = $stm->fetchAll(PDO::FETCH_OBJ);
            if(!empty($data)) return $data;

            throw new Exception("Erro ao consultar fornecedor no método fornecedor_get");
        } 
        catch (PDOException $error) 
        {
            throw new Exception("Erro no método fornecedor_get: ".$error->getMessage());
        }
    }

}