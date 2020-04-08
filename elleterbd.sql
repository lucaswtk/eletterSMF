-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 08-Abr-2020 às 23:52
-- Versão do servidor: 10.4.11-MariaDB
-- versão do PHP: 7.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `elleterbd`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `fields`
--

CREATE TABLE `fields` (
  `id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `metadata_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `fields`
--

INSERT INTO `fields` (`id`, `model_id`, `metadata_id`) VALUES
(19, 13, 14),
(20, 13, 15),
(21, 14, 14),
(22, 14, 16),
(23, 14, 17),
(24, 15, 18);

-- --------------------------------------------------------

--
-- Estrutura da tabela `metadata`
--

CREATE TABLE `metadata` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `label_name` text NOT NULL,
  `description` text NOT NULL,
  `type` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `metadata`
--

INSERT INTO `metadata` (`id`, `name`, `label_name`, `description`, `type`) VALUES
(14, 'nomeCadastrante', 'Nome cadastrante', 'Nome de quem estiver realizando o cadastro', 'Text'),
(15, 'telefoneCadastrante', 'Telefone do cadastrante', 'Telefone do cadastrante', 'Number'),
(16, 'teste', 'label teste', 'testeee', 'Date'),
(17, 'teste 2', 'teste 02', 'dafasdfsa', 'Email'),
(18, 'emailCadastrante', 'email do  cadastrante', 'email da pessoa', 'Email');

-- --------------------------------------------------------

--
-- Estrutura da tabela `models`
--

CREATE TABLE `models` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `local_name` text NOT NULL,
  `created_by` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `models`
--

INSERT INTO `models` (`id`, `name`, `local_name`, `created_by`) VALUES
(13, 'Teste modelo 02', 'testemodelo02', 'Lucas Gabriel Peixoto de Oliveira'),
(14, 'Modelo 03', 'modelo03', 'Lucas Gabriel Peixoto de Oliveira'),
(15, 'modelo 45', 'modelo45', 'Lucas Gabriel Peixoto de Oliveira');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `registration` int(11) NOT NULL,
  `password` text NOT NULL,
  `organ` int(11) NOT NULL,
  `email` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `name`, `registration`, `password`, `organ`, `email`, `created_at`) VALUES
(1, 'Lucas Gabriel Peixoto de Oliveira', 123, '123', 1, 'lucasgabrielpdoliveira@gmail.com', '2020-04-06 21:10:36');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `fields`
--
ALTER TABLE `fields`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `metadata`
--
ALTER TABLE `metadata`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `models`
--
ALTER TABLE `models`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `fields`
--
ALTER TABLE `fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de tabela `metadata`
--
ALTER TABLE `metadata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `models`
--
ALTER TABLE `models`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
