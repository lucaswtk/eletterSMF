-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 29-Mar-2020 às 06:01
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
-- Banco de dados: `bdcarta`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cards`
--

CREATE TABLE `cards` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `card_lot` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created` timestamp NULL DEFAULT current_timestamp(),
  `model` int(11) NOT NULL,
  `receiver_name` varchar(45) DEFAULT NULL,
  `receiver_address` varchar(200) DEFAULT NULL,
  `receiver_city` varchar(30) DEFAULT NULL,
  `state` varchar(2) DEFAULT NULL,
  `postcode` int(10) DEFAULT NULL,
  `neighborhood` varchar(20) DEFAULT NULL,
  `number_address` varchar(4) DEFAULT NULL,
  `complement` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `cards`
--

INSERT INTO `cards` (`id`, `user`, `card_lot`, `status`, `created`, `model`, `receiver_name`, `receiver_address`, `receiver_city`, `state`, `postcode`, `neighborhood`, `number_address`, `complement`) VALUES
(28, 3, 1, 0, '2019-12-18 12:10:03', 1, 'Lucas Gabriel', 'Rua Doutor Batista Aciole', 'Rio Largo', 'AL', 57100000, 'Centro', '294', 'SC'),
(29, 3, 1, 0, '2019-12-18 12:13:48', 1, 'teste', 'teste', 'teste', 'MG', 123, 'teste', '123', 'teste');

-- --------------------------------------------------------

--
-- Estrutura da tabela `lot`
--

CREATE TABLE `lot` (
  `id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `lot`
--

INSERT INTO `lot` (`id`, `status`, `created`) VALUES
(1, 0, '2019-12-18 12:10:03');

-- --------------------------------------------------------

--
-- Estrutura da tabela `model1`
--

CREATE TABLE `model1` (
  `id` int(11) NOT NULL,
  `contributor` text NOT NULL,
  `cpf` int(11) NOT NULL,
  `proprety_registration` text NOT NULL,
  `street` text NOT NULL,
  `number` int(11) NOT NULL,
  `condominium` text NOT NULL,
  `complement` text NOT NULL,
  `neighborhood` text NOT NULL,
  `postcode` int(11) NOT NULL,
  `telephone` int(11) NOT NULL,
  `allotment` text NOT NULL,
  `block` int(11) NOT NULL,
  `lot` text NOT NULL,
  `registered_area` float NOT NULL,
  `real_area` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `model1`
--

INSERT INTO `model1` (`id`, `contributor`, `cpf`, `proprety_registration`, `street`, `number`, `condominium`, `complement`, `neighborhood`, `postcode`, `telephone`, `allotment`, `block`, `lot`, `registered_area`, `real_area`) VALUES
(28, 'Giovanni Oliver', 2147483647, '194203', 'Gustavo Paiva', 152, 'Recanto das flores', 'SC', 'Centro', 57100000, 2147483647, 'Vila Rica', 12, '1', 23.12, 41.97),
(29, 'teste', 123, '123', 'teste', 123, 'teste', 'teste', 'teste', 123, 123, 'teste', 123, '1', 123.13, 123.12);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `registration` int(24) NOT NULL,
  `password` varchar(24) NOT NULL,
  `organ` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `name`, `registration`, `password`, `organ`) VALUES
(3, 'Lucas Gabriel Peixoto de Oliveira', 123, '123', 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `lot`
--
ALTER TABLE `lot`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `model1`
--
ALTER TABLE `model1`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de tabela `lot`
--
ALTER TABLE `lot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
