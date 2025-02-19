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
}

// Verifica se o usuário está logado
$nomeClienteLogado = isset($_SESSION['nome_cliente']) ? $_SESSION['nome_cliente'] : 'Visitante';
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="logo.jpg" type="image/jpg">

    <title>Hotel Nova Era - Localização</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- Estilos personalizados -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #FFEFD5;
            color: #333;
        }

        /* Google Map */
        .map-container {
            width: 100%;
            height: 500px;
        }

        /* Footer */
        footer {
            background-color: #000000;
            color: white;
            padding: 60px 0;
        }

        footer a {
            color: #ddd;
            text-decoration: none;
        }

        footer a:hover {
            color: white;
        }
    </style>
</head>
<body>

    <!-- Google Map Section -->
    <section id="map" class="map-container">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2990.4092242476177!2d-8.170824724078134!3d41.45203887129177!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd24e86795e143a5%3A0xf0cd9dfb233e2b8d!2sHotel%20Fafense!5e0!3m2!1spt-PT!2spt!4v1739962466150!5m2!1spt-PT!2spt"
            width="100%" 
            height="100%" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy"></iframe>
    </section>

    <!-- Footer -->
    <footer class="text-center">
        <p>&copy; 2025 Hotel Nova Era. Todos os direitos reservados.</p>
        <p> 912 345 678</p>
        <p><a href="index.php">Voltar ao início</a></p>
    </footer>

    <!-- Bootstrap JS e dependências -->
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybB4qEJytE3Mo6p6r3E1iN6Hf0Ks5Wmictb1F9I75VQF3S4bQ" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>