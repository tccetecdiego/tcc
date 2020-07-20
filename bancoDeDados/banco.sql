-- --------------------------------------------------------
-- Servidor:                     localhost
-- Versão do servidor:           5.1.72-community - MySQL Community Server (GPL)
-- OS do Servidor:               Win32
-- HeidiSQL Versão:              9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Copiando estrutura do banco de dados para tcc
CREATE DATABASE IF NOT EXISTS `tcc` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `tcc`;

-- Copiando estrutura para procedure tcc.alterar
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `alterar`(
	IN `pId` INT,
	IN `pNome` VARCHAR(50),
	IN `pQuantidade` INT,
	IN `pMinQuantidade` INT,
	IN `pPreco` DECIMAL(10,2)






)
BEGIN

	declare a int;
	declare b int;
	declare c int;
	declare d bool;
	
	SELECT count(*) into a FROM item WHERE nome = pNome and id = pId;
	if a = 1 then
		set d = true;
	else
		SELECT count(*) into a FROM item WHERE nome = pNome;
		if a = 1 then
			set d = false;
		else
			set d = true;
		end if;
	end if;
	
	
	if d = true then	
		SELECT count(*) into b FROM item WHERE nome= pNome and quantidade = pQuantidade and minQuantidade = pMinQuantidade and preco = pPreco and id = pId;
	   if b = 0 then
	   	UPDATE item SET nome= pNome, quantidade = pQuantidade, minQuantidade = pMinQuantidade, preco = pPreco WHERE id = pId;
	   	SELECT count(*) into c FROM item WHERE nome= pNome and quantidade = pQuantidade and minQuantidade = pMinQuantidade and preco = pPreco and id = pId;
	   	if c = 1 then				   
				select 'alterado com sucesso' as mensagem;
			else
				select 'valores invalidos' as mensagem;		
			end if;		
		else
			select 'valores iguais' as mensagem;
		end if;
	else
		select 'Nome ja usado' as mensagem;
	end if;

END//
DELIMITER ;

-- Copiando estrutura para procedure tcc.cadastrar
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `cadastrar`(
	IN `pNome` VARCHAR(50),
	IN `pQuantidade` INT,
	IN `pMinQuantidade` INT,
	IN `pPreco` DECIMAL(10,2)


)
BEGIN

declare a int;
declare b int;

SELECT count(*) into a FROM item WHERE nome = pNome;

if a = 0 then
	INSERT INTO item(nome, quantidade, minQuantidade, preco) 
   VALUES(pNome,pQuantidade,pMinQuantidade,pPreco);
   SELECT count(*) into b FROM item WHERE nome = pNome;
   if b = 1 then
		select 'cadastrado com sucesso' as mensagem;
	
	else
		select 'valores invalido' as mensagem;
	end if;
else
	select 'produto ja cadastrado' as mensagem;
end if;

END//
DELIMITER ;

-- Copiando estrutura para tabela tcc.deletados
CREATE TABLE IF NOT EXISTS `deletados` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `minQuantidade` int(11) DEFAULT NULL,
  `preco` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela tcc.historico
CREATE TABLE IF NOT EXISTS `historico` (
  `item_id` int(11) DEFAULT NULL,
  `data` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.
-- Copiando estrutura para tabela tcc.item
CREATE TABLE IF NOT EXISTS `item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `minQuantidade` int(11) DEFAULT NULL,
  `preco` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Exportação de dados foi desmarcado.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
