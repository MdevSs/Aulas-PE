-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 10/09/2024 às 06:21
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

-- --------------------------------------------------------

--
-- Estrutura para tabela `autor`
--

CREATE TABLE `autor` (
  `codigo` int(11) NOT NULL,
  `nome` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `autor`
--

INSERT INTO `autor` (`codigo`, `nome`) VALUES
(1, 'Machado de Assis'),
(2, 'George Lucas'),
(3, 'Franz Kafka'),
(4, 'Carlos Drummond de Andrade'),
(5, 'Keanu Reeves'),
(6, 'Tony Stark');

-- --------------------------------------------------------

--
-- Estrutura para tabela `avaliacao`
--

CREATE TABLE `avaliacao` (
  `AVAIP` varchar(30) NOT NULL,
  `AVAOBRA` int(11) NOT NULL,
  `AVANOTA` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `avaliacao`
--

INSERT INTO `avaliacao` (`AVAIP`, `AVAOBRA`, `AVANOTA`) VALUES
('127.0.0.1', 1, 3),
('127.0.0.1', 3, 4),
('127.0.0.1', 4, 3),
('127.0.0.1', 5, 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `categoria`
--

CREATE TABLE `categoria` (
  `codigo` int(11) NOT NULL,
  `nome` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `categoria`
--

INSERT INTO `categoria` (`codigo`, `nome`) VALUES
(1, 'Livro'),
(2, 'Revista'),
(3, 'Jornal');

-- --------------------------------------------------------

--
-- Estrutura para tabela `editora`
--

CREATE TABLE `editora` (
  `codigo` int(11) NOT NULL,
  `nome` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `editora`
--

INSERT INTO `editora` (`codigo`, `nome`) VALUES
(1, 'Nova'),
(2, 'Star'),
(3, 'World'),
(4, 'Legend'),
(5, 'Marvel'),
(6, 'DC');

-- --------------------------------------------------------

--
-- Estrutura para tabela `emprestimo`
--

CREATE TABLE `emprestimo` (
  `codigo` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  `acervo` int(11) NOT NULL,
  `datainicio` date NOT NULL,
  `datafim` date NOT NULL,
  `entregue` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `emprestimo`
--

INSERT INTO `emprestimo` (`codigo`, `usuario`, `acervo`, `datainicio`, `datafim`, `entregue`) VALUES
(1, 1, 1, '2024-07-31', '2024-12-31', '2024-12-30'),
(2, 2, 3, '2024-08-12', '2024-09-19', NULL),
(3, 1, 1, '2024-08-16', '2024-09-16', NULL),
(4, 2, 4, '2024-08-13', '2024-08-31', '2024-09-17'),
(5, 1, 1, '2024-08-12', '2024-09-18', '2024-10-16'),
(6, 3, 5, '2024-08-13', '2024-09-13', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `endereco`
--

CREATE TABLE `endereco` (
  `codigo` int(11) NOT NULL,
  `logradouro` text NOT NULL,
  `numero` text NOT NULL,
  `bairro` text NOT NULL,
  `cidade` text NOT NULL,
  `estado` text NOT NULL,
  `usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `genero`
--

CREATE TABLE `genero` (
  `codigo` int(11) NOT NULL,
  `nome` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `genero`
--

INSERT INTO `genero` (`codigo`, `nome`) VALUES
(1, 'Ação'),
(2, 'Ciencia'),
(3, 'Futurista'),
(4, 'Antigo'),
(5, 'Comedia'),
(6, 'Romance'),
(7, 'Narrativo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `telefone`
--

CREATE TABLE `telefone` (
  `codigo` int(11) NOT NULL,
  `prefixo` int(11) NOT NULL,
  `ddd` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `codigo` int(11) NOT NULL,
  `acesso` enum('0','1') NOT NULL DEFAULT '0',
  `nome` text NOT NULL,
  `senha` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`codigo`, `acesso`, `nome`, `senha`) VALUES
(1, '0', 'Juan', '81b17e8d050c3770b011d1a79124488d'),
(2, '0', 'Keanu Reeves', '51757a1351a9e7b68efe7ac2c7e880c5'),
(3, '0', 'José', '1a5e9b272e3e1f9904485b93e7a34aa5'),
(4, '0', 'Juca', '7b5a67574d8b1d77d2803b24946950f0'),
(5, '1', 'adm', 'b09c600fddc573f117449b3723f23d64'),
(6, '0', 'Alguem', '202cb962ac59075b964b07152d234b70');

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
-- Índices de tabela `autor`
--
ALTER TABLE `autor`
  ADD PRIMARY KEY (`codigo`),
  ADD UNIQUE KEY `nome` (`nome`) USING HASH;

--
-- Índices de tabela `avaliacao`
--
ALTER TABLE `avaliacao`
  ADD PRIMARY KEY (`AVAIP`,`AVAOBRA`) USING BTREE;

--
-- Índices de tabela `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`codigo`);

--
-- Índices de tabela `editora`
--
ALTER TABLE `editora`
  ADD PRIMARY KEY (`codigo`),
  ADD UNIQUE KEY `nome` (`nome`) USING HASH,
  ADD UNIQUE KEY `nome_2` (`nome`) USING HASH;

--
-- Índices de tabela `emprestimo`
--
ALTER TABLE `emprestimo`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `acervo` (`acervo`),
  ADD KEY `usuario` (`usuario`);

--
-- Índices de tabela `endereco`
--
ALTER TABLE `endereco`
  ADD PRIMARY KEY (`codigo`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `endereco_ibfk_1` (`usuario`);

--
-- Índices de tabela `genero`
--
ALTER TABLE `genero`
  ADD PRIMARY KEY (`codigo`);

--
-- Índices de tabela `telefone`
--
ALTER TABLE `telefone`
  ADD PRIMARY KEY (`codigo`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `telefone_ibfk_1` (`usuario`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`codigo`),
  ADD UNIQUE KEY `nome` (`nome`(768)) USING BTREE;

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `acervo`
--
ALTER TABLE `acervo`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de tabela `autor`
--
ALTER TABLE `autor`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `categoria`
--
ALTER TABLE `categoria`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `editora`
--
ALTER TABLE `editora`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `emprestimo`
--
ALTER TABLE `emprestimo`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `genero`
--
ALTER TABLE `genero`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `telefone`
--
ALTER TABLE `telefone`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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

--
-- Restrições para tabelas `emprestimo`
--
ALTER TABLE `emprestimo`
  ADD CONSTRAINT `emprestimo_ibfk_1` FOREIGN KEY (`acervo`) REFERENCES `acervo` (`codigo`),
  ADD CONSTRAINT `emprestimo_ibfk_2` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`codigo`);

--
-- Restrições para tabelas `endereco`
--
ALTER TABLE `endereco`
  ADD CONSTRAINT `endereco_ibfk_1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`codigo`);

--
-- Restrições para tabelas `telefone`
--
ALTER TABLE `telefone`
  ADD CONSTRAINT `telefone_ibfk_1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`codigo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
