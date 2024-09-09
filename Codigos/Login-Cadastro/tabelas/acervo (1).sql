-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 09/09/2024 às 05:55
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
-- Banco de dados: `biblioteca`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `acervo`
--

CREATE TABLE `acervo` (
  `codigo` int(11) NOT NULL,
  `nome` text NOT NULL,
  `categoria` int(11) NOT NULL,
  `autor` int(11) NOT NULL,
  `editora` int(11) NOT NULL,
  `genero` int(11) NOT NULL,
  `sinopse` varchar(3000) DEFAULT 'Sem sinopse',
  `imagem` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `acervo`
--

INSERT INTO `acervo` (`codigo`, `nome`, `categoria`, `autor`, `editora`, `genero`, `sinopse`, `imagem`) VALUES
(1, 'Não seja um idiota 1', 1, 1, 1, 1, 'Sem sinopse', ' ../../img/favicon.ico'),
(2, 'Não seja um idiota 2', 1, 2, 6, 4, 'Sem sinopse', ' ../../img/favicon.ico'),
(3, 'Não seja um idiota 3', 1, 2, 6, 2, 'Sem sinopse', ' ../../img/favicon.ico'),
(4, 'Não Seja um Idiota 4', 1, 4, 4, 5, 'Sem sinopse', ' ../../img/favicon.ico'),
(5, 'Não seja um idiota 5', 1, 6, 5, 4, 'Sem sinopse', ' ../../img/favicon.ico');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `acervo`
--
ALTER TABLE `acervo`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `categoria` (`categoria`),
  ADD KEY `autor` (`autor`),
  ADD KEY `editora` (`editora`),
  ADD KEY `genero` (`genero`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `acervo`
--
ALTER TABLE `acervo`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `acervo`
--
ALTER TABLE `acervo`
  ADD CONSTRAINT `acervo_ibfk_1` FOREIGN KEY (`categoria`) REFERENCES `categoria` (`codigo`),
  ADD CONSTRAINT `acervo_ibfk_2` FOREIGN KEY (`autor`) REFERENCES `autor` (`codigo`),
  ADD CONSTRAINT `acervo_ibfk_3` FOREIGN KEY (`editora`) REFERENCES `editora` (`codigo`),
  ADD CONSTRAINT `acervo_ibfk_4` FOREIGN KEY (`genero`) REFERENCES `genero` (`codigo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
