-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           5.7.31 - MySQL Community Server (GPL)
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Copiando estrutura do banco de dados para sigchamados
CREATE DATABASE IF NOT EXISTS `sigchamados` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `sigchamados`;

-- Copiando estrutura para tabela sigchamados.chamados
CREATE TABLE IF NOT EXISTS `chamados` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `usuarios_id` int(10) NOT NULL,
  `descricao` text NOT NULL,
  `solucao` text,
  `status` char(1) NOT NULL DEFAULT '0',
  `dtains` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dtaalt` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `usuarios_id` (`usuarios_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela sigchamados.chamados: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `chamados` DISABLE KEYS */;
/*!40000 ALTER TABLE `chamados` ENABLE KEYS */;

-- Copiando estrutura para tabela sigchamados.comentarios_chamados
CREATE TABLE IF NOT EXISTS `comentarios_chamados` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `comentario` varchar(200) NOT NULL,
  `chamados_id` int(10) NOT NULL,
  `usuarios_id` int(10) NOT NULL,
  `dtains` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `chamados_id` (`chamados_id`),
  KEY `usuarios_id` (`usuarios_id`),
  CONSTRAINT `FK_comentarios_chamados_chamados` FOREIGN KEY (`chamados_id`) REFERENCES `chamados` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_comentarios_chamados_usuarios` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela sigchamados.comentarios_chamados: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `comentarios_chamados` DISABLE KEYS */;
/*!40000 ALTER TABLE `comentarios_chamados` ENABLE KEYS */;

-- Copiando estrutura para tabela sigchamados.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `admin` char(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela sigchamados.usuarios: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
