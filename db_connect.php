<?php
$host = 'localhost'; // Ajusta conforme o teu servidor
$dbname = 'hotelpap'; // Substitui pelo nome da tua base de dados
$username = 'root'; // O teu nome de utilizador da base de dados
$password = ''; // A tua palavra-passe da base de dados

try {
    // Conectar à base de dados
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Se houver um erro de conexão
    die("Conexão falhou: " . $e->getMessage());
}
?>
