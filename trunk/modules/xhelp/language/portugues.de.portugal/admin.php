<?php
//traduzido por Silviotech - www.santoxoops.com.br / www.xoops.pr.gov.br
//adaptado para portugues de portugal por _Vlad_

//Menu choices
define('_AM_XHELP_ADMIN_TITLE', 'Menu de Administra��o do Xhelp');
define('_AM_XHELP_BLOCK_TEXT', 'Administrar Blocos');
define('_AM_XHELP_MENU_MANAGE_DEPARTMENTS', 'Administrar Departamentos');
define('_AM_XHELP_MENU_MANAGE_STAFF', 'Administrar T�cnicos');
define('_AM_XHELP_MENU_MODIFY_EMLTPL', 'Templates dos Email�s');
define('_AM_XHELP_MENU_MODIFY_TICKET_FIELDS', 'Modificar Campos do Ticket');
define('_AM_XHELP_MENU_GROUP_PERM', 'Permiss�es');
define('_AM_XHELP_MENU_MIMETYPES', 'Extens�es Permitidas');
define('_AM_XHELP_MENU_PREFERENCES', 'Prefer�ncias');
define('_AM_XHELP_MENU_ADD_STAFF', 'Adicionar T�cnico');
define('_AM_XHELP_UPDATE_MODULE', 'Atualizar Modulo');
define('_AM_XHELP_MENU_MANAGE_ROLES', 'Administrar Fun��es');

define('_AM_XHELP_SEC_TICKET_ADD', 0);
define('_AM_XHELP_SEC_TICKET_EDIT', 1);
define('_AM_XHELP_SEC_TICKET_DELETE', 2);
define('_AM_XHELP_SEC_TICKET_OWNERSHIP', 3);
define('_AM_XHELP_SEC_TICKET_STATUS', 4);
define('_AM_XHELP_SEC_TICKET_PRIORITY', 5);
define('_AM_XHELP_SEC_TICKET_LOGUSER', 6);
define('_AM_XHELP_SEC_RESPONSE_ADD', 7);
define('_AM_XHELP_SEC_RESPONSE_EDIT', 8);

define('_AM_XHELP_SEC_TEXT_TICKET_ADD', 'Adicionar Tickets');
define('_AM_XHELP_SEC_TEXT_TICKET_EDIT', 'Modificar Tickets');
define('_AM_XHELP_SEC_TEXT_TICKET_DELETE', 'Apagar Tickets');
define('_AM_XHELP_SEC_TEXT_TICKET_OWNERSHIP', 'Mudar Responsabilidade do Ticket');
define('_AM_XHELP_SEC_TEXT_TICKET_STATUS', 'Mudar Status do Ticket');
define('_AM_XHELP_SEC_TEXT_TICKET_PRIORITY', 'Mudar Prioridade do Ticket');
define('_AM_XHELP_SEC_TEXT_TICKET_LOGUSER', 'Log Ticket para utilizador');
define('_AM_XHELP_SEC_TEXT_RESPONSE_ADD', 'Adicionar Resposta');
define('_AM_XHELP_SEC_TEXT_RESPONSE_EDIT', 'Modificar Resposta');

//Permissions
define('_AM_XHELP_GROUP_PERM', 'Permiss�es de Grupo');
define('_AM_XHELP_GROUP_PERM_TITLE', 'Alterar permiss�es dos Grupos');
define('_AM_XHELP_GROUP_PERM_NAME', 'Permiss�es');
define('_AM_XHELP_GROUP_PERM_DESC', 'Selecione as permiss�es para os grupos');

// Messages
define('_AM_XHELP_MESSAGE_STAFF_UPDATE_ERROR', 'Erro: T�cnico n�o foi atualizado');
define('_AM_XHELP_MESSAGE_FILE_READONLY', 'Este arquivo � somente de leitura. Por favor actualize a permiss�es de escrita na pasta:  modules/xhelp/language/seuidioma/mail_templates');
define('_AM_XHELP_MESSAGE_FILE_UPDATED', 'Arquivo actualizado!');
define('_AM_XHELP_MESSAGE_FILE_UPDATED_ERROR', 'Erro: arquivo n�o foi actualizado!');
define('_AM_XHELP_MESSAGE_ROLE_INSERT', 'Fun��o inserida com sucesso.');
define('_AM_XHELP_MESSAGE_ROLE_INSERT_ERROR', 'Erro: fun��o n�o foi criada.');
define('_AM_XHELP_MESSAGE_ROLE_DELETE', 'Fun��o foi apagada com sucesso.');
define('_AM_XHELP_MESSAGE_ROLE_DELETE_ERROR', 'Erro: fun��o n�o foi apagada.');
define('_AM_XHELP_MESSAGE_ROLE_UPDATE', 'Fun��o actualizada com sucesso.');
define('_AM_XHELP_MESSAGE_ROLE_UPDATE_ERROR', 'Erro: fun��o n�o foi actualizada.');
define('_AM_XHELP_MESSAGE_DEPT_STORE', 'permiss�es de Departamento actualizadas com sucesso.');
define('_AM_XHELP_MESSAGE_DEPT_STORE_ERROR', 'Erro: n�o foram actualizadas as permiss�es de departamento');
define('_AM_XHELP_MESSAGE_DEF_ROLES', 'foram adicionadas as fun��es padr�es de permiss�o  com sucesso.');
define('_AM_XHELP_MESSAGE_DEF_ROLES_ERROR', 'Erro: n�o foram adicionadas as fun��es padr�es de permiss�o.');

// Buttons
define('_AM_XHELP_BUTTON_DELETE', 'Apagar');
define('_AM_XHELP_BUTTON_EDIT', 'Editar');
define('_AM_XHELP_BUTTON_SUBMIT', 'Enviar');
define('_AM_XHELP_BUTTON_RESET', 'Limpar');
define('_AM_XHELP_BUTTON_ADDSTAFF', 'Adicionar T�cnico');
define('_AM_XHELP_BUTTON_UPDATESTAFF', 'Atualizar T�cnico');
define('_AM_XHELP_BUTTON_CANCEL', 'Cancelar');
define('_AM_XHELP_BUTTON_UPDATE', 'Atualizar');
define('_AM_XHELP_BUTTON_CREATE_ROLE', 'Criar nova Fun��o');
define('_AM_XHELP_BUTTON_CLEAR_PERMS', 'Apagar Permiss�es');
define('_AM_XHELP_BUTTON_ADD_DEPT', 'Adicionar Departamento');

define('_AM_XHELP_EDIT_DEPARTMENT', 'Editar Departamento');
define('_AM_XHELP_EXISTING_DEPARTMENTS', 'Departamentos atuais:');
define('_AM_XHELP_MANAGE_DEPARTMENTS', 'Administra��o de Departamentos');
define('_AM_XHELP_MANAGE_STAFF', 'Administra��o de T�cnicos');
define('_AM_XHELP_EXISTING_STAFF', 'T�cnicos atuais:');
define('_AM_XHELP_ADD_STAFF', 'Adicionar T�cnicos');
define('_AM_XHELP_EDIT_STAFF', 'Editar T�cnico');
define('_AM_XHELP_INDEX', 'Vis�o Geral');
define('_AM_XHELP_ADMIN_GOTOMODULE', 'Ir para o m�dulo');
define('_AM_XHELP_DEPARTMENT_SERVERS', 'Caixa postal de departamento');
define('_AM_XHELP_DEPARTMENT_SERVERS_EMAIL', 'Endere�o de Email');
define('_AM_XHELP_DEPARTMENT_SERVERS_TYPE', 'Tipo de caixa postal');
define('_AM_XHELP_DEPARTMENT_SERVERS_PRIORITY', 'Prioridade padr�o do Ticket');
define('_AM_XHELP_DEPARTMENT_SERVERS_SERVERNAME', 'Servidor');
define('_AM_XHELP_DEPARTMENT_SERVERS_PORT', 'Porta');
define('_AM_XHELP_DEPARTMENT_SERVERS_ACTION', 'A��es');
define('_AM_XHELP_DEPARTMENT_ADD_SERVER', 'Adicionar Caixa postal para monitorar');
define('_AM_XHELP_DEPARTMENT_SERVER_USERNAME', 'Utilizador');
define('_AM_XHELP_DEPARTMENT_SERVER_PASSWORD', 'Senha');
define('_AM_XHELP_DEPARTMENT_SERVER_EMAILADDRESS', 'Resposta para Endere�o de E-mail');
define('_AM_XHELP_DEPARTMENT_NO_ID', 'N�o foi achado o ID do Departamento. Abortando.');
define('_AM_XHELP_DEPARTMENT_SERVER_SAVED', 'Caixa postal adicionada para o Departamento.');
define('_AM_XHELP_DEPARTMENT_SERVER_ERROR', 'Erro ao salvar a Caixa postal para Departamento.');
define('_AM_XHELP_DEPARTMENT_SERVER_NO_ID', 'Caixa postal de departamento n�o foi especificada.');
define('_AM_XHELP_DEPARTMENT_SERVER_DELETED', 'Apagada Caixa postal de Departamento.');
define('_AM_XHELP_DEPARTMENT_SERVER_DELETE_ERROR', 'Erro ao remover Caixa postal de Departamento.');
define('_AM_XHELP_STAFF_ERROR_DEPTARTMENTS', 'Voc� tem que nomear um t�cnico a um ou mais departamentos antes de salvar');
define('_AM_XHELP_STAFF_ERROR_ROLES', 'Voc� tem que nomear um t�cnico a um ou mais fun��es antes de salvar');

define('_AM_XHELP_MBOX_POP3', 'POP3');
define('_AM_XHELP_MBOX_IMAP', 'IMAP');

define('_AM_XHELP_TEXT_ADD_DEPT', 'Adicionar Departamento:');
define('_AM_XHELP_TEXT_EDIT_DEPT', 'Editar nome do Departamento:');
define('_AM_XHELP_TEXT_EDIT', 'Editar');
define('_AM_XHELP_TEXT_DELETE', 'Apagar');
define('_AM_XHELP_TEXT_SELECTUSER', 'Selecionar T�cnico:');
define('_AM_XHELP_TEXT_DEPARTMENTS', 'Departamentos:');
define('_AM_XHELP_TEXT_USER', 'T�cnicos:');
define('_AM_XHELP_TEXT_ALL_DEPTS', 'Todos os departamentos');
define('_AM_XHELP_TEXT_NO_DEPTS', 'None');
define('_AM_XHELP_TEXT_MAKE_DEPTS', 'Voc� tem que criar os departamentos antes de adicionar t�cnicos!');
define('_AM_XHELP_LINK_ADD_DEPT', 'Adicionar Departamentos');
define('_AM_XHELP_TEXT_TOP_CLOSERS', 'T�cnicos mais ativos');
define('_AM_XHELP_TEXT_WORST_CLOSERS', 'Piores Atendimentos');
define('_AM_XHELP_TEXT_HIGH_PRIORITY', 'Tickets Abertos com prioridade de Urg�ncia');
define('_AM_XHELP_TEXT_NO_OWNER', 'Nenhum T�cnico');
define('_AM_XHELP_TEXT_NO_DEPT', 'Nenhum Departamento');
define('_AM_XHELP_TEXT_RESPONSE_TIME', 'Tempo de Resposta mais r�pido');
define('_AM_XHELP_TEXT_RESPONSE_TIME_SLOW', 'Tempo de Resposta mais lento');
define('_AM_XHELP_TEXT_PRIORITY', 'Prioridade:');
define('_AM_XHELP_TEXT_ELAPSED', 'Decorrido:');
define('_AM_XHELP_TEXT_STATUS', 'Status:');
define('_AM_XHELP_TEXT_SUBJECT', 'Titulo:');
define('_AM_XHELP_TEXT_DEPARTMENT', 'Departamento:');
define('_AM_XHELP_TEXT_OWNER', 'T�cnico:');
define('_AM_XHELP_TEXT_LAST_UPDATED', 'Ultimas Actualiza��es:');
define('_AM_XHELP_TEXT_LOGGED_BY', 'Enviado Por:');
define('_AM_XHELP_TEXT_EXISTING_ROLES', 'Fun��es existentes');
define('_AM_XHELP_TEXT_NO_ROLES', 'N�o existe fun��es');
define('_AM_XHELP_TEXT_ROLES', 'Fun��es:');
define('_AM_XHELP_TEXT_CREATE_ROLE', 'Criar nova Fun��o');
define('_AM_XHELP_TEXT_EDIT_ROLE', 'Editar Fun��o');
define('_AM_XHELP_TEXT_NAME', 'Nome:');
define('_AM_XHELP_TEXT_PERMISSIONS', 'Permiss�es:');
define('_AM_XHELP_TEXT_SELECT_ALL', 'Selecionar todas');
define('_AM_XHELP_TEXT_DEPT_PERMS', 'Personalizar Permiss�es de Departamento');
define('_AM_XHELP_TEXT_CUSTOMIZE', 'Personalizar');
define('_AM_XHELP_TEXT_ACTIONS', 'A��es:');
define('_AM_XHELP_TEXT_ID', 'ID:');
define('_AM_XHELP_TEXT_LOOKUP_USER', 'Observe o Utilizador');
define('_AM_XHELP_SEARCH_BEGINEGINDATE', 'Data Inicial');
define('_AM_XHELP_SEARCH_ENDDATE', 'Data Final');


define('_AM_XHELP_TEXT_MAIL_EVENTS', 'Eventos Enviados');
define('_AM_XHELP_TEXT_MAILBOX', 'Caixa Postal:');
define('_AM_XHELP_TEXT_EVENT_CLASS', 'Classe de evento:');
define('_AM_XHELP_TEXT_TIME', 'Tempo:');
define('_AM_XHELP_NO_EVENTS', 'N�o h� Eventos');
define('_AM_XHELP_SEARCH_EVENTS', 'Procurar Eventos Enviados');
define('_AM_XHELP_BUTTON_SEARCH', 'Procurar');




// Mimetypes
define("_AM_XHELP_MIME_ID", "ID");
define("_AM_XHELP_MIME_EXT", "EXT");
define("_AM_XHELP_MIME_NAME", "Tipo do Aplica��o");
define("_AM_XHELP_MIME_ADMIN", "Admin");
define("_AM_XHELP_MIME_USER", "Utilizador");
// Mimetype Form
define("_AM_XHELP_MIME_CREATEF", "Criar Extens�o");
define("_AM_XHELP_MIME_MODIFYF", "Modificar Extens�o");
define("_AM_XHELP_MIME_EXTF", "Extens�o do Arquivo:");
define("_AM_XHELP_MIME_NAMEF", "Tipo do Aplica��o/Nome:<div style='padding-top: 8px;'><span style='font-weight: normal;'>Aplicativo Associado a extens�o.</span></div>");
define("_AM_XHELP_MIME_TYPEF", "Extens�es:<div style='padding-top: 8px;'><span style='font-weight: normal;'>Adicione cada extens�o associada ao aplicativo.Cada extens�o dever estar separada por um espa�o.</span></div>");
define("_AM_XHELP_MIME_ADMINF", "Extens�o permitida aos Admins");
define("_AM_XHELP_MIME_ADMINFINFO", "<b>Extens�es dispon�vel para envio pelos Admins:</b>");
define("_AM_XHELP_MIME_USERF", "Extens�o permitida aos utilizadores");
define("_AM_XHELP_MIME_USERFINFO", "<b>Extens�es dispon�vel para envio pelos utilizadores:</b>");
define("_AM_XHELP_MIME_NOMIMEINFO", "Nenhuma extens�o foi selecionada.");
define("_AM_XHELP_MIME_FINDMIMETYPE", "Procurar nova extens�o:");
define("_AM_XHELP_MIME_EXTFIND", "Procurar extens�o de arquivo:<div style='padding-top: 8px;'><span style='font-weight: normal;'>Digite a extens�o que deseja procurar.</span></div>");
define("_AM_XHELP_MIME_INFOTEXT", "<ul><li>Novas Extens�es poder ser criadas, editadas ou apagadas facilmente.</li>
	<li>Procurar um extens�o nova por um site da Web externo.</li>
	<li>VVisualiza��o das Extens�es para envio por Admins e Utilizadores.</li>
	<li>Mudar a op��o de envio da entens�o.</li></ul>
	");

// Mimetype Buttons
define("_AM_XHELP_MIME_CREATE", "Criar");
define("_AM_XHELP_MIME_CLEAR", "Limpar");
define("_AM_XHELP_MIME_CANCEL", "Cancelar");
define("_AM_XHELP_MIME_MODIFY", "Modificar");
define("_AM_XHELP_MIME_DELETE", "Apagar");
define("_AM_XHELP_MIME_FINDIT", "Procurar Extens�o!");
// Mimetype Database
define("_AM_XHELP_MIME_DELETETHIS", "Apagar Extens�o Selecionada?");
define("_AM_XHELP_MIME_MIMEDELETED", "Extens�o %s foi excluida");
define("_AM_XHELP_MIME_CREATED", "Informa��es sobre Extens�o foram criadas");
define("_AM_XHELP_MIME_MODIFIED", "Informa��es sobre Extens�o foram actualizadas");

define("_AM_XHELP_MINDEX_ACTION", "A��o");
define("_AM_XHELP_MINDEX_PAGE", "<b>P�gina:<b> ");

//image admin icon
define("_AM_XHELP_ICO_EDIT","Editar Item");
define("_AM_XHELP_ICO_DELETE","Apagar Item");
define("_AM_XHELP_ICO_ONLINE","Online");
define("_AM_XHELP_ICO_OFFLINE","Offline");
define("_AM_XHELP_ICO_APPROVED","Aprovado");
define("_AM_XHELP_ICO_NOTAPPROVED","N�o Aprovado");

define("_AM_XHELP_ICO_LINK","Relatar Link");
define("_AM_XHELP_ICO_URL","Adicionar URL Informada");
define("_AM_XHELP_ICO_ADD","Adicionar");
define("_AM_XHELP_ICO_APPROVE","Aprovar");
define("_AM_XHELP_ICO_STATS","Estado");

define("_AM_XHELP_ICO_IGNORE","Ignorar");
define("_AM_XHELP_ICO_ACK","Relat�rio Inv�lido");
define("_AM_XHELP_ICO_REPORT","Relat�rio Inv�lido?");
define("_AM_XHELP_ICO_CONFIRM","Relat�rio Inv�lido");
define("_AM_XHELP_ICO_CONBROKEN","Relat�rio Inv�lido?");

define("_AM_XHELP_UPLOADFILE", "Arquivo Enviado");
define('_AM_XHELP_TEXT_TICKET_INFO', 'Informa��es dos Tickets');
define('_AM_XHELP_TEXT_OPEN_TICKETS', 'Tickets Abertos');
define('_AM_XHELP_TEXT_HOLD_TICKETS', 'Tickets Bloqueados');
define('_AM_XHELP_TEXT_CLOSED_TICKETS', 'Tickets Terminados');
define('_AM_XHELP_TEXT_TOTAL_TICKETS', 'Total Tickets');

define('_AM_XHELP_TEXT_TEMPLATE_NAME', 'Nome do Template:');
define('_AM_XHELP_TEXT_DESCRIPTION', 'Descri��o:');
define('_AM_XHELP_TEXT_GENERAL_TAGS', 'Tags Gerais');
define('_AM_XHELP_TEXT_GENERAL_TAGS1', 'X_SITEURL - URL do site');
define('_AM_XHELP_TEXT_GENERAL_TAGS2', 'X_SITENAME - Nome do site');
define('_AM_XHELP_TEXT_GENERAL_TAGS3', 'X_ADMINMAIL - Email do administrator');
define('_AM_XHELP_TEXT_GENERAL_TAGS4', 'X_MODULE - Nome do modulo');
define('_AM_XHELP_TEXT_GENERAL_TAGS5', 'X_MODULE_URL - link para o modulo');
define('_AM_XHELP_TEXT_TAGS_NO_MODIFY', 'N�o modifique as tags aqui relacionadas!');

define('_AM_XHELP_CURRENTVER', 'Vers�o actual: <span class="currentVer">%s</span>');
define('_AM_XHELP_DBVER', 'Vers�o da base de dados: <span class="dbVer">%s</span>');
define('_AM_XHELP_DB_NOUPDATE', 'A sua base de dados est� em dia. Nenhuma actualiza��o � necess�ria.');
define('_AM_XHELP_DB_NEEDUPDATE', 'A sua base de dados est� desactualizada. Por favor actualize suas tabelas da sua base de dados!');
define('_AM_XHELP_UPDATE_NOW', 'Actualize Agora!');
define('_AM_XHELP_DB_NEEDINSTALL', 'A sua base de dados est� fora de sincronismo com a vers�o instalada. Por favor instale a mesma vers�o da sua base de dados ');
define('_AM_XHELP_VERSION_ERR', 'Incapaz determinar uma pr�via da vers�o.');
define('_AM_XHELP_MSG_MODIFYTABLE', 'Tabela modificada %s');
define('_AM_XHELP_MSG_MODIFYTABLE_ERR', 'Erro ao modificar a tabela %s');
define('_AM_XHELP_MSG_ADDTABLE', 'Tabela adicionada %s');
define('_AM_XHELP_MSG_ADDTABLE_ERR', 'Erro ao adicionar tabela %s');
define('_AM_XHELP_MSG_UPDATESTAFF', 'T�cnico actualizado #%s');
define('_AM_XHELP_MSG_UPDATESTAFF_ERR', 'Erro ao actualizar t�cnico #%s');
define('_AM_XHELP_UPDATE_DB', 'Actualizando Base de dados:');
define('_AM_XHELP_UPDATE_TO', 'Actualizando para a vers�o %s:');
define('_AM_XHELP_UPDATE_OK', 'Sucesso ao actualizar a vers�o %s');
define('_AM_XHELP_UPDATE_ERR', 'Error ao actualizar a vers�o %s');
define('_AM_XHELP_MSG_UPD_PERMS', 'Staff #%s permiss�es adicionadas para departamento %s.');
define('_AM_XHELP_MSG_REMOVE_TABLE', 'Tabela %s removidas da sua base de dados.');
define('_AM_XHELP_MSG_GLOBAL_PERMS', 'T�cnico #%s tem permiss�es globais.');
define('_AM_XHELP_MSG_NOT_REMOVE_TABLE', 'Error: Tabela %s n�o foram removidas da sua base de dados.');
define('_AM_XHELP_MSG_RENAME_TABLE', 'Tabela %s foi renomeada %s.');
define('_AM_XHELP_MSG_RENAME_TABLE_ERR', 'Error: tabela %s n�o foi renomeada.');
?>