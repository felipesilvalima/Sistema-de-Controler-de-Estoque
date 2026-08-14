-- ============================================================================
--  Sistema de Controle de Estoque - Dados iniciais para testes
--  Rodar DEPOIS de database/schema.sql
--  Uso: mysql -u root -p controler_de_estoque < database/seed.sql
--
--  Credenciais de acesso criadas aqui:
--    Usuário comum  -> email: felipe@email.com   senha: 123456
--    Administrador  -> cpf:   12345678901        senha: admin123
-- ============================================================================

USE `controler_de_estoque`;

-- Usuários comuns (hash bcrypt de "123456")
INSERT INTO `user` (`id`, `name`, `email`, `password`) VALUES
(1, 'Felipe Silva Lima', 'felipe@email.com', '$2y$10$KxHumqgzlj6mRNtIUQNHBOKf1omXixWu8hA7avukNRyAUG5lGlWNa'),
(2, 'Maria Souza',       'maria@email.com',  '$2y$10$KxHumqgzlj6mRNtIUQNHBOKf1omXixWu8hA7avukNRyAUG5lGlWNa');

-- Administradores (hash bcrypt de "admin123")
INSERT INTO `adm` (`id`, `cpf`, `senha`) VALUES
(1, 12345678901, '$2y$10$7ILwb1z.SP6VlG0T4aCueO36s2CUdmwpud.ZVsR3QFHgGhLiPqWni');

-- Categorias
INSERT INTO `categoria` (`id`, `categoria`, `descricao`) VALUES
(1, 'Alimentos',  'Produtos alimentícios em geral, secos e molhados.'),
(2, 'Bebidas',    'Bebidas alcoólicas e não alcoólicas.'),
(3, 'Limpeza',    'Produtos de higiene e limpeza doméstica.'),
(4, 'Papelaria',  'Materiais de escritório e papelaria.');

-- Fornecedores (cpf e telefone com exatamente 11 dígitos, como exige a validação)
INSERT INTO `fornecedor` (`id`, `fornecedor`, `cpf`, `telefone`, `endereco`) VALUES
(1, 'Distribuidora Central', 11122233344, 11987654321, 'Rua das Flores, 120 - Centro, São Paulo/SP'),
(2, 'Atacado Bom Preço',     55566677788, 21987654321, 'Av. Brasil, 4500 - Bonsucesso, Rio de Janeiro/RJ'),
(3, 'Comercial Silva',       99988877766, 31987654321, 'Rua Minas, 88 - Savassi, Belo Horizonte/MG');

-- Produtos (lembrando: quantidade_max = estoque atual)
INSERT INTO `produtos`
    (`id`, `produto`, `descricao`, `preco`, `quantidade_max`, `quantidade_min`, `unidade_medida`, `categoria_id`, `fornecedor_id`, `usuario_id`) VALUES
(1, 'Arroz Branco 5kg',   'Arroz tipo 1, pacote de 5kg.',            28.90, 120, 20, 'un', 1, 1, 1),
(2, 'Feijão Carioca 1kg', 'Feijão carioca tipo 1, pacote de 1kg.',    8.49,  80, 15, 'un', 1, 1, 1),
(3, 'Refrigerante 2L',    'Refrigerante de cola, garrafa PET de 2L.', 9.99,  45, 10, 'un', 2, 2, 1),
(4, 'Detergente 500ml',   'Detergente neutro, frasco de 500ml.',      2.79,   8, 10, 'un', 3, 3, 2),
(5, 'Caneta Azul',        'Caneta esferográfica azul, ponta 1.0mm.',  1.99, 200, 50, 'un', 4, 3, 2);
-- Obs.: o produto 4 está com estoque (8) abaixo do mínimo (10) de propósito,
-- para a tela de "Alerta de Estoque Baixo" ter o que exibir.

-- Histórico de movimentações (data no formato d/m/Y, como o PHP grava)
INSERT INTO `movimentacao_estoque` (`id`, `tipo`, `data`, `quantidade`, `produto_id`, `usuario_responsavel_id`) VALUES
(1, 'Inserção do Produto: Arroz Branco 5kg',   '10/08/2026', 100, 1, 1),
(2, 'Inserção do Produto: Feijão Carioca 1kg', '10/08/2026',  80, 2, 1),
(3, 'Inserção do Produto: Refrigerante 2L',    '11/08/2026',  60, 3, 1),
(4, 'Entrada do Produto: Arroz Branco 5kg',    '12/08/2026',  20, 1, 1),
(5, 'Baixa no Produto: Refrigerante 2L',       '12/08/2026',  15, 3, 2),
(6, 'Inserção do Produto: Detergente 500ml',   '12/08/2026',  30, 4, 2),
(7, 'Baixa no Produto: Detergente 500ml',      '13/08/2026',  22, 4, 2),
(8, 'Inserção do Produto: Caneta Azul',        '13/08/2026', 200, 5, 2);
