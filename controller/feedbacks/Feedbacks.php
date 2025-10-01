<?php declare(strict_types=1); 

namespace controller;

class Feedbacks
{
   public static function feedback_login(): void 
   {
        
        if(isset($_SESSION['fields_empty']))
         {
            echo "<div class='mensagem-empty'>".$_SESSION['fields_empty']."</div>";
            unset($_SESSION['fields_empty']);
         }

         elseif(isset($_SESSION['user_invalido']))
         {
            echo "<div class='mensagem-erro'>".$_SESSION['user_invalido']."</div>";
            unset($_SESSION['user_invalido']); 
         }

         elseif(isset($_SESSION['autenticado']))
         {
            echo "<div class='mensagem-sucesso'>".$_SESSION['autenticado']."</div>";
            unset($_SESSION['autenticado']);
         }

   }

   public static function feedback_inserir(): void 
   {
        if(isset($_SESSION['inserido']))
         {
            echo "<div class='mensagem-sucesso'>".$_SESSION['inserido']."</div>";
            unset($_SESSION['inserido']);
         }

         elseif(isset($_SESSION['existe']))
         {
            echo "<div class='mensagem-erro'>".$_SESSION['existe']."</div>";
            unset($_SESSION['existe']);
         }

         elseif(isset($_SESSION['inserir_error']))
         {
            echo "<div class='mensagem-erro'>".$_SESSION['inserir_error']."</div>";
            unset($_SESSION['inserir_error']);
         }
   }

   public static function feedback_index(): void 
   {
        if(isset($_SESSION['Encontrado']))
        {
            echo "<div class='Encontrado'>".$_SESSION['Encontrado']."</div>";
            unset($_SESSION['Encontrado']);
         }
   }

   public static function feedback_remover(): void 
   {
        if(isset($_SESSION['remover']))
        {
            echo "<div class='mensagem-erro'>".$_SESSION['remover']."</div>";
            unset($_SESSION['remover']);
         }
   }

   public static function feedback_atualizar(): void 
   {
        if(isset($_SESSION['update_true']))
        {
            echo "<div class='mensagem-sucesso'>".$_SESSION['update_true']."</div>";
            unset($_SESSION['update_true']);
         }

        elseif(isset($_SESSION['update_false']))
        {
            echo "<div class='mensagem-erro'>".$_SESSION['update_false']."</div>";
            unset($_SESSION['update_false']);
         }
         
   }

   public static function feedback_details(): void 
   {
     if(isset($_SESSION['existe']))
         {
            echo "<div class='mensagem-erro'>".$_SESSION['existe']."</div>";
            unset($_SESSION['existe']);
         }
   }

   public static function feedback_validation_inserir():void  
   {
         if(isset($_SESSION['fields_empty']))
         {
            echo "<div class='mensagem-empty-adicionar'>".$_SESSION['fields_empty']."</div>";
            unset($_SESSION['fields_empty']);
         }
   }
   public static function feedback_validation_form_limit():void  
   {
         if(isset($_SESSION['fields_cpf_limit']))
         {
            echo "<div class='mensagem-erro'>".$_SESSION['fields_cpf_limit']."</div>";
            unset($_SESSION['fields_cpf_limit']);
         }

          if(isset($_SESSION['fields_telefone_limit']))
         {
            echo "<div class='mensagem-erro'>".$_SESSION['fields_telefone_limit']."</div>";
            unset($_SESSION['fields_telefone_limit']);
         }
   }
  
   public static function feedback_alerta_de_estoque():void 
   {
         if(isset($_SESSION['estoque_alert']))
         {
            foreach($_SESSION['estoque_alert'] as $sessao_new)
            {
               echo "<div>".$sessao_new."</div>";
               unset($_SESSION['estoque_alert']);
            }
         }

         elseif(isset($_SESSION['estoque_not_alert']))
         {
            echo "<div class='mensagem-estoque-not-alert'>".$_SESSION['estoque_not_alert']."</div>";
            unset($_SESSION['estoque_not_alert']);
         }

         elseif(isset($_SESSION['estoque_error']))
         {
            echo "<div class='mensagem-estoque-alert'>".$_SESSION['estoque_error']."</div>";
            unset($_SESSION['estoque_error']);
         }
   }

   public static function limpa_fornec():void 
   {
         if(isset($_SESSION['limpa']))
         {
            echo "<div class='mensagem-erro'>".$_SESSION['limpa']."</div>";
            unset($_SESSION['limpa']);
         }
   }

   public static function fornecedor_inserir():void 
   {
         if(isset($_SESSION['forne']))
         {
            echo "<div class='mensagem-sucesso'>".$_SESSION['forne']."</div>";
            unset($_SESSION['forne']);
         }

         if(isset($_SESSION['forne_error']))
         {
            echo "<div class='mensagem-erro'>".$_SESSION['forne_error']."</div>";
            unset($_SESSION['forne_error']);
         }
   }

   public static function fornecedor_inserir_verify():void 
   {
         if(isset($_SESSION['forne_inserir']))
         {
            echo "<div class='mensagem-erro'>".$_SESSION['forne_inserir']."</div>";
            unset($_SESSION['forne_inserir']);
         }

         if(isset($_SESSION['forne_cpf']))
         {
            echo "<div class='mensagem-erro'>".$_SESSION['forne_cpf']."</div>";
            unset($_SESSION['forne_cpf']);
         }
   }

   public static function fornecedor_list():void 
   {
         if(isset($_SESSION['list_fornec']))
         {
            echo "<div class='mensagem-erro'>".$_SESSION['list_fornec']."</div>";
            unset($_SESSION['list_fornec']);
         }

   }


}