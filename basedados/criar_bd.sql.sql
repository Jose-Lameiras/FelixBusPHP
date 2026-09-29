-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 08-Maio-2019 às 18:48
-- Versão do servidor: 10.1.37-MariaDB
-- versão do PHP: 7.3.1


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `felixbus`
--  
 
 CREATE DATABASE felixbus;

 USE felixbus;


--
-- Estrutura da tabela `alertas`
--

CREATE TABLE `alertas` (
  `id_alerta` int(11) NOT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `mensagem` text DEFAULT NULL,
  `data_inicio` date DEFAULT NULL,
  `data_fim` date DEFAULT NULL,
  `ativo` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `bilhetes`
--

CREATE TABLE `bilhetes` (
  `id_bilhete` int(11) NOT NULL,
  `id_utilizador` int(11) NOT NULL,
  `id_horario` int(11) NOT NULL,
  `data_compra` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `carteira`
--

CREATE TABLE `carteira` (
  `id_carteira` int(11) NOT NULL,
  `id_utilizador` int(11) NOT NULL,
  `saldo` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `carteira`
--

INSERT INTO `carteira` (`id_carteira`, `id_utilizador`, `saldo`) VALUES
(100,100,0.0),
(1, 1, 256.6),
(2, 2, 400),
(3, 3, 600),
(4, 4, 99963.4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `carteira_felixbus`
--

CREATE TABLE `carteira_felixbus` (
  `id` int(11) NOT NULL,
  `id_utilizador` int(11) DEFAULT NULL,
  `operacao` varchar(20) DEFAULT NULL,
  `valor` int(11) DEFAULT NULL,
  `data_operacao` datetime DEFAULT NULL,
  `carteira_origem` int(11) DEFAULT NULL,
  `carteira_destino` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `carteira_felixbus`
--

INSERT INTO `carteira_felixbus` (`id`, `id_utilizador`, `operacao`, `valor`, `data_operacao`, `carteira_origem`, `carteira_destino`) VALUES
(1, 4, 'compra_bilhete', 26, '2025-06-16 01:47:15', NULL, NULL),
(2, 4, 'compra_bilhete', 26, '2025-06-16 01:49:45', NULL, NULL),
(3, 4, 'compra_bilhete', 8, '2025-06-16 01:54:44', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `cidades`
--

CREATE TABLE `cidades` (
  `id_cidade` int(11) NOT NULL,
  `nome_cidade` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `cidades`
--

INSERT INTO `cidades` (`id_cidade`, `nome_cidade`) VALUES
(1, 'Castelo Branco'),
(2, 'Leiria'),
(3, 'Lisboa'),
(4, 'Porto'),
(5, 'Aveiro'),
(6, 'Beja'),
(7, 'Braga'),
(8, 'Bragança'),
(9, 'Coimbra'),
(10, 'Évora'),
(11, 'Faro'),
(12, 'Guarda'),
(13, 'Portalegre'),
(14, 'Santarém'),
(15, 'Setúbal'),
(16, 'Viana do Castelo'),
(17, 'Vila Real'),
(18, 'Viseu');

-- --------------------------------------------------------

--
-- Estrutura da tabela `horarios`
--

CREATE TABLE `horarios` (
  `id_horario` int(11) NOT NULL,
  `id_rota` int(11) NOT NULL,
  `data` date NOT NULL,
  `hora_partida` time NOT NULL,
  `hora_chegada` time NOT NULL,
  `lugares_disponiveis` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `horarios`
--

INSERT INTO `horarios` (`id_horario`, `id_rota`, `data`, `hora_partida`, `hora_chegada`, `lugares_disponiveis`) VALUES

(136, 23, '2025-06-25', '08:00:00', '09:30:00', 50),
(137, 23, '2025-06-26', '08:00:00', '09:30:00', 50),
(138, 24, '2025-06-25', '10:00:00', '11:30:00', 50),
(139, 24, '2025-06-26', '10:00:00', '11:30:00', 50),
(140, 25, '2025-06-25', '07:00:00', '08:15:00', 50),
(141, 25, '2025-06-26', '07:00:00', '08:15:00', 50),
(142, 26, '2025-06-25', '18:00:00', '19:15:00', 50),
(143, 26, '2025-06-26', '18:00:00', '19:15:00', 50);
-- --------------------------------------------------------

--
-- Estrutura da tabela `rotas`
--

CREATE TABLE `rotas` (
  `id_rota` int(11) NOT NULL,
  `id_origem` int(11) NOT NULL,
  `id_destino` int(11) NOT NULL,
  `preco` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `rotas`
--

INSERT INTO `rotas` (`id_rota`, `id_origem`, `id_destino`, `preco`) VALUES
(23, 1, 2, 10.00),   -- Castelo Branco -> Leiria
(24, 2, 1, 10.00),   -- Leiria -> Castelo Branco
(25, 6, 10, 12.50),  -- Beja -> Évora
(26, 10, 6, 12.50);  -- Évora -> Beja


-- --------------------------------------------------------

--
-- Estrutura da tabela `tipoutilizador`
--

CREATE TABLE `tipoutilizador` (
  `id_Tipo` int(2) NOT NULL,
  `descricao` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `tipoutilizador`
--

INSERT INTO `tipoutilizador` (`id_Tipo`, `descricao`) VALUES
(1, 'admin'),
(2, 'cliente'),
(3, 'cliente nao validado'),
(4, 'funcionario'),
(6, 'Utilizador apagado');

-- --------------------------------------------------------

--
-- Estrutura da tabela `utilizador`
--

CREATE TABLE `utilizador` (
  `id_utilizador` int(11) NOT NULL,
  `nomeUtilizador` varchar(40) NOT NULL,
  `mail` varchar(40) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `telemovel` int(9) NOT NULL,
  `tipoUtilizador` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Extraindo dados da tabela `utilizador`
--

INSERT INTO `utilizador` (`id_utilizador`, `nomeUtilizador`, `mail`, `pass`, `telemovel`, `tipoUtilizador`) VALUES
(100, 'felixbus', 'felix@felixbus.pt', '25779f8829ab7a7650e85a4cc871e6ac', 999999999, 1),
(1, 'admin', 'admin@felixbus.pt', '21232f297a57a5a743894a0e4a801fc3', 911111111, 1),
(2, 'gestor', 'gestor@felixbus.pt', 'a55607442fca264cf37e935503d646c2', 922222222, 4),
(3, 'jose', 'jose@felixbus.pt', '662eaa47199461d01a623884080934ab', 912665710, 2),
(4, 'diogo', 'diogo@felixbus.pt', 'a25338e5f1f01444325198d3e767923c', 925676015, 2);

--
-- Acionadores `utilizador`
--
DELIMITER $$
CREATE TRIGGER `after_utilizador_insert` AFTER INSERT ON `utilizador` FOR EACH ROW BEGIN
  -- Só cria carteira se tipoUtilizador for diferente de 3
  IF NEW.tipoUtilizador <> 3 THEN
    -- Só cria se não existir carteira para este utilizador
    IF NOT EXISTS (SELECT 1 FROM carteira WHERE id_utilizador = NEW.id_utilizador) THEN
      INSERT INTO carteira (id_utilizador, saldo) VALUES (NEW.id_utilizador, 0);
    END IF;
  END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_utilizador_update` AFTER UPDATE ON `utilizador` FOR EACH ROW BEGIN
  -- Só cria carteira se tipoUtilizador for diferente de 3
  IF NEW.tipoUtilizador <> 3 THEN
    -- Só cria se não existir carteira para este utilizador
    IF NOT EXISTS (SELECT 1 FROM carteira WHERE id_utilizador = NEW.id_utilizador) THEN
      INSERT INTO carteira (id_utilizador, saldo) VALUES (NEW.id_utilizador, 0);
    END IF;
  END IF;
END
$$
DELIMITER ;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `alertas`
--
ALTER TABLE `alertas`
  ADD PRIMARY KEY (`id_alerta`);

--
-- Índices para tabela `bilhetes`
--
ALTER TABLE `bilhetes`
  ADD PRIMARY KEY (`id_bilhete`),
  ADD KEY `id_utilizador` (`id_utilizador`),
  ADD KEY `fk_bilhetes_horarios` (`id_horario`);

--
-- Índices para tabela `carteira`
--
ALTER TABLE `carteira`
  ADD PRIMARY KEY (`id_carteira`),
  ADD UNIQUE KEY `id_utilizador` (`id_utilizador`);

--
-- Índices para tabela `carteira_felixbus`
--
ALTER TABLE `carteira_felixbus`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `cidades`
--
ALTER TABLE `cidades`
  ADD PRIMARY KEY (`id_cidade`);

--
-- Índices para tabela `horarios`
--
ALTER TABLE `horarios`
  ADD PRIMARY KEY (`id_horario`),
  ADD KEY `id_rota` (`id_rota`);

--
-- Índices para tabela `rotas`
--
ALTER TABLE `rotas`
  ADD PRIMARY KEY (`id_rota`),
  ADD KEY `id_origem` (`id_origem`),
  ADD KEY `id_destino` (`id_destino`);

--
-- Índices para tabela `tipoutilizador`
--
ALTER TABLE `tipoutilizador`
  ADD PRIMARY KEY (`id_Tipo`),
  ADD UNIQUE KEY `descricao` (`descricao`),
  ADD KEY `descricao_2` (`descricao`),
  ADD KEY `descricao_3` (`descricao`);

--
-- Índices para tabela `utilizador`
--
ALTER TABLE `utilizador`
  ADD PRIMARY KEY (`id_utilizador`),
  ADD UNIQUE KEY `mail` (`mail`),
  ADD KEY `tipoUtilizador` (`tipoUtilizador`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `alertas`
--
ALTER TABLE `alertas`
  MODIFY `id_alerta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `bilhetes`
--
ALTER TABLE `bilhetes`
  MODIFY `id_bilhete` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `carteira`
--
ALTER TABLE `carteira`
  MODIFY `id_carteira` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `carteira_felixbus`
--
ALTER TABLE `carteira_felixbus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `cidades`
--
ALTER TABLE `cidades`
  MODIFY `id_cidade` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `horarios`
--
ALTER TABLE `horarios`
  MODIFY `id_horario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT de tabela `rotas`
--
ALTER TABLE `rotas`
  MODIFY `id_rota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT de tabela `tipoutilizador`
--
ALTER TABLE `tipoutilizador`
  MODIFY `id_Tipo` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `utilizador`
--
ALTER TABLE `utilizador`
  MODIFY `id_utilizador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `bilhetes`
--
ALTER TABLE `bilhetes`
  ADD CONSTRAINT `bilhetes_ibfk_1` FOREIGN KEY (`id_utilizador`) REFERENCES `utilizador` (`id_utilizador`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_bilhetes_horarios` FOREIGN KEY (`id_horario`) REFERENCES `horarios` (`id_horario`);

--
-- Limitadores para a tabela `carteira`
--
ALTER TABLE `carteira`
  ADD CONSTRAINT `carteira_ibfk_1` FOREIGN KEY (`id_utilizador`) REFERENCES `utilizador` (`id_utilizador`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `horarios`
--
ALTER TABLE `horarios`
  ADD CONSTRAINT `horarios_ibfk_1` FOREIGN KEY (`id_rota`) REFERENCES `rotas` (`id_rota`);

--
-- Limitadores para a tabela `rotas`
--
ALTER TABLE `rotas`
  ADD CONSTRAINT `rotas_ibfk_1` FOREIGN KEY (`id_origem`) REFERENCES `cidades` (`id_cidade`),
  ADD CONSTRAINT `rotas_ibfk_2` FOREIGN KEY (`id_destino`) REFERENCES `cidades` (`id_cidade`);

--
-- Limitadores para a tabela `utilizador`
--
ALTER TABLE `utilizador`
  ADD CONSTRAINT `tipo` FOREIGN KEY (`tipoUtilizador`) REFERENCES `tipoutilizador` (`id_Tipo`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
