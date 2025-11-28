-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 28/11/2025 às 19:28
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sistema_login`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `atividades_usuarios`
--

CREATE TABLE `atividades_usuarios` (
  `usuario_id` int(11) NOT NULL,
  `ultima_atividade` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `atividades_usuarios`
--

INSERT INTO `atividades_usuarios` (`usuario_id`, `ultima_atividade`) VALUES
(2, '2025-11-28 18:23:11'),
(3, '2025-11-28 16:13:21');

-- --------------------------------------------------------

--
-- Estrutura para tabela `logs_acesso`
--

CREATE TABLE `logs_acesso` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `pagina` varchar(255) DEFAULT NULL,
  `data_acesso` timestamp NOT NULL DEFAULT current_timestamp(),
  `ip` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `data_criacao`, `is_admin`) VALUES
(1, 'Junior', 'junior@gmail.com', '$2y$10$tGkKLEZJEW5n0fitj9IQVOCmXHT/osFpGaGw28K72suG4z9v5ZDLq', '2025-11-28 02:39:13', 0),
(2, 'Junior Gomes', 'jrniorgomes@gmail.com', '$2y$10$SdbxnT/S0qHMgDoVBBLJn.55uG86rNlR2jr2i6HyR0XpIuk1nZpRu', '2025-11-28 03:46:55', 1),
(3, 'Junior', 'juniorgomes1@email.com', '$2y$10$PyadzJWiCWDH4YKCqe7OKuopH43C3LBBtGsVhWdEt/IQgHEUvISo.', '2025-11-28 16:04:38', 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `atividades_usuarios`
--
ALTER TABLE `atividades_usuarios`
  ADD PRIMARY KEY (`usuario_id`);

--
-- Índices de tabela `logs_acesso`
--
ALTER TABLE `logs_acesso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `logs_acesso`
--
ALTER TABLE `logs_acesso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `atividades_usuarios`
--
ALTER TABLE `atividades_usuarios`
  ADD CONSTRAINT `atividades_usuarios_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `logs_acesso`
--
ALTER TABLE `logs_acesso`
  ADD CONSTRAINT `logs_acesso_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
