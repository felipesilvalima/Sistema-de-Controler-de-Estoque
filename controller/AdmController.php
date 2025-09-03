<?php declare(strict_types=1); 

namespace controller;

use Exception;
use model\AdmModel;
use PDOException;

require_once __DIR__.'/../model/AdmModel.php';

class AdmController
{
     public static function index($search)
    {
        try 
        {
          $datas =  AdmModel::get_date_user($search); 
            
          if(!empty($datas))  
          {
            http_response_code(200);
             return $datas; 
          }

            else 
            {
                http_response_code(404);
                ProdutoController::feedback_systm('Encontrado',"Produto não encontrado!"); 
                return false; 
            }

        } 
            catch (PDOException $error) 
            {
                throw new Exception("Error:".$error->getMessage());
            }
    }

     public static function movimentacao($search)
    {
        try 
        {
          $datas =  AdmModel::get_date_movimentacao($search); 
            
          if(!empty($datas))  
          {
            http_response_code(200);
             return $datas; 
          }

            else 
            {
                http_response_code(404);
                ProdutoController::feedback_systm('Encontrado',"Produto não encontrado!"); 
                return false; 
            }

        } 
            catch (PDOException $error) 
            {
                throw new Exception("Error:".$error->getMessage());
            }
    }
}