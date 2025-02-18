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
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Consultando o banco de dados
    $sql = "SELECT * FROM utilizadores WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificando se o usuário existe
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verificando a senha
        if (password_verify($senha, $user['senha'])) {
            // Armazenar o ID e o nome na sessão
            $_SESSION['id_cliente'] = $user['id_utilizador']; // Defina o ID do cliente na sessão
            $_SESSION['nome_cliente'] = $user['nome']; // Armazena o nome do cliente na sessão

            // Verifica se há um redirecionamento definido
            $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'index.php';

            // Redireciona para a página desejada
            header("Location: $redirect");
            exit();
        } else {
            $error_message = "Senha incorreta!";
        }
    } else {
        $error_message = "Usuário não encontrado!";
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
    <title>Entrar - Hotel Nova Era</title>
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
        .toggle-password {
            cursor: pointer;
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            transition: color 0.3s;
        }
        .toggle-password:hover {
            color: #333;
        }
        .password-container {
            position: relative;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
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
        <h2>Hotel Nova Era</h2>
        <p><h5>Entrar</h5></p>
        <form method="POST" action="">
            <input type="email" class="form-control" id="email" name="email" placeholder="E-mail" required>
            <div class="password-container">
                <input type="password" class="form-control" id="senha" name="senha" placeholder="Senha" required>
                <i class="bi bi-eye-slash toggle-password" id="togglePassword"></i>
            </div>
            <button type="submit" class="btn btn-primary">Entrar</button>
        </form>

        <div class="or-divider"><span>OU</span></div>
        <div class="mt-3">
            <a href="index.php" class="link">Voltar à Página Inicial</a>
        </div>
    </div>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Verifica se ocorreu um erro no login e mostra o alerta
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

        // Função de visualizar/esconder senha
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#senha');

        togglePassword.addEventListener('click', function (e) {
            // Alterna o tipo de input entre senha e texto
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // Alterna o ícone
            this.classList.toggle('bi-eye');
        });
    </script>
</body>
</html>