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

// Busca todos os quartos no banco de dados
$sqlQuartos = "SELECT * FROM quartos";
$stmtQuartos = $pdo->prepare($sqlQuartos);
$stmtQuartos->execute();
$quartos = $stmtQuartos->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="logo.jpg" type="image/jpg">

    <title>Painel de Quartos - Hotel Nova Era</title>
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
            background-color: #f8f9fa;
            color: #333;
        }
        .container {
            margin-top: 50px;
        }
        .panel {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
        }
        .seat {
            width: 70px;
            height: 70px;
            margin: 5px;
            background-color: #28a745; /* Verde para disponível */
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .seat.reserved {
            background-color: #dc3545; /* Vermelho para reservado */
        }
        .seat:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .legend {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .legend div {
            display: flex;
            align-items: center;
            margin: 0 10px;
        }
        .legend .box {
            width: 20px;
            height: 20px;
            margin-right: 5px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container text-center">
        <h1>Painel de Quartos Disponíveis</h1>
        <div class="panel">
            <?php foreach ($quartos as $quarto): ?>
                <div class="seat <?php echo $quarto['status'] == 'reservado' ? 'reserved' : ''; ?>">
                    <?php echo $quarto['numero_quarto']; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="legend">
            <div>
                <div class="box" style="background-color: #28a745;"></div> Disponível
            </div>
            <div>
                <div class="box" style="background-color: #dc3545;"></div> Reservado
            </div>
        </div>
    </div>

    <!-- Bootstrap JS e dependências -->
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybB4qEJytE3Mo6p6r3E1iN6Hf0Ks5Wmictb1F9I75VQF3S4bQ" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>