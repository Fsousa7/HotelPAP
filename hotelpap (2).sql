-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 18-Fev-2025 às 09:48
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `hotelpap`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `admins`
--

INSERT INTO `admins` (`id`, `email`, `senha`) VALUES
(1, 'al27344@ae-fafe.pt', '$2y$10$xYu.YaDrkfY./NismDuUb.5YbhhrTcq/RiNvFWREXHqVc3yNcEBD2'),
(2, 'teste@gmail.com', '$2y$10$XJoqwyglskFApxmHxOUn9efZ4jBpnsr6Remj314Zc4wqFADRyP8W6');

-- --------------------------------------------------------

--
-- Estrutura da tabela `contactos`
--

CREATE TABLE `contactos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mensagem` text NOT NULL,
  `data_envio` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pagamentos`
--

CREATE TABLE `pagamentos` (
  `id_pagamento` int(11) NOT NULL,
  `id_reserva` int(11) NOT NULL,
  `metodo_pagamento` enum('cartao_credito','paypal','transferencia_bancaria') NOT NULL,
  `data_pagamento` date NOT NULL,
  `valor_pago` decimal(10,2) NOT NULL,
  `status_pagamento` enum('pago','pendente','cancelado') DEFAULT 'pendente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `quartos`
--

CREATE TABLE `quartos` (
  `id_quarto` int(11) NOT NULL,
  `numero_quarto` int(11) NOT NULL,
  `tipo_quarto` varchar(50) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `preco_diaria` decimal(10,2) NOT NULL,
  `status` enum('disponivel','reservado') NOT NULL DEFAULT 'disponivel'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `quartos`
--

INSERT INTO `quartos` (`id_quarto`, `numero_quarto`, `tipo_quarto`, `descricao`, `preco_diaria`, `status`) VALUES
(0, 0, 'Romântico', '.', 90.00, 'disponivel'),
(1, 101, 'Standard', NULL, 100.00, 'reservado'),
(3, 11, 'Standard', NULL, 100.00, 'reservado'),
(9, 105, 'Standard', '.', 50.00, 'reservado'),
(10, 93, 'Presidencial', '.', 150.00, 'reservado'),
(22, 102, 'Deluxe', '.', 80.00, 'disponivel'),
(34, 4, 'Executivo', '.', 100.00, 'disponivel');

-- --------------------------------------------------------

--
-- Estrutura da tabela `reservas`
--

CREATE TABLE `reservas` (
  `id_reserva` int(11) NOT NULL,
  `id_utilizador` int(11) NOT NULL,
  `id_quarto` int(11) NOT NULL,
  `data_checkin` date NOT NULL,
  `data_checkout` date NOT NULL,
  `status_reserva` enum('pendente','confirmada','cancelada') DEFAULT 'pendente',
  `valor_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `reservas`
--

INSERT INTO `reservas` (`id_reserva`, `id_utilizador`, `id_quarto`, `data_checkin`, `data_checkout`, `status_reserva`, `valor_total`) VALUES
(3, 1, 1, '2024-10-15', '2024-10-20', 'pendente', 500.00),
(5, 1, 1, '2025-02-18', '2025-02-21', 'pendente', 100.00),
(6, 1, 9, '2025-02-18', '2025-02-19', 'pendente', 50.00),
(7, 1, 10, '2025-02-18', '2025-02-19', 'pendente', 150.00),
(8, 1, 10, '2025-02-10', '2025-02-21', 'pendente', 500.00);

-- --------------------------------------------------------

--
-- Estrutura da tabela `utilizadores`
--

CREATE TABLE `utilizadores` (
  `id_utilizador` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `telefone` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `utilizadores`
--

INSERT INTO `utilizadores` (`id_utilizador`, `nome`, `email`, `senha`, `telefone`) VALUES
(1, 'Francisco Jose Nogueira Sousa', 'al27344@ae-fafe.pt', '$2y$10$V1s/yuMtdJCn5ofCrSBg3uTcjG05yOwI0bNh1Raqyr24nzk6q5amG', '912817605'),
(5, 'Daniela almeida', 'danielalmeid@gmail.com', '$2y$10$T/GLGYHOTxAM/hJlKboDx.r5yH6KtbRYioxzWh8ynBf26njHR2sqy', '962047619'),
(6, 'João Silva', 'joao@example.com', 'senha_segura', NULL),
(7, 'rics', '1@1.1', '$2y$10$dJdb.sj9F/QTg4ecWO9gE.AYpwn42Kwe1F0Y7hYw/WUuuHodKbIr.', NULL),
(8, 'rics2', '1@1.11', '$2y$10$OF80C3LoIeAdfyzuc.BblOsypXgGM9C2cTek1o8d1jqWulRCxxarq', NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices para tabela `contactos`
--
ALTER TABLE `contactos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `pagamentos`
--
ALTER TABLE `pagamentos`
  ADD PRIMARY KEY (`id_pagamento`),
  ADD KEY `id_reserva` (`id_reserva`);

--
-- Índices para tabela `quartos`
--
ALTER TABLE `quartos`
  ADD PRIMARY KEY (`id_quarto`),
  ADD UNIQUE KEY `numero_quarto` (`numero_quarto`);

--
-- Índices para tabela `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id_reserva`),
  ADD KEY `id_utilizador` (`id_utilizador`),
  ADD KEY `id_quarto` (`id_quarto`);

--
-- Índices para tabela `utilizadores`
--
ALTER TABLE `utilizadores`
  ADD PRIMARY KEY (`id_utilizador`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `contactos`
--
ALTER TABLE `contactos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `pagamentos`
--
ALTER TABLE `pagamentos`
  MODIFY `id_pagamento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `utilizadores`
--
ALTER TABLE `utilizadores`
  MODIFY `id_utilizador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `pagamentos`
--
ALTER TABLE `pagamentos`
  ADD CONSTRAINT `pagamentos_ibfk_1` FOREIGN KEY (`id_reserva`) REFERENCES `reservas` (`id_reserva`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`id_utilizador`) REFERENCES `utilizadores` (`id_utilizador`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`id_quarto`) REFERENCES `quartos` (`id_quarto`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
