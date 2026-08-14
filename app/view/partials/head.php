<?php
/**
 * Cabeçalho HTML compartilhado por todas as telas.
 *
 * IMPORTANTE: inclua este arquivo somente DEPOIS de toda a lógica PHP da view
 * (validações, POST, header("Location: ...")). Ele emite HTML, e qualquer
 * header() chamado depois disso falha com "headers already sent".
 *
 * Uso:
 *   <?php $titulo = 'Adicionar Produto';
 *         require __DIR__.'/../partials/head.php'; ?>
 *
 * Variáveis opcionais:
 *   $titulo   - texto da aba do navegador
 *   $body_id  - id aplicado no <body> (define o fundo da página)
 */

$titulo  = $titulo  ?? 'Controle de Estoque';
$body_id = $body_id ?? 'background-index';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body id="<?= htmlspecialchars($body_id, ENT_QUOTES, 'UTF-8') ?>">
