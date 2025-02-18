<?php
// db.php - Configuração de conexão com o banco de dados
session_start();

$host = '127.0.0.1';
$db = 'hotelpap';
$user = 'root';
$pass = '';
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

// Função de Login e Logout
function login($email, $senha) {
    global $pdo;

    // Verificar se o administrador existe no banco de dados
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE email = ?");
    $stmt->execute([$email]);
    $admin = $stmt->fetch();

    // Verificar se a senha é válida
    if ($admin && password_verify($senha, $admin['senha'])) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_email'] = $email;
        header('Location: admin.php?page=utilizadores#');
        exit();
    } else {
        return "Email ou senha incorretos!";
    }
}

if (isset($_POST['login'])) {
    $message = login($_POST['email'], $_POST['senha']);
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit();
}

// Página de Login
if (!isset($_SESSION['admin_logged_in'])):
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center">Admin Login</h4>
                        <?php if (isset($message)): ?>
                            <div class="alert alert-danger"><?= $message ?></div>
                        <?php endif; ?>
                        <form method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="senha" class="form-label">Senha</label>
                                <input type="password" class="form-control" id="senha" name="senha" required>
                            </div>
                            <button type="submit" name="login" class="btn btn-primary w-100">Entrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php
    exit();
endif;

// Página de Administração
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }
        .nav-link {
            transition: color 0.3s ease;
        }
        .nav-link:hover {
            color: #ffc107 !important;
        }
        .container {
            margin-top: 50px;
        }
        h3 {
            margin-bottom: 20px;
            font-weight: bold;
            color: #343a40;
        }
        table {
            transition: transform 0.3s ease;
        }
        table:hover {
            transform: scale(1.02);
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }
        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Hotel Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="?page=utilizadores">Utilizadores</a></li>
                    <li class="nav-item"><a class="nav-link" href="?page=quartos">Quartos</a></li>
                    <li class="nav-item"><a class="nav-link" href="?page=reservas">Reservas</a></li>
                    <li class="nav-item"><a class="nav-link" href="?page=admins">Admins</a></li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="?logout">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <?php
        $page = $_GET['page'] ?? 'dashboard';

        // Renderização das Tabelas
        if ($page == 'utilizadores') {
            $stmt = $pdo->query("SELECT * FROM utilizadores");
            echo "<h3>Utilizadores</h3><table class='table table-striped table-hover'><tr><th>ID</th><th>Nome</th><th>Email</th><th>Telefone</th></tr>";
            foreach ($stmt as $row) {
                echo "<tr><td>{$row['id_utilizador']}</td><td>{$row['nome']}</td><td>{$row['email']}</td><td>{$row['telefone']}</td></tr>";
            }
            echo "</table>";
        } elseif ($page == 'quartos') {
            $stmt = $pdo->query("SELECT * FROM quartos");
            echo "<h3>Quartos</h3><table class='table table-striped table-hover'><tr><th>ID</th><th>Número</th><th>Tipo</th><th>Descrição</th><th>Preço</th></tr>";
            foreach ($stmt as $row) {
                echo "<tr><td>{$row['id_quarto']}</td><td>{$row['numero_quarto']}</td><td>{$row['tipo_quarto']}</td><td>{$row['descricao']}</td><td>{$row['preco_diaria']}</td></tr>";
            }
            echo "</table>";
            echo "<a href='add_quarto.php' class='btn btn-success mt-3'>Adicionar Quarto</a>"; // Botão para redirecionar para add_quarto.php
        } elseif ($page == 'reservas') {
            $stmt = $pdo->query("SELECT * FROM reservas");
            echo "<h3>Reservas</h3><table class='table table-striped table-hover'><tr><th>ID</th><th>ID Utilizador</th><th>ID Quarto</th><th>Check-in</th><th>Check-out</th><th>Status</th><th>Valor Total</th></tr>";
            foreach ($stmt as $row) {
                echo "<tr><td>{$row['id_reserva']}</td><td>{$row['id_utilizador']}</td><td>{$row['id_quarto']}</td><td>{$row['data_checkin']}</td><td>{$row['data_checkout']}</td><td>{$row['status_reserva']}</td><td>{$row['valor_total']}</td></tr>";
            }
            echo "</table>";
        } elseif ($page == 'admins') {
            // Gerenciar administradores
            if (isset($_POST['add_admin'])) {
                $email = $_POST['email'];
                $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

                // Verificar se o email já existe
                $stmt = $pdo->prepare("SELECT * FROM admins WHERE email = ?");
                $stmt->execute([$email]);
                if ($stmt->rowCount() > 0) {
                    $message = "Este email já está registrado.";
                } else {
                    // Inserir novo administrador
                    $stmt = $pdo->prepare("INSERT INTO admins (email, senha) VALUES (?, ?)");
                    if ($stmt->execute([$email, $senha])) {
                        $message = "Administrador adicionado com sucesso.";
                    } else {
                        $message = "Erro ao adicionar administrador.";
                    }
                }
            }

            // Exibir lista de administradores
            $stmt = $pdo->query("SELECT * FROM admins");
            ?>

            <h3>Gerenciar Administradores</h3>
            
            <?php if (isset($message)): ?>
                <div class="alert alert-info"><?= $message ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email do Administrador</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="senha" name="senha" required>
                </div>
                <button type="submit" name="add_admin" class="btn btn-primary">Adicionar Administrador</button>
            </form>

            <h4 class="mt-5">Lista de Administradores</h4>
            <table class="table table-striped table-hover">
                <tr><th>ID</th><th>Email</th></tr>
                <?php foreach ($stmt as $admin): ?>
                    <tr><td><?= $admin['id'] ?></td><td><?= $admin['email'] ?></td></tr>
                <?php endforeach; ?>
            </table>
        <?php
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>