-- ============================================================================
--  Sistema de Controle de Estoque - Schema do banco de dados
--  Reconstruído por engenharia reversa das queries SQL em app/model/*.
--
--  MySQL 5.7+ / MariaDB 10.2+
--  Uso: mysql -u root -p < database/schema.sql
-- ============================================================================

CREATE DATABASE IF NOT EXISTS `controler_de_estoque`
    DEFAULT CHARACTER SET utf8mb4
    DEFAULT COLLATE utf8mb4_unicode_ci;

USE `controler_de_estoque`;

-- Ordem de drop invertida por causa das foreign keys
DROP TABLE IF EXISTS `movimentacao_estoque`;
DROP TABLE IF EXISTS `produtos`;
DROP TABLE IF EXISTS `fornecedor`;
DROP TABLE IF EXISTS `categoria`;
DROP TABLE IF EXISTS `adm`;
DROP TABLE IF EXISTS `user`;


-- ----------------------------------------------------------------------------
--  user  -  usuários comuns do sistema
--  Fonte: model/login_user/Login.php   -> SELECT * FROM user WHERE email = :email
--         model/ADM/AdmModel.php       -> SELECT * FROM user WHERE name LIKE :search ORDER BY id
--         view/adm/index.php           -> $date->id, $date->name, $date->email, $date->password
-- ----------------------------------------------------------------------------
CREATE TABLE `user` (
    `id`       INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`     VARCHAR(100)  NOT NULL,
    `email`    VARCHAR(150)  NOT NULL,
    `password` VARCHAR(255)  NOT NULL COMMENT 'hash bcrypt gerado por password_hash()',
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_user_email` (`email`),
    KEY `idx_user_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ----------------------------------------------------------------------------
--  adm  -  administradores (login separado, feito por CPF)
--  Fonte: model/login_adm/LoginAdm.php        -> SELECT * FROM adm WHERE cpf = :cpf
--         controller/login_adm/...            -> $line->senha, $line->id
--  Obs.: a coluna da senha aqui chama-se `senha` (em `user` chama-se `password`).
-- ----------------------------------------------------------------------------
CREATE TABLE `adm` (
    `id`    INT UNSIGNED    NOT NULL AUTO_INCREMENT,
    `cpf`   BIGINT UNSIGNED NOT NULL COMMENT '11 dígitos, gravado como número (o form envia input type=number)',
    `senha` VARCHAR(255)    NOT NULL COMMENT 'hash bcrypt gerado por password_hash()',
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_adm_cpf` (`cpf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ----------------------------------------------------------------------------
--  categoria
--  Fonte: model/categoria/Categoria.php -> SELECT id, categoria, descricao FROM categoria
-- ----------------------------------------------------------------------------
CREATE TABLE `categoria` (
    `id`        INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `categoria` VARCHAR(100) NOT NULL,
    `descricao` TEXT         NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_categoria_nome` (`categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ----------------------------------------------------------------------------
--  fornecedor
--  Fonte: model/fornecedor/Fornecedor.php
--         INSERT INTO fornecedor (fornecedor, cpf, telefone, endereco)
--  Regras: validation/fornecedor/ValidationFornecedor.php exige cpf e telefone
--          com exatamente 11 dígitos; verify_fornecedor/verify_cpf impedem
--          duplicidade de nome e de CPF (daí os índices UNIQUE).
-- ----------------------------------------------------------------------------
CREATE TABLE `fornecedor` (
    `id`         INT UNSIGNED    NOT NULL AUTO_INCREMENT,
    `fornecedor` VARCHAR(150)    NOT NULL,
    `cpf`        BIGINT UNSIGNED NOT NULL COMMENT '11 dígitos',
    `telefone`   BIGINT UNSIGNED NOT NULL COMMENT '11 dígitos (DDD + 9 dígitos)',
    `endereco`   TEXT            NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_fornecedor_nome` (`fornecedor`),
    UNIQUE KEY `uq_fornecedor_cpf` (`cpf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ----------------------------------------------------------------------------
--  produtos
--  Fonte: model/produto/Produto.php
--         INSERT INTO produtos (produto, preco, quantidade_max, quantidade_min,
--                               descricao, unidade_medida, categoria_id,
--                               fornecedor_id, usuario_id)
--         get_id() faz INNER JOIN com categoria e fornecedor pelos ids.
--
--  ATENÇÃO: `quantidade_max` NÃO é um teto de estoque - apesar do nome, é a
--  quantidade ATUAL em estoque. É ela que entrada_estoque soma, saida_estoque
--  subtrai e o alerta compara com `quantidade_min`
--  (Controler_estoqueController::Alert_controll).
-- ----------------------------------------------------------------------------
CREATE TABLE `produtos` (
    `id`             INT UNSIGNED   NOT NULL AUTO_INCREMENT,
    `produto`        VARCHAR(150)   NOT NULL,
    `descricao`      TEXT           NOT NULL,
    `preco`          DECIMAL(10,2)  NOT NULL DEFAULT 0.00,
    `quantidade_max` INT            NOT NULL DEFAULT 0 COMMENT 'quantidade atual em estoque',
    `quantidade_min` INT            NOT NULL DEFAULT 0 COMMENT 'estoque mínimo, dispara o alerta',
    `unidade_medida` VARCHAR(20)    NOT NULL COMMENT 'ex.: kg, un, cx, L',
    `categoria_id`   INT UNSIGNED   NOT NULL,
    `fornecedor_id`  INT UNSIGNED   NOT NULL,
    `usuario_id`     INT UNSIGNED   NOT NULL COMMENT 'usuário que cadastrou o produto',
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_produtos_nome` (`produto`),
    KEY `idx_produtos_categoria` (`categoria_id`),
    KEY `idx_produtos_fornecedor` (`fornecedor_id`),
    KEY `idx_produtos_usuario` (`usuario_id`),
    CONSTRAINT `fk_produtos_categoria`
        FOREIGN KEY (`categoria_id`)  REFERENCES `categoria` (`id`)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT `fk_produtos_fornecedor`
        FOREIGN KEY (`fornecedor_id`) REFERENCES `fornecedor` (`id`)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT `fk_produtos_usuario`
        FOREIGN KEY (`usuario_id`)    REFERENCES `user` (`id`)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ----------------------------------------------------------------------------
--  movimentacao_estoque  -  histórico/log de operações
--  Fonte: model/movimentacao/Movimentacao.php
--         INSERT INTO movimentacao_estoque (tipo, data, quantidade, produto_id,
--                                           usuario_responsavel_id)
--         model/ADM/AdmModel.php -> SELECT * ... WHERE data LIKE :search ORDER BY id DESC
--
--  `data` é VARCHAR de propósito: MovimentacaoController grava date("d/m/Y")
--  (ex.: "13/08/2026") e a busca do admin faz LIKE '%termo%' em cima disso.
--  Um DATE/DATETIME rejeitaria esse formato.
--
--  `produto_id` e `usuario_responsavel_id` ficam SEM foreign key de propósito:
--  ProdutoController::remover_id() apaga o produto e SÓ DEPOIS grava a
--  movimentação de remoção, referenciando um id que não existe mais. Com FK
--  essa operação quebraria. O log é intencionalmente desacoplado.
-- ----------------------------------------------------------------------------
CREATE TABLE `movimentacao_estoque` (
    `id`                     INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `tipo`                   VARCHAR(255) NOT NULL COMMENT 'ex.: "Entrada do Produto: Arroz"',
    `data`                   VARCHAR(10)  NOT NULL COMMENT 'formato d/m/Y gravado por date("d/m/Y")',
    `quantidade`             INT          NOT NULL,
    `produto_id`             INT UNSIGNED NOT NULL COMMENT 'sem FK: o produto pode já ter sido excluído',
    `usuario_responsavel_id` INT UNSIGNED NOT NULL COMMENT 'sem FK: mantém o histórico após exclusão do usuário',
    PRIMARY KEY (`id`),
    KEY `idx_mov_data` (`data`),
    KEY `idx_mov_produto` (`produto_id`),
    KEY `idx_mov_usuario` (`usuario_responsavel_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
