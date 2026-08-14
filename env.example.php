<?php declare(strict_types=1);

/**
 * Modelo de configuração de ambiente.
 *
 * Copie este arquivo para `env.php` na raiz do projeto e preencha com as
 * credenciais da sua máquina. O `env.php` está no .gitignore e nunca deve
 * ser versionado - só este exemplo é.
 *
 *     cp env.example.php env.php
 */

putenv('DB_HOST=localhost');
putenv('DB_NAME=controler_de_estoque');
putenv('DB_CHARSET=utf8mb4');
putenv('DB_USER=root');
putenv('DB_PASSWORD=');
