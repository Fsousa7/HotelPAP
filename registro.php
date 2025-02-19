<?php
session_start(); // Inicia a sessão

// Configurações da conexão com a base de dados
$servername = "localhost"; // Pode precisar ajustar se estiver usando um servidor diferente
$username = "root"; // Substitua pelo seu nome de usuário do banco de dados
$password = ""; // Deixe vazio se não houver senha, ou coloque sua senha aqui
$dbname = "hotelpap"; // Nome da sua base de dados

// Criando a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificando a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Processando o formulário ao enviar os dados
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    // Verificando se o usuário já existe
    $sql = "SELECT * FROM utilizadores WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Inserindo o novo usuário no banco de dados
        $sql = "INSERT INTO utilizadores (nome, email, telefone, senha) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $nome, $email, $telefone, $senha);

        if ($stmt->execute()) {
            $sucesso = "Registro realizado com sucesso! Você já pode fazer login.";
        } else {
            $error_message = "Erro ao registrar. Tente novamente.";
        }
    } else {
        $error_message = "E-mail já cadastrado!";
    }

    // Fechando a declaração
    $stmt->close();
}

// Fechando a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="logo.jpg" type="image/jpg">
    <title>Registrar - Hotel Nova Era</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Google Font (Poppins, usada no Instagram) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fafafa;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            animation: fadeIn 1s;
        }
        .container {
            width: 350px;
            padding: 40px;
            background-color: #fff;
            border: 1px solid #dbdbdb;
            border-radius: 8px;
            text-align: center;
            animation: bounceIn 1s;
        }
        .container h2 {
            font-size: 1.5rem;
            margin-bottom: 20px;
            font-weight: 500;
        }
        .form-control {
            background-color: #fafafa;
            border: 1px solid #dbdbdb;
            border-radius: 5px;
            font-size: 14px;
            padding: 10px;
            margin-bottom: 10px;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #a1a1a1;
        }
        .btn-primary {
            width: 100%;
            background-color: #0095f6;
            border: none;
            padding: 10px;
            font-weight: 500;
            font-size: 14px;
            border-radius: 5px;
        }
        .btn-primary:hover {
            background-color: #007bbf;
        }
        .or-divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 15px 0;
        }
        .or-divider::before,
        .or-divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #dbdbdb;
        }
        .or-divider:not(:empty)::before {
            margin-right: .25em;
        }
        .or-divider:not(:empty)::after {
            margin-left: .25em;
        }
        .or-divider span {
            color: #8e8e8e;
            font-size: 12px;
        }
        .link {
            color: #0095f6;
            text-decoration: none;
            font-size: 14px;
        }
        .link:hover {
            text-decoration: underline;
        }
        /* Estilo para a bolinha do logotipo */
        .logo-container {
            display: flex;
            justify-content: center;
            margin-bottom: 15px;
        }
        .logo-container img {
            width: 80px; /* Ajuste o tamanho da bolinha */
            height: 80px;
            border-radius: 50%; /* Faz a imagem ficar circular */
            object-fit: cover; /* Garante que a imagem se ajuste à bolinha */
            animation: rotateIn 1s;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        @keyframes bounceIn {
            from, 20%, 40%, 60%, 80%, to {
                animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
            }
            0% {
                opacity: 0;
                transform: scale3d(0.3, 0.3, 0.3);
            }
            20% {
                transform: scale3d(1.1, 1.1, 1.1);
            }
            40% {
                transform: scale3d(0.9, 0.9, 0.9);
            }
            60% {
                opacity: 1;
                transform: scale3d(1.03, 1.03, 1.03);
            }
            80% {
                transform: scale3d(0.97, 0.97, 0.97);
            }
            to {
                opacity: 1;
                transform: scale3d(1, 1, 1);
            }
        }
        @keyframes rotateIn {
            from {
                transform: rotate3d(0, 0, 1, -200deg);
                opacity: 0;
            }
            to {
                transform: none;
                opacity: 1;
            }
        }
    </style>
</head>
<body>

    <div class="container animate__animated">
        <div class="logo-container">
            <!-- Substitua "logo.png" pelo caminho da sua imagem de logotipo -->
            <img src="logo.jpg" alt="Logotipo do Hotel">
        </div>
        <h2>Registrar-se</h2>
        <form method="POST" action="">
            <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" required>
            <input type="email" class="form-control" id="email" name="email" placeholder="E-mail" required>
            <input type="text" class="form-control" id="telefone" name="telefone" placeholder="Telefone" required>
            <input type="password" class="form-control" id="senha" name="senha" placeholder="Senha" required>
            <button type="submit" class="btn btn-primary">Registrar</button>
        </form>

        <div class="or-divider"><span>OU</span></div>
        <div class="mt-3">
            <a href="login.php" class="link">Já tem uma conta? Entrar</a>
        </div>
    </div>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Verifica se ocorreu um erro no registro e mostra o alerta
        <?php if (isset($error_message)): ?>
            Swal.fire({
                title: 'Erro!',
                text: '<?php echo $error_message; ?>',
                icon: 'error',
                confirmButtonText: 'OK',
                customClass: {
                    popup: 'animate__animated animate__shakeX'
                }
            });
        <?php endif; ?>
        // Verifica se o registro foi bem-sucedido e mostra o alerta
        <?php if (isset($sucesso)): ?>
            Swal.fire({
                title: 'Sucesso!',
                text: '<?php echo $sucesso; ?>',
                icon: 'success',
                confirmButtonText: 'OK',
                customClass: {
                    popup: 'animate__animated animate__bounceIn'
                }
            });
        <?php endif; ?>
    </script>
</body>
</html>