<?php
// Definir as configurações do banco de dados
$host = 'localhost';  // Normalmente "localhost"
$db   = 'hotelpap';    // Nome do banco de dados
$user = 'root';        // Usuário do banco (padrão no XAMPP é 'root')
$pass = '';            // Senha (padrão no XAMPP é vazia)
$charset = 'utf8mb4';

// Configurações de DSN para conexão com o PDO
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Garante que exceções sejam lançadas
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Define o modo de recuperação padrão
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Desativa emulação de prepared statements
];

try {
    // Criar uma nova conexão PDO
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // Se der erro, exibir a mensagem
    die("Erro de conexão: " . $e->getMessage()); // Use die() para evitar a exibição do stack trace
}
?>
