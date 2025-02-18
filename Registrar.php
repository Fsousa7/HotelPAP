<?php
session_start(); // Inicia a sessão

// Verifica se o usuário está logado
if (!isset($_SESSION['id_cliente'])) {
    // Redireciona para a página de login se não estiver logado
    header("Location: login.php?redirect=reservar.php");
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

// Inicializa variáveis
$erro = '';
$sucesso = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe os dados do formulário
    $id_utilizador = $_SESSION['id_cliente'];
    $id_quarto = $_POST['id_quarto'];
    $data_checkin = $_POST['data_checkin'];
    $data_checkout = $_POST['data_checkout'];
    $valor_total = $_POST['valor_total'];

    // Validação simples
    if (!empty($id_quarto) && !empty($data_checkin) && !empty($data_checkout) && !empty($valor_total)) {
        // Prepara a consulta SQL para inserir os dados no banco de dados
        $sql = "INSERT INTO reservas (id_utilizador, id_quarto, data_checkin, data_checkout, valor_total) 
                VALUES (:id_utilizador, :id_quarto, :data_checkin, :data_checkout, :valor_total)";
        $stmt = $pdo->prepare($sql);

        // Executa a consulta
        $stmt->execute([
            'id_utilizador' => $id_utilizador,
            'id_quarto' => $id_quarto,
            'data_checkin' => $data_checkin,
            'data_checkout' => $data_checkout,
            'valor_total' => $valor_total
        ]);

        // Atualiza o status do quarto para 'reservado'
        $sqlUpdateQuarto = "UPDATE quartos SET status = 'reservado' WHERE id_quarto = :id_quarto";
        $stmtUpdateQuarto = $pdo->prepare($sqlUpdateQuarto);
        $stmtUpdateQuarto->execute(['id_quarto' => $id_quarto]);

        // Mensagem de sucesso
        $sucesso = "Reserva efetuada com sucesso!";
    } else {
        // Mensagem de erro se algum campo estiver vazio
        $erro = "Por favor, preencha todos os campos.";
    }
}

// Busca os quartos disponíveis no banco de dados
$sqlQuartos = "SELECT * FROM quartos WHERE status = 'disponivel'";
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

    <title>Reservar Quarto - Hotel Nova Era</title>
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
        <h1 class="text-center">Reservar Quarto</h1>
        <?php if (!empty($erro)): ?>
            <div class="alert alert-danger"><?php echo $erro; ?></div>
        <?php endif; ?>
        <?php if (!empty($sucesso)): ?>
            <div class="alert alert-success"><?php echo $sucesso; ?></div>
        <?php endif; ?>
        <form method="post" action="">
            <div class="form-group">
                <label for="id_quarto">Quarto</label>
                <select class="form-control" id="id_quarto" name="id_quarto" required>
                    <?php foreach ($quartos as $quarto): ?>
                        <option value="<?php echo $quarto['id_quarto']; ?>">
                            <?php echo $quarto['tipo_quarto']; ?> - €<?php echo $quarto['preco_diaria']; ?>/noite
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="data_checkin">Data Check-in</label>
                <input type="date" class="form-control" id="data_checkin" name="data_checkin" required>
            </div>
            <div class="form-group">
                <label for="data_checkout">Data Check-out</label>
                <input type="date" class="form-control" id="data_checkout" name="data_checkout" required>
            </div>
            <div class="form-group">
                <label for="valor_total">Valor Total (€)</label>
                <input type="number" class="form-control" id="valor_total" name="valor_total" required>
            </div>
            <button type="submit" class="btn btn-primary">Reservar</button>
        </form>
    </div>
</body>
</html>