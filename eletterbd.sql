-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 20-Abr-2020 às 17:11
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
-- Estrutura da tabela `cards`
--

CREATE TABLE `cards` (
  `id` int(11) NOT NULL,
  `card_lot` int(11) NOT NULL DEFAULT 0,
  `model_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `receiver_name` text NOT NULL,
  `receiver_street` text NOT NULL,
  `receiver_city` text NOT NULL,
  `receiver_state` text NOT NULL,
  `receiver_postcode` int(11) NOT NULL,
  `receiver_neighborhood` text NOT NULL,
  `receiver_number_address` int(11) NOT NULL,
  `receiver_complement` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cards_fields`
--

CREATE TABLE `cards_fields` (
  `id` int(11) NOT NULL,
  `id_card` int(11) NOT NULL,
  `name_metadata` text NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `cards_fields`
--

INSERT INTO `cards_fields` (`id`, `id_card`, `name_metadata`, `value`) VALUES
(1, 1, 'nomeContribuinte', 'Giovanni'),
(2, 1, 'cpfContribuinte', '123'),
(3, 1, 'inscricaoImovel', '123'),
(4, 1, 'enderecoLogadouro', 'Gustavo Paiva'),
(5, 1, 'enderecoNumero', '123'),
(6, 1, 'enderecoCondominio', '123'),
(7, 1, 'enderecoComplemento', '123'),
(8, 1, 'enderecoBairro', '123'),
(9, 1, 'enderecoCep', '5710000'),
(10, 1, 'telefoneContribuinte', '123'),
(11, 1, 'enderecoLoteamento', '123'),
(12, 1, 'enderecoQuadra', '123'),
(13, 1, 'enderecoLote', '123'),
(14, 1, 'modelId', '25'),
(15, 2, 'nomeContribuinte', '123'),
(16, 2, 'cpfContribuinte', '123'),
(17, 2, 'inscricaoImovel', '123'),
(18, 2, 'enderecoLogadouro', '123'),
(19, 2, 'enderecoNumero', '123'),
(20, 2, 'enderecoCondominio', '123'),
(21, 2, 'enderecoComplemento', '123'),
(22, 2, 'enderecoBairro', '123'),
(23, 2, 'enderecoCep', '123'),
(24, 2, 'telefoneContribuinte', '123'),
(25, 2, 'enderecoLoteamento', '123'),
(26, 2, 'enderecoQuadra', '123'),
(27, 2, 'enderecoLote', '123'),
(28, 2, 'modelId', '25');

-- --------------------------------------------------------

--
-- Estrutura da tabela `lots`
--

CREATE TABLE `lots` (
  `id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `metadata`
--

CREATE TABLE `metadata` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `label_name` text NOT NULL,
  `description` text NOT NULL,
  `type` text NOT NULL,
  `required` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `metadata_fields`
--

CREATE TABLE `metadata_fields` (
  `id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `metadata_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `cards_fields`
--
ALTER TABLE `cards_fields`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `lots`
--
ALTER TABLE `lots`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `metadata`
--
ALTER TABLE `metadata`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `metadata_fields`
--
ALTER TABLE `metadata_fields`
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
-- AUTO_INCREMENT de tabela `cards`
--
ALTER TABLE `cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `cards_fields`
--
ALTER TABLE `cards_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de tabela `lots`
--
ALTER TABLE `lots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `metadata`
--
ALTER TABLE `metadata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `metadata_fields`
--
ALTER TABLE `metadata_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `models`
--
ALTER TABLE `models`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
