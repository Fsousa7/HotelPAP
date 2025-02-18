<?php
session_start(); // Inicia a sessão

// Verifica se o usuário está logado
if (!isset($_SESSION['id_cliente'])) {
    // Redireciona para a página de login se não estiver logado
    header("Location: login.php?redirect=carrinho.php");
    exit();
}

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

// Pega o ID do utilizador da sessão
$id_cliente = $_SESSION['id_cliente'];

// Busca as reservas feitas pelo usuário logado
$sqlReservas = "SELECT reservas.id_reserva, quartos.tipo_quarto, reservas.data_checkin, reservas.data_checkout, reservas.valor_total 
                FROM reservas 
                JOIN quartos ON reservas.id_quarto = quartos.id_quarto 
                WHERE reservas.id_utilizador = :id_cliente";
$stmtReservas = $pdo->prepare($sqlReservas);
$stmtReservas->execute(['id_cliente' => $id_cliente]);
$reservas = $stmtReservas->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="logo.jpg" type="image/jpg">

    <title>Meu Carrinho - Hotel Nova Era</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Estilos personalizados -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url('hotel.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #333;
        }
        .container {
            margin-top: 50px;
            margin-bottom: 50px;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            background-color: rgba(255, 255, 255, 0.9);
        }
        .card-header {
            background-color: #333;
            color: #fff;
            font-size: 1.5rem;
            font-weight: 700;
            text-align: center;
            padding: 20px;
        }
        .card-body {
            padding: 30px;
        }
        .table {
            margin-bottom: 0;
        }
        .table thead th {
            border-top: none;
            background-color: #e9ecef;
        }
        .table tbody tr {
            transition: all 0.3s ease;
        }
        .table tbody tr:hover {
            background-color: #f1f1f1;
        }
        .btn {
            background-color: #333;
            border: none;
            color: #fff;
            padding: 10px 20px;
            font-size: 1rem;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        .btn:hover {
            background-color: #555;
        }
        .text-center a {
            display: inline-block;
            margin-top: 20px;
        }
        footer {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
            border-radius: 0 0 10px 10px;
            margin-top: 20px;
        }
        footer a {
            color: #ffc107;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        footer a:hover {
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                Meu Carrinho
            </div>
            <div class="card-body">
                <?php if (empty($reservas)): ?>
                    <div class="alert alert-info text-center">Você não tem reservas no momento.</div>
                <?php else: ?>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tipo de Quarto</th>
                                <th>Data Check-in</th>
                                <th>Data Check-out</th>
                                <th>Valor Total (€)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reservas as $reserva): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($reserva['id_reserva']); ?></td>
                                    <td><?php echo htmlspecialchars($reserva['tipo_quarto']); ?></td>
                                    <td><?php echo htmlspecialchars($reserva['data_checkin']); ?></td>
                                    <td><?php echo htmlspecialchars($reserva['data_checkout']); ?></td>
                                    <td><?php echo htmlspecialchars($reserva['valor_total']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
                <div class="text-center">
                    <a href="index.php" class="btn">Continuar Reservando</a>
                </div>
            </div>
        </div>
        
    </div>
</body>
</html>