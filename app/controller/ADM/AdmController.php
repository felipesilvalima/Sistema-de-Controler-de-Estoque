<?php declare(strict_types=1); 

namespace controller;

use Exception;
use model\AdmModel as AdmModel;
use PDOException;

require_once __DIR__.'/../../model/ADM/AdmModel.php';
require_once __DIR__.'/../../controller/produto/ProdutoController.php';

class AdmController
{
  // Busca usuários pelo termo de pesquisa
  public static function index($search)
  {
      try 
      {
          $datas = AdmModel::get_date_user($search); // busca usuários no banco
          
          if(!empty($datas)) // encontrou
          {
              http_response_code(200); // sucesso
              return $datas; 
          }
          else // não encontrou
          {
              http_response_code(404); // recurso não encontrado
              ProdutoController::feedback_systm('Encontrado', "Produto não encontrado!"); 
              return false; 
          }
      } 
      catch (PDOException $error) 
      {
          throw new Exception("Error:".$error->getMessage());
      }
  }
  
  // Busca movimentações filtrando pelo termo de pesquisa
  public static function movimentacao($search)
  {
      try 
      {
          $datas = AdmModel::get_date_movimentacao($search); // busca movimentações
          
          if(!empty($datas)) // encontrou
          {
              http_response_code(200); // sucesso
              return $datas; 
          }
          else // não encontrou
          {
              http_response_code(404); // recurso não encontrado
              ProdutoController::feedback_systm('Encontrado', "Produto não encontrado!"); 
              return false; 
          }
      } 
      catch (PDOException $error) 
      {
          throw new Exception("Error:".$error->getMessage());
      }
  }
  
  // Remove todas as movimentações
  public static function movimentacao_remove()
  {
      try 
      {
          $remover = AdmModel::movimentacao_limpa(); // limpa movimentações
          
          if($remover) // sucesso na remoção
          {
              http_response_code(200);
              ProdutoController::feedback_systm('limpa', "Limpeza feita com sucesso");
              return true; 
          }
  
          return false; // nenhuma movimentação para remover
      } 
      catch (PDOException $error) 
      {
          throw new Exception("Error:".$error->getMessage());
      }
  }
  
}