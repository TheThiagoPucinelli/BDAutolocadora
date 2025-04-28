-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 28/04/2025 às 06:55
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
-- Banco de dados: `bdautolocadora`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbcliente`
--

CREATE TABLE `tbcliente` (
  `cliente_cpf` char(11) NOT NULL,
  `cliente_nome` varchar(100) DEFAULT NULL,
  `cliente_endereco` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `tbcliente`
--

INSERT INTO `tbcliente` (`cliente_cpf`, `cliente_nome`, `cliente_endereco`) VALUES
('2454425325', 'ROGER', 'Vila princesa'),
('5325235', 'Thiago', 'SANGA FUNDA TESTE1');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tblocacao`
--

CREATE TABLE `tblocacao` (
  `locacao_codigo` int(11) NOT NULL,
  `locacao_veiculo` varchar(7) DEFAULT NULL,
  `locacao_cliente` char(11) DEFAULT NULL,
  `locacao_data_inicio` date DEFAULT NULL,
  `locacao_data_fim` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `tblocacao`
--

INSERT INTO `tblocacao` (`locacao_codigo`, `locacao_veiculo`, `locacao_cliente`, `locacao_data_inicio`, `locacao_data_fim`) VALUES
(5, '256RE', '5325235', '2025-04-15', '2025-04-28'),
(6, '256RE', '2454425325', '2025-04-28', '2025-05-14');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbmarca`
--

CREATE TABLE `tbmarca` (
  `marca_codigo` int(11) NOT NULL,
  `marca_descricao` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `tbmarca`
--

INSERT INTO `tbmarca` (`marca_codigo`, `marca_descricao`) VALUES
(1, 'astom');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbveiculo`
--

CREATE TABLE `tbveiculo` (
  `veiculo_placa` varchar(7) NOT NULL,
  `veiculo_marca` int(11) DEFAULT NULL,
  `veiculo_descricao` varchar(100) DEFAULT NULL,
  `veiculo_status` enum('disponível','locado') NOT NULL DEFAULT 'disponível'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `tbveiculo`
--

INSERT INTO `tbveiculo` (`veiculo_placa`, `veiculo_marca`, `veiculo_descricao`, `veiculo_status`) VALUES
('256RE', 1, 'Vanquish', 'disponível');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `tbcliente`
--
ALTER TABLE `tbcliente`
  ADD PRIMARY KEY (`cliente_cpf`);

--
-- Índices de tabela `tblocacao`
--
ALTER TABLE `tblocacao`
  ADD PRIMARY KEY (`locacao_codigo`),
  ADD KEY `FK_tbLocacao_1` (`locacao_cliente`),
  ADD KEY `locacao_veiculo` (`locacao_veiculo`),
  ADD KEY `locacao_data_fim` (`locacao_data_fim`);

--
-- Índices de tabela `tbmarca`
--
ALTER TABLE `tbmarca`
  ADD PRIMARY KEY (`marca_codigo`);

--
-- Índices de tabela `tbveiculo`
--
ALTER TABLE `tbveiculo`
  ADD PRIMARY KEY (`veiculo_placa`),
  ADD KEY `FK_tbVeiculo_1` (`veiculo_marca`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tblocacao`
--
ALTER TABLE `tblocacao`
  MODIFY `locacao_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `tbmarca`
--
ALTER TABLE `tbmarca`
  MODIFY `marca_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `tblocacao`
--
ALTER TABLE `tblocacao`
  ADD CONSTRAINT `FK_tbLocacao_1` FOREIGN KEY (`locacao_cliente`) REFERENCES `tbcliente` (`cliente_cpf`),
  ADD CONSTRAINT `tblocacao_ibfk_2` FOREIGN KEY (`locacao_veiculo`) REFERENCES `tbveiculo` (`veiculo_placa`);

--
-- Restrições para tabelas `tbveiculo`
--
ALTER TABLE `tbveiculo`
  ADD CONSTRAINT `FK_tbVeiculo_1` FOREIGN KEY (`veiculo_marca`) REFERENCES `tbmarca` (`marca_codigo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
