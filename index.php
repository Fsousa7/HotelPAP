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

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $mensagem = $_POST['mensagem'];

    // Validação simples (você pode adicionar mais validações, como validar o formato de e-mail)
    if (!empty($nome) && !empty($email) && !empty($mensagem)) {
        // Prepara a consulta SQL para inserir os dados no banco de dados
        $sql = "INSERT INTO contactos (nome, email, mensagem) VALUES (:nome, :email, :mensagem)";
        $stmt = $pdo->prepare($sql);

        // Executa a consulta
        $stmt->execute(['nome' => $nome, 'email' => $email, 'mensagem' => $mensagem]);

        // Mensagem de sucesso
        $sucesso = "Mensagem enviada com sucesso!";
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

    <title>Hotel Nova Era - A Sua Escapadela Ideal</title>
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

        /* Estilos para o Hero */
        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('hotel.jpg') no-repeat center center/cover;
            height: 100vh;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
            animation: fadeInDown 1s;
        }

        .hero p {
            font-size: 1.6rem;
            margin-bottom: 30px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
            animation: fadeInUp 1s;
        }

        .hero .btn {
            background-color: transparent;
            border: 2px solid white;
            font-weight: 600;
            padding: 15px 30px;
            color: white;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .hero .btn:hover {
            background-color: white;
            color: #000;
        }

        /* Navbar */
        .navbar {
            background: rgba(0, 0, 0, 0.8);
        }

        .navbar-brand {
            font-weight: 700;
        }

        /* Quartos */
        .quartos {
            background-color: #FFEFD5;
            padding: 60px 0;
        }

        .quartos .card {
            border: none;
            border-radius: 15px;
            transition: transform 0.3s, box-shadow 0.3s;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .quartos .card:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .quartos .card img {
            border-radius: 0;
            height: 200px;
            object-fit: cover;
        }

        .quartos .card-body h5 {
            font-weight: 600;
            margin-bottom: 15px;
        }

        .quartos .btn-primary {
            background-color: #333;
            border-color: #333;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .quartos .btn-primary:hover {
            background-color: #555;
            border-color: #555;
        }

        /* Serviços */
        .servicos {
            background-color: #ffffff;
            padding: 60px 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .servicos .col-md-4 {
            padding: 20px;
        }

        .servicos i {
            font-size: 60px;
            color: #00aaff;
        }

        .servicos h5 {
            font-weight: 600;
            margin-top: 15px;
            margin-bottom: 10px;
        }

        /* Estilos para a Seção de Contactos */
        #contacto h5 {
            font-weight: 600;
            margin-bottom: 10px;
        }
        .dark-background {
            background-color: #2c2c2c;
            color: white;
        }

        #contacto p {
            margin-bottom: 15px;
        }

        #contacto .bi {
            color: #00aaff;
        }

        /* Footer */
        footer {
            background-color: #000000;
            color: white;
            padding: 30px 0;
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
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Hotel Nova Era</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link active" href="#hero">Início</a></li>
                    <li class="nav-item"><a class="nav-link" href="#quartos">Quartos</a></li>
                    <li class="nav-item"><a class="nav-link" href="#servicos">Serviços</a></li>
                    <li class="nav-item"><a class="nav-link" href="#sobre">Sobre</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contacto">Contacto</a></li>
                </ul>

                <div class="d-flex align-items-center ms-3">
                    <p class="text-light mb-0">Olá, <strong><?php echo htmlspecialchars($nomeClienteLogado); ?></strong>!</p>
                    <?php if (isset($_SESSION['nome_cliente'])): ?>
                        <a class="btn btn-outline-light ms-3" href="logout.php">Sair</a>
                    <?php else: ?>
                        <a class="btn btn-outline-light ms-3" href="login.php">Entrar</a>
                        <a class="btn btn-outline-light ms-2" href="registro.php">Registrar</a>
                    <?php endif; ?>
                    <a class="btn btn-outline-light ms-3" href="carrinho.php">Carrinho</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="hero" class="hero">
        <h1 class="animate__animated">Hotel Nova Era</h1>
        <a href="#quartos" class="btn btn-primary btn-lg mt-3 animate__animated">Ver Quartos</a>
    </section>

    <!-- Seção de Quartos -->
    <section id="quartos" class="quartos py-5">
        <div class="container">
            <h2 class="text-center mb-5">Os Nossos Quartos</h2>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="card shadow animate__animated">
                        <img src="quarto1.jpg" class="card-img-top" alt="Quarto Standard">
                        <div class="card-body text-center">
                            <h5 class="card-title">Quarto Standard</h5>
                            <p class="card-text">Confortável e acessível para quem busca simplicidade.</p>
                            <p><strong>€50/noite</strong></p>
                            <a href="reservar.php" class="btn btn-primary reservar-btn" data-rtype="standard">Reservar</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card shadow animate__animated">
                        <img src="quarto2.jpg" class="card-img-top" alt="Quarto Deluxe">
                        <div class="card-body text-center">
                            <h5 class="card-title">Quarto Deluxe</h5>
                            <p class="card-text">Elegante e espaçoso, ideal para relaxar com estilo.</p>
                            <p><strong>€80/noite</strong></p>
                            <a href="reservar.php" class="btn btn-primary reservar-btn" data-rtype="Deluxe">Reservar</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card shadow animate__animated">
                        <img src="quarto3.jpg" class="card-img-top" alt="Suíte Presidencial">
                        <div class="card-body text-center">
                            <h5 class="card-title">Suíte Presidencial</h5>
                            <p class="card-text">Acomodações luxuosas com todas as comodidades premium.</p>
                            <p><strong>€150/noite</strong></p>
                            <a href="reservar.php" class="btn btn-primary reservar-btn" data-rtype="Presidencial">Reservar</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card shadow animate__animated">
                        <img src="quarto4.jpg" class="card-img-top" alt="Suíte Familiar">
                        <div class="card-body text-center">
                            <h5 class="card-title">Suíte Familiar</h5>
                            <p class="card-text">Perfeita para famílias, com espaço extra para todos.</p>
                            <p><strong>€120/noite</strong></p>
                            <a href="reservar.php" class="btn btn-primary reservar-btn" data-rtype="Familiar">Reservar</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card shadow animate__animated">
                        <img src="quarto5.jpg" class="card-img-top" alt="Quarto Executivo">
                        <div class="card-body text-center">
                            <h5 class="card-title">Quarto Executivo</h5>
                            <p class="card-text">Equipado para quem viaja a trabalho, com áreas de trabalho confortáveis.</p>
                            <p><strong>€100/noite</strong></p>
                            <a href="reservar.php" class="btn btn-primary reservar-btn" data-rtype="Executivo">Reservar</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card shadow animate__animated">
                        <img src="quarto6.jpg" class="card-img-top" alt="Quarto Romântico">
                        <div class="card-body text-center">
                            <h5 class="card-title">Quarto Romântico</h5>
                            <p class="card-text">Perfeito para casais que buscam uma escapada especial.</p>
                            <p><strong>€90/noite</strong></p>
                            <a href="reservar.php" class="btn btn-primary reservar-btn" data-rtype="Romantico">Reservar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Seção de Serviços -->
    <section id="servicos" class="servicos">
        <div class="container-fluid">
            <h2 class="text-center mb-5">Serviços Disponíveis</h2>
            <div class="row">
                <div class="col-md-4 text-center">
                    <i class="bi bi-wifi"></i>
                    <h5>Wi-Fi Grátis</h5>
                    <p>Conexão rápida em todas as áreas do hotel.</p>
                </div>
                <div class="col-md-4 text-center">
                    <i class="bi bi-geo-alt-fill"></i>
                    <h5>Localização Central</h5>
                    <p>Estamos no coração da cidade, perto de tudo.</p>
                </div>
                <div class="col-md-4 text-center">
                    <i class="bi bi-cup-hot"></i>
                    <h5>Café da Manhã</h5>
                    <p>Incluído na sua estadia, com opções deliciosas.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Seção de Contactos -->
    <section id="contacto" class="py-5 dark-background">
        <div class="container">
            <h2 class="text-center mb-5">Contacte-nos</h2>
            <div class="row text-center">
                <div class="col-md-4">
                    <h5>Telefone</h5>
                    <p>+351 912 345 678</p>
                </div>
                <div class="col-md-4">
                    <h5>Email</h5>
                    <p><a href="mailto:info@hotelnovaera.pt">al27344@ae-fafe.pt</a></p>
                </div>
                <div class="col-md-4">
                    <h5>Localização</h5>
                    <p>Rua X, 123<br>Fafe, Portugal</p>
                </div>
            </div>
            
            <div class="text-center">
                <h5 class="mt-4">Redes Sociais</h5>
                <a href="https://www.facebook.com/HotelNovaEra" class="me-3" target="_blank">
                    <i class="bi bi-facebook" style="font-size: 2rem;"></i>
                </a>
                <a href="https://www.instagram.com/hotelnovaera" class="me-3" target="_blank">
                    <i class="bi bi-instagram" style="font-size: 2rem;"></i>
                </a>
                <a href="https://twitter.com/hotelnovaera" target="_blank">
                    <i class="bi bi-twitter" style="font-size: 2rem;"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center">
        <p>&copy; 2025 Hotel Nova Era. Todos os direitos reservados.</p>
        <p><a href="#hero">Voltar ao topo</a></p>
    </footer>

    <!-- Bootstrap JS e dependências -->
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybB4qEJytE3Mo6p6r3E1iN6Hf0Ks5Wmictb1F9I75VQF3S4bQ" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Scroll suave ao clicar nos links do menu -->
    <script>
        document.querySelectorAll('.navbar-nav a').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault(); 
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>
