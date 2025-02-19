<?php
session_start(); // Inicia a sessão

// Configurações de conexão com o banco de dados
$host = 'localhost';
$db = 'hotelpap';
$user = 'root';
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_reserva = $_POST['id_reserva'];

    // Obtém o ID do quarto da reserva a ser cancelada
    $sql = "SELECT id_quarto FROM reservas WHERE id_reserva = :id_reserva";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id_reserva' => $id_reserva]);
    $reserva = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($reserva) {
        $id_quarto = $reserva['id_quarto'];

        // Atualiza o status do quarto para 'disponivel'
        $sqlUpdateQuarto = "UPDATE quartos SET status = 'disponivel' WHERE id_quarto = :id_quarto";
        $stmtUpdateQuarto = $pdo->prepare($sqlUpdateQuarto);
        $stmtUpdateQuarto->execute(['id_quarto' => $id_quarto]);

        // Remove a reserva
        $sqlDeleteReserva = "DELETE FROM reservas WHERE id_reserva = :id_reserva";
        $stmtDeleteReserva = $pdo->prepare($sqlDeleteReserva);
        $stmtDeleteReserva->execute(['id_reserva' => $id_reserva]);

        // Mensagem de sucesso
        $_SESSION['mensagem'] = "Reserva cancelada com sucesso!";
    } else {
        // Mensagem de erro se a reserva não for encontrada
        $_SESSION['mensagem'] = "Reserva não encontrada!";
    }

    // Redireciona de volta para a página de reservas
    header("Location: reservas.php");
    exit();
}
?>