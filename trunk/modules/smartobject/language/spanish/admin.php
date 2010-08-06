<?php
//Traducción por debianus. Sugerencias y reporte de errores en http://es.impresscms.org
/**
 * $Id: admin.php 159 2007-12-17 16:44:05Z malanciault $
 * Module: SmartContent
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */
if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

define('_AM_SOBJECT_ABOUT', 'Acerca de');
define('_AM_SOBJECT_AUTHOR_INFO', 'Información sobre los colaboradores');
define('_AM_SOBJECT_BY', 'Por');
define('_AM_SOBJECT_DEVELOPER_CONTRIBUTOR', 'Colaboradores');
define('_AM_SOBJECT_DEVELOPER_EMAIL', 'Correo electrónico');
define('_AM_SOBJECT_DEVELOPER_LEAD', 'Desarrollador líder');
define('_AM_SOBJECT_DEVELOPER_WEBSITE', 'Sitio web');
define('_AM_SOBJECT_EDITING', 'Modificar');
define('_AM_SOBJECT_INDEX', 'Índice');
define('_AM_SOBJECT_LINK_NOT_FOUND', 'No se encontró el enlace seleccionado.');
define('_AM_SOBJECT_MODULE_BUG', 'Reportar un fallo de este módulo');
define('_AM_SOBJECT_MODULE_DEMO', 'Sitio Demo');
define('_AM_SOBJECT_MODULE_FEATURE', 'Sugerir una nueva característica para este módulo');
define('_AM_SOBJECT_MODULE_INFO', 'Detalles sobre el desarrollo del módulo');
define('_AM_SOBJECT_MODULE_RELEASE_DATE', 'Fecha de realización');
define('_AM_SOBJECT_MODULE_STATUS', 'Estado');
define('_AM_SOBJECT_MODULE_SUPPORT', 'Sitio oficial de soporte');
define('_AM_SOBJECT_SENT_LINK_DELETE_CONFIRM', '¿Realmente desea eliminar este enlace del sistema?');
define('_AM_SOBJECT_SENT_LINK_DISPLAY', 'Ver el enlace enviado');
define('_AM_SOBJECT_SENT_LINK_DISPLAY_INFO', 'Aquí está toda la información sobre el enlace enviado.');
define('_AM_SOBJECT_SENT_LINK_INFO', 'Información del enlace');
define('_AM_SOBJECT_SENT_LINK_VIEW', 'Ver mensaje');//view message
define('_AM_SOBJECT_SENT_LINKS', 'Enlaces enviados');
define('_AM_SOBJECT_SENT_LINKS_FROM', 'Desde Info');
define('_AM_SOBJECT_SENT_LINKS_GOTO', 'Ir al enlace');
define('_AM_SOBJECT_SENT_LINKS_INFO', 'Lista de los enlaces enviados por los usuarios a sus contactos o amigos.');
define('_AM_SOBJECT_SENT_LINKS_TO', 'A Info');
define('_AM_SOBJECT_TAG_CREATE', 'Crear una etiqueta');
define('_AM_SOBJECT_TAG_CREATE_INFO', 'Rellene este formulario para añadir una nueva etiqueta.');
define('_AM_SOBJECT_TAG_DELETE_CONFIRM', '¿Realmente desea eliminar esta etiqueta del sistema?');
define('_AM_SOBJECT_TAG_EDIT', 'Modificar una etiqueta');
define('_AM_SOBJECT_TAG_EDIT_INFO', 'Use este formulario para modificar la información de esta etiqueta.');
define('_AM_SOBJECT_TAG_INFO', 'Información de la etiqueta');
define('_AM_SOBJECT_TAG_NOT_FOUND', 'La etiqueta seleccionada no fue encontrada.');
define('_AM_SOBJECT_TAGS', 'Etiquetas');
define('_AM_SOBJECT_TAGS_DISPLAY', 'Ver etiqueta');
define('_AM_SOBJECT_TAGS_DISPLAY_INFO', 'Información de la etiqueta.');
define('_AM_SOBJECT_TAGS_INFO', 'Lista de las etiquetas disponibles');
define('_AM_SOBJECT_TAGS_VIEW', 'Ver etiqueta');

define('_AM_SOBJECT_PEOPLE_DEVELOPERS', 'Desarrolladores');
define('_AM_SOBJECT_PEOPLE_TESTERS', 'Probadores');
define('_AM_SOBJECT_PEOPLE_DOCUMENTERS', 'Documentadores');
define('_AM_SOBJECT_PEOPLE_TRANSLATERS', 'Traductores');
define('_AM_SOBJECT_PEOPLE_OTHER', 'Otros colaboradores');

define('_AM_SOBJECT_RATINGS', 'Puntuaciones');
define('_AM_SOBJECT_RATINGS_DSC', 'Lista de las puntuaciones añadidas al sistema.');
define('_AM_SOBJECT_RATING', 'Puntuación');
define('_AM_SOBJECT_RATINGS_CREATE', 'Añadir una puntuación');
define('_AM_SOBJECT_RATING_CREATE', 'Añadir una puntuación');
define('_AM_SOBJECT_RATINGS_CREATE_INFO', 'Rellene este formulario para añadir una puntuación.');
define('_AM_SOBJECT_RATING_DELETE_CONFIRM', '¿Realmente desea eliminar esta puntuación del sistema?');
define('_AM_SOBJECT_RATINGS_EDIT', 'Modificar una puntuación');
define('_AM_SOBJECT_RATINGS_EDIT_INFO', 'Use este formulario para modificar la información de esta puntuación.');
define('_AM_SOBJECT_RATINGS_INFO', 'Información de las puntuaciones');
define('_AM_SOBJECT_RATING_NOT_FOUND', 'La puntuación seleccionada no fue hallada.');
define('_AM_SOBJECT_RATINGS_CREATED', 'La puntuación fue creada con éxito.');
define('_AM_SOBJECT_RATINGS_MODIFIED', 'La puntuación fue modificada con éxito.');

define('_AM_SOBJECT_CURRENCIES', 'Divisa');
define('_AM_SOBJECT_CURRENCIES_DSC', 'Lista de las divisas añadidas al sistema.');
define('_AM_SOBJECT_CURRENCY', 'Divisa');
define('_AM_SOBJECT_CURRENCIES_CREATE', 'Añadir una divisa');
define('_AM_SOBJECT_CURRENCY_CREATE', 'Añadir una divisa');
define('_AM_SOBJECT_CURRENCIES_CREATE_INFO', 'Complete este formulario para añadir una divisa.');
define('_AM_SOBJECT_CURRENCY_DELETE_CONFIRM', '¿Realmente desea eliminar esta divisa del sistema?');
define('_AM_SOBJECT_CURRENCIES_EDIT', 'Modificar una divisa');
define('_AM_SOBJECT_CURRENCIES_EDIT_INFO', 'Use este formulario para modificar la información de esta divisa.');
define('_AM_SOBJECT_CURRENCIES_INFO', 'Información de la divisa');
define('_AM_SOBJECT_CURRENCY_NOT_FOUND', 'La divisa seleccionada no fue encontrada.');
define('_AM_SOBJECT_CURRENCIES_CREATED', 'La divisa fue creada con éxito.');
define('_AM_SOBJECT_CURRENCIES_MODIFIED', 'La información de la divisa fue modificada con éxito.');

define('_AM_SOBJECT_CURRENCY_UPDATE_ALL', 'Actualizar todas las divisas:');
define('_AM_SOBJECT_NO_RECORDS_TO_UPDATE', 'No hay registros a actualizar.');
define('_AM_SOBJECT_RECORDS_UPDATED', 'Registros actualizados.');
?>