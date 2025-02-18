<?php
// db.php - Configuração de conexão com o banco de dados
$host = '127.0.0.1';
$db = 'hotelpap';
$user = 'root';  // Substitua pelo seu usuário do MySQL
$pass = '';      // Substitua pela sua senha do MySQL, se houver
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}
?>
