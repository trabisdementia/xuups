<?php
//traduzido por Silviotech - www.santoxoops.com.br / www.xoops.pr.gov.br
//adaptado para portugues de portugal por _Vlad_

define('_MI_XHELP_NAME', 'xhelp');
define('_MI_XHELP_DESC', 'Modulo de Suporte ao clientes');

//Template variables
define('_MI_XHELP_TEMP_ADDTICKET', 'Template para addTicket.php');
define('_MI_XHELP_TEMP_SEARCH', 'Template para search.php');
define('_MI_XHELP_TEMP_STAFF_INDEX', 'Staff template para index.php');
define('_MI_XHELP_TEMP_STAFF_PROFILE', 'Template para profile.php');
define('_MI_XHELP_TEMP_STAFF_TICKETDETAILS', 'Staff template para ticket.php');
define('_MI_XHELP_TEMP_USER_INDEX', 'User template para index.php');
define('_MI_XHELP_TEMP_USER_TICKETDETAILS', 'User template para ticket.php');
define('_MI_XHELP_TEMP_STAFF_RESPONSE', 'Template para response.php');
define('_MI_XHELP_TEMP_LOOKUP', 'Template para lookup.php');
define('_MI_XHELP_TEMP_STAFFREVIEW', 'Template para reviewing a staff member');
define('_MI_XHELP_TEMP_EDITTICKET', 'Template para editing a ticket');
define('_MI_XHELP_TEMP_EDITRESPONSE', 'Template para editing a response');
define('_MI_XHELP_TEMP_ANNOUNCEMENT', 'Template para announcements');
define('_MI_XHELP_TEMP_STAFF_HEADER', 'Template para staff menu options');
define('_MI_XHELP_TEMP_USER_HEADER', 'Template para user menu options');
define('_MI_XHELP_TEMP_PRINT', 'Template para printer-friendly ticket page');
define('_MI_XHELP_TEMP_STAFF_ALL', 'Template para Staff View All Page');
define('_MI_XHELP_TEMP_STAFF_TICKET_TABLE', 'Template to display staff tickets');
define('_MI_XHELP_TEMP_SETDEPT', 'Template para Set Department Page');
define('_MI_XHELP_TEMP_SETPRIORITY', 'Template para Set Priority Page');
define('_MI_XHELP_TEMP_SETOWNER', 'Template para Set Owner Page');
define('_MI_XHELP_TEMP_SETSTATUS', 'Template para Set Status Page');
define('_MI_XHELP_TEMP_DELETE', 'Template para Batch Ticket Delete Page');
define('_MI_XHELP_TEMP_BATCHRESPONSE', 'Template para Batch Add Response Page');
define('_MI_XHELP_TEMP_ANON_ADDTICKET', 'Template para utilizadores an�nimos na pagina de adicionar ticket');
define('_MI_XHELP_TEMP_ERROR', 'Template para p�gina de erro');

// Block variables
define('_MI_XHELP_BNAME1', 'Meus Tickets Abertos');
define('_MI_XHELP_BNAME1_DESC', 'Mostra uma lista do utilizador e dos seus tickets abertos');
define('_MI_XHELP_BNAME2', 'Tickets por Departamentos');
define('_MI_XHELP_BNAME2_DESC', 'Mostra uma lista com o n�mero de tickets abertos por depto.');
define('_MI_XHELP_BNAME3', 'Tickets Respondidos');
define('_MI_XHELP_BNAME3_DESC', 'Mostra os �ltimos tickets respondidos pelo suporte.');
define('_MI_XHELP_BNAME4', 'Ac��es do Ticket');
define('_MI_XHELP_BNAME4_DESC', 'Exibi��es todas as ac��es que um t�cnico pode fazer num ticket');

// Config variables
define('_MI_XHELP_TITLE', 'Titulo do Suporte');
define('_MI_XHELP_TITLE_DSC', 'Nome do Suporte:');
define('_MI_XHELP_UPLOAD', 'Direct�rio de Envio');
define('_MI_XHELP_UPLOAD_DSC', 'direct�rio onde o utilizador armazena arquivos que s�o acrescentados a um ticket');
define('_MI_XHELP_ALLOW_UPLOAD', 'Permitir Envios');
define('_MI_XHELP_ALLOW_UPLOAD_DSC', 'Permita os usu�rios para acrescentar um arquivo aos tickets de suporte deles?');
define('_MI_XHELP_UPLOAD_SIZE', 'Tamanho de Envio');
define('_MI_XHELP_UPLOAD_SIZE_DSC', 'Tamanho m�ximo para envio(em bytes)');
define('_MI_XHELP_UPLOAD_WIDTH', 'Largura de Envio');
define('_MI_XHELP_UPLOAD_WIDTH_DSC', 'Largura m�xima para envio (em pixels)');
define('_MI_XHELP_UPLOAD_HEIGHT', 'Altura de Envio');
define('_MI_XHELP_UPLOAD_HEIGHT_DSC', 'Altura maxima para envio(em pixels)');
define('_MI_XHELP_ANNOUNCEMENTS', 'T�pico de Not�cias de an�ncios');
define('_MI_XHELP_ANNOUNCEMENTS_DSC', 'Este � o t�pico de not�cias que puxa an�ncios para xhelp. Actualize o m�dulo de xHelp para ver categorias de not�cias recentemente adicionadas');
define('_MI_XHELP_ANNOUNCEMENTS_NONE', '***desabilitar an�ncios***');
define('_MI_XHELP_ALLOW_REOPEN', 'Ticket pode ser Re-aberto');
define('_MI_XHELP_ALLOW_REOPEN_DSC', 'Permitir os utilizadores re-abrir um ticket depois de finalizado?');
define('_MI_XHELP_STAFF_TC', 'Pagina de �ndice de Ticket nas contas');
define('_MI_XHELP_STAFF_TC_DSC', 'Quantos tickets deveriam ser exibidos para cada sec��o na p�gina de �ndice?');
define('_MI_XHELP_STAFF_ACTIONS', 'Ac��es dos T�cnicos');
define('_MI_XHELP_STAFF_ACTIONS_DSC', 'Em que estilo gostaria de mostrar as ac��es? A op��o do estilo em linha (Inline-Sytle) � padr�o, o Estilo-Bloco (Block-Sytle) lhe exige que habilite o bloco de Ac��es do T�cnicos.');
define('_MI_XHELP_ACTION1', 'Estilo-Em linha');
define('_MI_XHELP_ACTION2', 'Estilo-Bloco');
define('_MI_XHELP_DEFAULT_DEPT', 'Departamento Padr�o');
define('_MI_XHELP_DEFAULT_DEPT_DSC', "Este ser� o departamento padr�o que � selecionado na lista ao adicionar um ticket. <a href='javascript:openWithSelfMain(\"".XOOPS_URL."/modules/xhelp/install.php?op=updateDepts\", \"xoops_module_install_xhelp\",400, 300);'>Clique aqui</a> para actualizar os departamentos.");
define('_MI_XHELP_OVERDUE_TIME', ' Tempo do Ticket vencido e n�o analizado');
define('_MI_XHELP_OVERDUE_TIME_DSC', 'Isto determina quanto tempo o departamento respons�vel tem que terminar um ticket antes que o mesmo fique velho (em horas).');
define('_MI_XHELP_ALLOW_ANON', 'Permita envio de Ticket por Usu�rios An�nimos');
define('_MI_XHELP_ALLOW_ANON_DSC', 'Isto permite que qualquer um crie um ticket no seu site. Quando um utilizador an�nimo enviar um ticket, eles tamb�m estar�o criando uma conta no seu site.');

// Admin Menu variables
define('_MI_XHELP_MENU_BLOCKS', 'Administrar Blocos');
define('_MI_XHELP_MENU_MANAGE_DEPARTMENTS', 'Administrar Departamentos');
define('_MI_XHELP_MENU_MANAGE_STAFF', 'Administrar T�cnicos');
define('_MI_XHELP_MENU_MODIFY_EMLTPL', 'Templates dos Email�s');
define('_MI_XHELP_MENU_MODIFY_TICKET_FIELDS', 'Modificar Campos do Ticket');
define('_MI_XHELP_MENU_GROUP_PERM', 'Permiss�es');
define('_MI_XHELP_MENU_ADD_STAFF', 'Adicionar T�cnico');
define('_MI_XHELP_MENU_MIMETYPES', 'Extens�es Permitidas');
define('_MI_XHELP_MENU_CHECK_TABLES', 'Actualizar Vers�o');
define('_MI_XHELP_MENU_MANAGE_ROLES', 'Administrar Fun��es');
define('_MI_XHELP_MENU_MAIL_EVENTS', 'Eventos Enviados');
define('_MI_XHELP_MENU_CHECK_EMAIL', 'Confirmar E-mail');

//NOTIFICATION vars
define('_MI_XHELP_DEPT_NOTIFY','Departamento');
define('_MI_XHELP_DEPT_NOTIFYDSC','Op��es de notifica��o que aplicam a um certo departamento');

define('_MI_XHELP_TICKET_NOTIFY','Ticket');
define('_MI_XHELP_TICKET_NOTIFYDSC','Op��es de notifica��o que aplicam ao ticket atual');

define('_MI_XHELP_DEPT_NEWTICKET_NOTIFY', 'Dept: Novo Ticket');
define('_MI_XHELP_DEPT_NEWTICKET_NOTIFYCAP', 'Notificar que um novo ticket foi enviado');
define('_MI_XHELP_DEPT_NEWTICKET_NOTIFYDSC', 'Receba notifica��o quando um novo ticket � enviado');
define('_MI_XHELP_DEPT_NEWTICKET_NOTIFYSBJ', '[{X_SITENAME}] Ticket enviado');
define('_MI_XHELP_DEPT_NEWTICKET_NOTIFYTPL', 'dept_newticket_notify.tpl');

define('_MI_XHELP_DEPT_REMOVEDTICKET_NOTIFY', 'Dept: Ticket Apagado');
define('_MI_XHELP_DEPT_REMOVEDTICKET_NOTIFYCAP', 'Notificar que um ticket foi apagado');
define('_MI_XHELP_DEPT_REMOVEDTICKET_NOTIFYDSC', 'Receba notifica��o quando um ticket � apagado');
define('_MI_XHELP_DEPT_REMOVEDTICKET_NOTIFYSBJ', '[{X_SITENAME}] Ticket apagado');
define('_MI_XHELP_DEPT_REMOVEDTICKET_NOTIFYTPL', 'dept_removedticket_notify.tpl');

define('_MI_XHELP_DEPT_MODIFIEDTICKET_NOTIFY', 'Dept: Ticket Modificado');
define('_MI_XHELP_DEPT_MODIFIEDTICKET_NOTIFYCAP', 'Notificar quando um ticket � modificado');
define('_MI_XHELP_DEPT_MODIFIEDTICKET_NOTIFYDSC', 'Receba notifica��o quando um ticket � modificado');
define('_MI_XHELP_DEPT_MODIFIEDTICKET_NOTIFYSBJ', '[{X_SITENAME}] Modificado');
define('_MI_XHELP_DEPT_MODIFIEDTICKET_NOTIFYTPL', 'dept_modifiedticket_notify.tpl');

define('_MI_XHELP_DEPT_NEWRESPONSE_NOTIFY', 'Dept: Nova Resposta');
define('_MI_XHELP_DEPT_NEWRESPONSE_NOTIFYCAP', 'Notificar que uma nova resposta foi adicionada ao ticket');
define('_MI_XHELP_DEPT_NEWRESPONSE_NOTIFYDSC', 'Receba notifica��o quando uma nova resposta foi adicionada ao ticket');
define('_MI_XHELP_DEPT_NEWRESPONSE_NOTIFYSBJ', '[{X_SITENAME}] Ticket Resposta Enviada');
define('_MI_XHELP_DEPT_NEWRESPONSE_NOTIFYTPL', 'dept_newresponse_notify.tpl');

define('_MI_XHELP_DEPT_MODIFIEDRESPONSE_NOTIFY', 'Dept: Resposta Alterada');
define('_MI_XHELP_DEPT_MODIFIEDRESPONSE_NOTIFYCAP', 'Notificar que a resposta do ticket foi modificada');
define('_MI_XHELP_DEPT_MODIFIEDRESPONSE_NOTIFYDSC', 'Receba notifica��o quando uma resposta do ticket foi alterada');
define('_MI_XHELP_DEPT_MODIFIEDRESPONSE_NOTIFYSBJ', '[{X_SITENAME}] Ticket Resposta Alterada');
define('_MI_XHELP_DEPT_MODIFIEDRESPONSE_NOTIFYTPL', 'dept_modifiedresponse_notify.tpl');

define('_MI_XHELP_DEPT_CHANGEDSTATUS_NOTIFY', 'Dept: Estado do Ticket');
define('_MI_XHELP_DEPT_CHANGEDSTATUS_NOTIFYCAP', 'Notificar que o estado do ticket foi alterado');
define('_MI_XHELP_DEPT_CHANGEDSTATUS_NOTIFYDSC', 'Receba notifica��o quando o estado do ticket foi alterado');
define('_MI_XHELP_DEPT_CHANGEDSTATUS_NOTIFYSBJ', '[{X_SITENAME}] Ticket estado Alterado');
define('_MI_XHELP_DEPT_CHANGEDSTATUS_NOTIFYTPL', 'dept_changedstatus_notify.tpl');

define('_MI_XHELP_DEPT_CHANGEDPRIORITY_NOTIFY', 'Dept: Prioridade do Ticket');
define('_MI_XHELP_DEPT_CHANGEDPRIORITY_NOTIFYCAP', 'Notificar que a prioridade do ticket foi alterada');
define('_MI_XHELP_DEPT_CHANGEDPRIORITY_NOTIFYDSC', 'Receba notifica��o quando a prioridade do ticket foi alterada');
define('_MI_XHELP_DEPT_CHANGEDPRIORITY_NOTIFYSBJ', '[{X_SITENAME}] Ticket Prioridade Alterada');
define('_MI_XHELP_DEPT_CHANGEDPRIORITY_NOTIFYTPL', 'dept_changedpriority_notify.tpl');

define('_MI_XHELP_DEPT_NEWOWNER_NOTIFY', 'Dept: Responsabilidade Novo Ticket');
define('_MI_XHELP_DEPT_NEWOWNER_NOTIFYCAP', 'Notificar que a reponsabilidade sobre o novo ticket atribuida');
define('_MI_XHELP_DEPT_NEWOWNER_NOTIFYDSC', 'Receba notifica��o quando a reponsabilidade sobre o novo ticket atribuida');
define('_MI_XHELP_DEPT_NEWOWNER_NOTIFYSBJ', '[{X_SITENAME}] Ticket Atribuido');
define('_MI_XHELP_DEPT_NEWOWNER_NOTIFYTPL', 'dept_newowner_notify.tpl');

/*
define('_MI_XHELP_DEPT_CLAIMOWNER_NOTIFY', ' Reivindica��o de novo Ticket');
define('_MI_XHELP_DEPT_CLAIMOWNER_NOTIFYCAP', 'Notificar sobre Reivindica��o de novo Ticket');
define('_MI_XHELP_DEPT_CLAIMOWNER_NOTIFYDSC', 'Receba notifica��o sobre Reivindica��o de novo Ticket');
define('_MI_XHELP_DEPT_CLAIMOWNER_NOTIFYSBJ', '[{X_SITENAME}] Reivindica��o de novo Ticket');
*/

define('_MI_XHELP_TICKET_REMOVEDTICKET_NOTIFY', 'Ticket: Apagado');
define('_MI_XHELP_TICKET_REMOVEDTICKET_NOTIFYCAP', 'Notificar que um ticket foi apagado');
define('_MI_XHELP_TICKET_REMOVEDTICKET_NOTIFYDSC', 'Receba notifica��o quando um ticket � apagado');
define('_MI_XHELP_TICKET_REMOVEDTICKET_NOTIFYSBJ', '[{X_SITENAME}] Ticket apagado');
define('_MI_XHELP_TICKET_REMOVEDTICKET_NOTIFYTPL', 'ticket_removedticket_notify.tpl');

define('_MI_XHELP_TICKET_MODIFIEDTICKET_NOTIFY', 'Ticket: Modificado');
define('_MI_XHELP_TICKET_MODIFIEDTICKET_NOTIFYCAP', 'Notificar quando um ticket � modificado');
define('_MI_XHELP_TICKET_MODIFIEDTICKET_NOTIFYDSC', 'Receba notifica��o quando um ticket � modificado');
define('_MI_XHELP_TICKET_MODIFIEDTICKET_NOTIFYSBJ', '[{X_SITENAME}] Ticket Modificado');
define('_MI_XHELP_TICKET_MODIFIEDTICKET_NOTIFYTPL', 'ticket_modifiedticket_notify.tpl');

define('_MI_XHELP_TICKET_NEWRESPONSE_NOTIFY', 'Ticket: Nova Resposta');
define('_MI_XHELP_TICKET_NEWRESPONSE_NOTIFYCAP', 'Notificar que uma nova resposta foi adicionada ao ticket');
define('_MI_XHELP_TICKET_NEWRESPONSE_NOTIFYDSC', 'Receba notifica��o quando uma nova resposta foi adicionada ao ticket');
define('_MI_XHELP_TICKET_NEWRESPONSE_NOTIFYSBJ', '[{X_SITENAME}] Ticket Resposta Enviada');
define('_MI_XHELP_TICKET_NEWRESPONSE_NOTIFYTPL', 'ticket_newresponse_notify.tpl');

define('_MI_XHELP_TICKET_MODIFIEDRESPONSE_NOTIFY', 'Ticket: Resposta Alterada');
define('_MI_XHELP_TICKET_MODIFIEDRESPONSE_NOTIFYCAP', 'Notificar que a resposta do ticket foi modificada');
define('_MI_XHELP_TICKET_MODIFIEDRESPONSE_NOTIFYDSC', 'Receba notifica��o quando uma resposta do ticket foi alterada');
define('_MI_XHELP_TICKET_MODIFIEDRESPONSE_NOTIFYSBJ', '[{X_SITENAME}] Ticket Resposta Alterada');
define('_MI_XHELP_TICKET_MODIFIEDRESPONSE_NOTIFYTPL', 'ticket_modifiedresponse_notify.tpl');

define('_MI_XHELP_TICKET_CHANGEDSTATUS_NOTIFY', 'Ticket: Estado do Ticket');
define('_MI_XHELP_TICKET_CHANGEDSTATUS_NOTIFYCAP', 'Notificar que o estado do ticket foi alterado');
define('_MI_XHELP_TICKET_CHANGEDSTATUS_NOTIFYDSC', 'Receba notifica��o quando o estado do ticket foi alterado');
define('_MI_XHELP_TICKET_CHANGEDSTATUS_NOTIFYSBJ', '[{X_SITENAME}] Ticket status Alterado');
define('_MI_XHELP_TICKET_CHANGEDSTATUS_NOTIFYTPL', 'ticket_changedstatus_notify.tpl');

define('_MI_XHELP_TICKET_CHANGEDPRIORITY_NOTIFY', 'Ticket: Prioridade do Ticket');
define('_MI_XHELP_TICKET_CHANGEDPRIORITY_NOTIFYCAP', 'Notificar que a prioridade do ticket foi alterada');
define('_MI_XHELP_TICKET_CHANGEDPRIORITY_NOTIFYDSC', 'Receba notifica��o quando a prioridade do ticket foi alterada');
define('_MI_XHELP_TICKET_CHANGEDPRIORITY_NOTIFYSBJ', '[{X_SITENAME}] Ticket Prioridade Alterada');
define('_MI_XHELP_TICKET_CHANGEDPRIORITY_NOTIFYTPL', 'ticket_changedpriority_notify.tpl');

define('_MI_XHELP_TICKET_NEWOWNER_NOTIFY', 'Ticket: Responsabilidade Novo Ticket');
define('_MI_XHELP_TICKET_NEWOWNER_NOTIFYCAP', 'Notificar que a reponsabilidade sobre o novo ticket designada');
define('_MI_XHELP_TICKET_NEWOWNER_NOTIFYDSC', 'Receba notifica��o quando a reponsabilidade sobre o novo ticket designada');
define('_MI_XHELP_TICKET_NEWOWNER_NOTIFYSBJ', '[{X_SITENAME}] Responsabilidade Novo Ticke');
define('_MI_XHELP_TICKET_NEWOWNER_NOTIFYTPL', 'ticket_newowner_notify.tpl');

define('_MI_XHELP_TICKET_NEWTICKET_NOTIFY', 'Ticket: Novo Ticket');
define('_MI_XHELP_TICKET_NEWTICKET_NOTIFYCAP', 'Confirma quando um Ticket for enviado');
define('_MI_XHELP_TICKET_NEWTICKET_NOTIFYDSC', 'Receba notifica��o quando um ticket � enviado');
define('_MI_XHELP_TICKET_NEWTICKET_NOTIFYSBJ', '[{X_SITENAME}] Novo Ticket ');
define('_MI_XHELP_TICKET_NEWTICKET_NOTIFYTPL', 'ticket_newticket_notify.tpl');

define('_MI_XHELP_DEPT_CLOSETICKET_NOTIFY', 'Dept: Ticket Finalizado');
define('_MI_XHELP_DEPT_CLOSETICKET_NOTIFYCAP', 'Notificar quando um ticket � finalizado');
define('_MI_XHELP_DEPT_CLOSETICKET_NOTIFYDSC', 'Receba notifica��o quando um ticket � finalizado');
define('_MI_XHELP_DEPT_CLOSETICKET_NOTIFYSBJ', '[{X_SITENAME}] Ticket Finalizado');
define('_MI_XHELP_DEPT_CLOSETICKET_NOTIFYTPL', 'dept_closeticket_notify.tpl');

define('_MI_XHELP_TICKET_CLOSETICKET_NOTIFY', 'Ticket: Ticket Finalizado');
define('_MI_XHELP_TICKET_CLOSETICKET_NOTIFYCAP', 'Confirma quando um Ticket for finalizado');
define('_MI_XHELP_TICKET_CLOSETICKET_NOTIFYDSC', 'Receba notifica��o quando um ticket � finalizado');
define('_MI_XHELP_TICKET_CLOSETICKET_NOTIFYSBJ', '[{X_SITENAME}] Ticket Finalizado');
define('_MI_XHELP_TICKET_CLOSETICKET_NOTIFYTPL', 'ticket_closeticket_notify.tpl');

define('_MI_XHELP_TICKET_NEWUSER_NOTIFY', 'Ticket: Novo utilizador Criado');
define('_MI_XHELP_TICKET_NEWUSER_NOTIFYCAP', 'Notifique utilizador que uma conta nova foi criada');
define('_MI_XHELP_TICKET_NEWUSER_NOTIFYDSC', 'Receba notifica��o quando um utilizador novo � criado de uma submiss�o de e-mail (Requer Activa��o)');
define('_MI_XHELP_TICKET_NEWUSER_NOTIFYSBJ', '[{X_SITENAME}] Novo Usu�rio Criado');
define('_MI_XHELP_TICKET_NEWUSER_NOTIFYTPL', 'ticket_new_user_byemail.tpl');

define('_MI_XHELP_TICKET_NEWUSER_ACT1_NOTIFY', 'Ticket: Novo utilizador Criado');
define('_MI_XHELP_TICKET_NEWUSER_ACT1_NOTIFYCAP', 'Notifique utilizador que uma conta nova foi criada');
define('_MI_XHELP_TICKET_NEWUSER_ACT1_NOTIFYDSC', 'Receba notifica��o quando um utilizador novo � criado de uma submiss�o de e-mail (Activa��o Autom�tica)');
define('_MI_XHELP_TICKET_NEWUSER_ACT1_NOTIFYSBJ', '[{X_SITENAME}] Novo utilizadorCriado');
define('_MI_XHELP_TICKET_NEWUSER_ACT1_NOTIFYTPL', 'ticket_new_user_activation1.tpl');

define('_MI_XHELP_TICKET_NEWUSER_ACT2_NOTIFY', 'Ticket: Novo utilizador Criado');
define('_MI_XHELP_TICKET_NEWUSER_ACT2_NOTIFYCAP', 'Notifique utilizador que uma conta nova foi criada');
define('_MI_XHELP_TICKET_NEWUSER_ACT2_NOTIFYDSC', 'Receba notifica��o quando um utilizador novo � criado de uma submiss�o de e-mail (Requer Activa��o de um Admin)');
define('_MI_XHELP_TICKET_NEWUSER_ACT2_NOTIFYSBJ', '[{X_SITENAME}] Novo Utilizador Criado');
define('_MI_XHELP_TICKET_NEWUSER_ACT2_NOTIFYTPL', 'ticket_new_user_activation2.tpl');
?>