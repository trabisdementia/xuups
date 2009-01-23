<?php

/**
* $Id: smartdbupdater.php 2635 2008-06-03 20:46:47Z gibaphp $
* Module: SmartContent
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/
if (!defined("XOOPS_ROOT_PATH")) {
 	die("O caminho raiz de seu Site não está definido");
}

define("_SDU_IMPORT", "Importar");
define("_SDU_CURRENTVER", "Versão Atual: <span class='currentVer'>%s</span>");
define("_SDU_DBVER", "Versão do Banco de Dados %s");
define("_SDU_MSG_ADD_DATA", "Os dados adicionados na tabela %s");
define("_SDU_MSG_ADD_DATA_ERR", "Erro - enquanto adicionava dados na tabela %s");
define("_SDU_MSG_CHGFIELD", "Alterando campo %s na tabela %s");
define("_SDU_MSG_CHGFIELD_ERR", "Erro - Alterando campo %s na tabela %s");
define("_SDU_MSG_CREATE_TABLE", "Tabela %s criada");
define("_SDU_MSG_CREATE_TABLE_ERR", "Erro - criando tabela %s");
define("_SDU_MSG_NEWFIELD", "Campos adicionados com sucesso %s");
define("_SDU_MSG_NEWFIELD_ERR", "Erro - enquando adicionava campo %s");
define("_SDU_NEEDUPDATE", "Seu banco de dado está desatualizado. Atualizar o seu banco de dados e tabelas!<br><b>Note : O SmartFactory recomenda que você faça um backup de todas as tabelas do Publisher antes de rodar este script de atualização. Caso não faça isto, vá por sua conta e risco e boa sorte.</b><br>");
define("_SDU_NOUPDATE", "Seu banco de dados está atualizado. Não é necessário fazer atualizações.");
define("_SDU_UPDATE_DB", "Atualizando seu banco de dados");
define("_SDU_UPDATE_ERR", "Erro - Enquando atualizava a versão %s");
define("_SDU_UPDATE_NOW", "Atualizar Agora!");
define("_SDU_UPDATE_OK", "Atualização foi concluida com Sucesso para a versão %s");
define("_SDU_UPDATE_TO", "Atualizando a versão %s");
define("_SDU_UPDATE_UPDATING_DATABASE", "Atualizando o banco de dados...");


?>