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

// Inicializa variáveis
$erro = '';
$sucesso = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe os dados do formulário
    $tipo_quarto = $_POST['tipo_quarto'];
    $descricao = $_POST['descricao'];
    $preco_diaria = $_POST['preco_diaria'];

    // Validação simples
    if (!empty($tipo_quarto) && !empty($descricao) && !empty($preco_diaria)) {
        // Prepara a consulta SQL para inserir os dados no banco de dados
        $sql = "INSERT INTO quartos (tipo_quarto, descricao, preco_diaria) 
                VALUES (:tipo_quarto, :descricao, :preco_diaria)";
        $stmt = $pdo->prepare($sql);

        // Executa a consulta
        $stmt->execute([
            'tipo_quarto' => $tipo_quarto,
            'descricao' => $descricao,
            'preco_diaria' => $preco_diaria
        ]);

        // Mensagem de sucesso
        $sucesso = "Quarto adicionado com sucesso!";
    } else {
        // Mensagem de erro se algum campo estiver vazio
        $erro = "Por favor, preencha todos os campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="logo.jpg" type="image/jpg">

    <title>Adicionar Quarto - Hotel Nova Era</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <!-- Estilos personalizados -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #FFEFD5;
            color: #333;
        }
        .container {
            margin-top: 50px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Adicionar Quarto</h1>
        <?php if (!empty($erro)): ?>
            <div class="alert alert-danger"><?php echo $erro; ?></div>
        <?php endif; ?>
        <?php if (!empty($sucesso)): ?>
            <div class="alert alert-success"><?php echo $sucesso; ?></div>
        <?php endif; ?>
        <form method="post" action="">
            <div class="form-group">
                <label for="tipo_quarto">Tipo de Quarto</label>
                <input type="text" class="form-control" id="tipo_quarto" name="tipo_quarto" required>
            </div>
            <div class="form-group">
                <label for="descricao">Descrição</label>
                <textarea class="form-control" id="descricao" name="descricao" required></textarea>
            </div>
            <div class="form-group">
                <label for="preco_diaria">Preço da Diária (€)</label>
                <input type="number" class="form-control" id="preco_diaria" name="preco_diaria" required>
            </div>
            <button type="submit" class="btn btn-primary">Adicionar</button>
        </form>
    </div>
</body>
</html>