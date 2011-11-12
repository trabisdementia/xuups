<?php
//Traducción por debianus. Sugerencias y reporte de errores en http://es.impresscms.org
/**
 * $Id: common.php 1190 2008-03-07 20:49:22Z fx2024 $
 * Module: SmartContent
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

define('_CO_OBJ_ALL', "Todos"); // deprecated
define('_CO_OBJ_FILTER', "Filtro");
define('_CO_OBJ_NONE', "Ninguno");
define('_CO_OBJ_SHOW_ONLY', 'Solo mostrar');
define('_CO_OBJ_SORT_BY', "Ordenar por");
define('_CO_SOBJECT_ACTIONS', 'Acciones');
define('_CO_SOBJECT_ADMIN_PAGE', ':: Administración ::');
define('_CO_SOBJECT_ALL', "Todos");
define('_CO_SOBJECT_APPROVE', 'Aprobar');
define('_CO_SOBJECT_AUTHOR_WORD', "Palabras del autor");
define('_CO_SOBJECT_BODY_DEFAULT', "Este es un interesante enlace que he encontrado en %s :%s");
define('_CO_SOBJECT_CANCEL', 'Cancelar');
define('_CO_SOBJECT_CURRENCY_ISO4217', 'Código ISO 4217');
define('_CO_SOBJECT_CURRENCY_ISO4217_DSC', 'Código oficial de la divisa. Más información: <a href="http://en.wikipedia.org/wiki/ISO_4217" target="_blank">ISO 4217 en la Wikipedia</a>');
define('_CO_SOBJECT_CURRENCY_NAME', 'Nombre');
define('_CO_SOBJECT_CURRENCY_NAME_DSC', '');
define('_CO_SOBJECT_CURRENCY_SYMBOL', 'Símbolo');
define('_CO_SOBJECT_CURRENCY_SYMBOL_DSC', '');
define('_CO_SOBJECT_CURRENCY_RATE', 'Tasa de conversión');
define('_CO_SOBJECT_CURRENCY_RATE_DSC', '');
define('_CO_SOBJECT_CURRENCY_DEFAULT', 'Divisa predeterminada');
define('_CO_SOBJECT_CURRENCY_DEFAULT_DSC', '');
define('_CO_SOBJECT_CATEGORY_CREATE', 'Crear una categoría');
define('_CO_SOBJECT_CATEGORY_CREATE_SUCCESS', 'La categoría fue creada con éxito.');
define('_CO_SOBJECT_CATEGORY_DESCRIPTION', 'Descripción');
define('_CO_SOBJECT_CATEGORY_DESCRIPTION_DSC', 'Description de esta categoría');
define('_CO_SOBJECT_CATEGORY_EDIT', 'Información de la categoría');
define('_CO_SOBJECT_CATEGORY_EDIT_INFO', 'Complete este formulario para modificar esta categoría.');
define('_CO_SOBJECT_CATEGORY_IMAGE', 'Imagen');
define('_CO_SOBJECT_CATEGORY_IMAGE_DSC', 'Imagen de la categoría');
define('_CO_SOBJECT_CATEGORY_MODIFY_SUCCESS', 'La categoría fue modificada con éxito.');
define('_CO_SOBJECT_CATEGORY_NAME', 'Nombre de la categoría');
define('_CO_SOBJECT_CATEGORY_NAME_DSC', 'Nombre de esta categoría');
define('_CO_SOBJECT_CATEGORY_PARENTID', 'Categoría raíz');
define('_CO_SOBJECT_CATEGORY_PARENTID_DSC', 'Categoría a la que pertenece la presente como subcategoría de la misma.');
define('_CO_SOBJECT_CLOSE_WINDOW', "Haga clic aquí para cerrar esta ventana.");
define('_CO_SOBJECT_COUNTER_FORM_CAPTION', 'Contador de visitas');//Hit counter
define('_CO_SOBJECT_CREATE', 'Crear');
define('_CO_SOBJECT_CREATINGNEW', 'Creando');
define('_CO_SOBJECT_CUSTOM_CSS', 'CSS');
define('_CO_SOBJECT_CUSTOM_CSS_DSC', 'Puede especificar información particularizada de CSS aquí. Este CSS será ejecutado cuando el objeto sea mostrado a los usuarios.');
define('_CO_SOBJECT_DELETE', 'Eliminar');
define('_CO_SOBJECT_DELETE_CONFIRM', "¿Realmente desea eliminar '<em>%s</em>' ?");
define('_CO_SOBJECT_DELETE_ERROR', 'Se produjo un error en la eliminación del objeto.');
define('_CO_SOBJECT_DELETE_SUCCESS', 'El objecto fue eliminado con éxito.');
define('_CO_SOBJECT_DEVELOPER_CONTRIBUTOR', 'Colaborador(es)');
define('_CO_SOBJECT_DEVELOPER_CREDITS', 'Créditos');
define('_CO_SOBJECT_DEVELOPER_EMAIL', 'Correo electrónico');
define('_CO_SOBJECT_DEVELOPER_WEBSITE', 'Sitio web');
define('_CO_SOBJECT_DISPLAY_OPTIONS', "Mostrar opciones");
define('_CO_SOBJECT_DOBR_FORM_CAPTION', 'Activar "linebreak"');
define('_CO_SOBJECT_DOHTML_FORM_CAPTION', 'Activar etiquetas HTML');
define('_CO_SOBJECT_DOHTML_FORM_DSC', "");
define('_CO_SOBJECT_DOIMAGE_FORM_CAPTION', 'Activar imágenes');
define('_CO_SOBJECT_DOIMAGE_FORM_DCS', "");
define('_CO_SOBJECT_DOSMILEY_FORM_CAPTION', 'Activar caritas');
define('_CO_SOBJECT_DOSMILEY_FORM_DSC', "");
define('_CO_SOBJECT_DOXCODE_FORM_CAPTION', 'Activar códigos de ImpressCMS');
define('_CO_SOBJECT_DOXCODE_FORM_DSC', "");
define('_CO_SOBJECT_EDITING', 'Modificando');
define('_CO_SOBJECT_EMAIL', 'Enviar este enlace');
define('_CO_SOBJECT_EMAIL_BODY', 'Esto es algo interesante que he encontrado en %s');
define('_CO_SOBJECT_EMAIL_SUBJECT', 'Mira esta página de %s');
define('_CO_SOBJECT_GOTOMODULE', 'Ir al módulo');
define('_CO_SOBJECT_LANGUAGE_CAPTION', "Lenguaje");
define('_CO_SOBJECT_LANGUAGE_DSC', "Lenguaje relativo a este objeto");
define('_CO_SOBJECT_LIMIT', "Mostrar");
define('_CO_SOBJECT_LIMIT_ALL', 'Todos');
define('_CO_SOBJECT_LINK_BODY', "Cuerpo");
define('_CO_SOBJECT_LINK_BODY_DSC', "");
define('_CO_SOBJECT_LINK_DATE', "Fecha");
define('_CO_SOBJECT_LINK_FROM_EMAIL', "Desde email");
define('_CO_SOBJECT_LINK_FROM_EMAIL_DSC', "");
define('_CO_SOBJECT_LINK_FROM_NAME', "Desde nombre");
define('_CO_SOBJECT_LINK_FROM_NAME_DSC', "");
define('_CO_SOBJECT_LINK_FROM_UID', "Desde usuario");
define('_CO_SOBJECT_LINK_FROM_UID_DSC', "");
define('_CO_SOBJECT_LINK_LINK', "Enlace");
define('_CO_SOBJECT_LINK_LINK_DSC', "");
define('_CO_SOBJECT_LINK_MID', "ID del módulo");
define('_CO_SOBJECT_LINK_MID_DSC', "");
define('_CO_SOBJECT_LINK_MID_NAME', "Nombre del módulo");
define('_CO_SOBJECT_LINK_MID_NAME_DSC', "Nombre del módulo desde el que se originó la petición");
define('_CO_SOBJECT_LINK_SUBJECT', "Asunto");
define('_CO_SOBJECT_LINK_SUBJECT_DSC', "");
define('_CO_SOBJECT_LINK_TO_EMAIL', "A correo electrónico");
define('_CO_SOBJECT_LINK_TO_EMAIL_DSC', "");
define('_CO_SOBJECT_LINK_TO_NAME', "A nombre");
define('_CO_SOBJECT_LINK_TO_NAME_DSC', "");
define('_CO_SOBJECT_LINK_TO_UID', "A usuario");
define('_CO_SOBJECT_LINK_TO_UID_DSC', "");
define('_CO_SOBJECT_MAKE_SELECTION', 'Seleccione...');
define('_CO_SOBJECT_META_DESCRIPTION', 'Meta descripción');
define('_CO_SOBJECT_META_DESCRIPTION_DSC', 'Para tener más éxito en los buscadores, puede personalizar la meta descripción que le gustaría usar para este artículo. Si deja este campo en blanco cuando cree una categoría, automáticamente se usará como meta descripción el resumen de este artículo.');
define('_CO_SOBJECT_META_KEYWORDS', 'Palabras clave');
define('_CO_SOBJECT_META_KEYWORDS_DSC', 'Para tener más éxito en los buscadores puede personalizar las palabras clave que le gustaría usar para este artículo. Si deja el campo en blanco se usarán las contenidas en su resumen.');
define('_CO_SOBJECT_MODIFY', 'Modificar');
define('_CO_SOBJECT_MODULE_BUG', 'Reportar un error de este módulo');
define('_CO_SOBJECT_MODULE_DEMO', 'Sitio demo');
define('_CO_SOBJECT_MODULE_DISCLAIMER', 'Limitación de responsabilidad');
define('_CO_SOBJECT_MODULE_FEATURE', 'Sugerir una nueva característica para este módulo');
define('_CO_SOBJECT_MODULE_INFO', 'Información del desarrollo del módulo');
define('_CO_SOBJECT_MODULE_RELEASE_DATE', 'Fecha de realización');
define('_CO_SOBJECT_MODULE_STATUS', 'Estado');
define('_CO_SOBJECT_MODULE_SUBMIT_BUG', 'Reportar un fallo');
define('_CO_SOBJECT_MODULE_SUBMIT_FEATURE', 'Solicitar una característica');
define('_CO_SOBJECT_MODULE_SUPPORT', 'Sitio oficial de soporte');
define('_CO_SOBJECT_NO_OBJECT', 'No hay items para mostrar.');
define('_CO_SOBJECT_NOT_SELECTED', 'No hay objeto seleccionado.');
define('_CO_SOBJECT_PRINT', 'Imprimir');
define('_CO_SOBJECT_QUICK_SEARCH', 'Búsqueda rápida');
define('_CO_SOBJECT_RATING_DATE', 'Fecha');
define('_CO_SOBJECT_RATING_DIRNAME', 'Módulo');
define('_CO_SOBJECT_RATING_ITEM', 'Ítem');
define('_CO_SOBJECT_RATING_ITEMID', 'Ítem ID');
define('_CO_SOBJECT_RATING_NAME', 'Nombre de usuario');
define('_CO_SOBJECT_RATING_RATE', 'Puntuación');
define('_CO_SOBJECT_RATING_UID', 'Usuario');
define('_CO_SOBJECT_SAVE_ERROR', 'Ocurrió un error al almacenar la información.');
define('_CO_SOBJECT_SAVE_SUCCESS', 'La información fue guardada con éxito.');
define('_CO_SOBJECT_SEND_EMAIL', 'Enviar un correo electrónico');
define('_CO_SOBJECT_SEND_ERROR', "Ocurrió un problema al enviar el mensaje y rogamos disculpas. Por favor, contacte con el administrador en %s.");
define('_CO_SOBJECT_SEND_LINK_FORM', "Enviar este enlace a un amigo");
define('_CO_SOBJECT_SEND_LINK_FORM_DSC', "Complete el siguiente formulario para compartir este enlace con un amigo.");
define('_CO_SOBJECT_SEND_PM', 'Enviar un mensaje privado');
define('_CO_SOBJECT_SEND_SUCCESS', "El mensaje fue enviado con éxito.");
define('_CO_SOBJECT_SEND_SUCCESS_INFO', "Gracias por compartir su interés en nuestro sitio con sus amigos.");
define('_CO_SOBJECT_SHORT_URL', 'URL abreviadas');
define('_CO_SOBJECT_SHORT_URL_DSC', 'Cuando use la característica de SEO de este módulo, puede especificar una URL abreviada para esta categoría. Este campo es opcional.');
define('_CO_SOBJECT_SORT', "Ordenar en sentido:");
define('_CO_SOBJECT_SORT_ASC', 'ascendente ');
define('_CO_SOBJECT_SORT_DESC', 'descendente ');
define('_CO_SOBJECT_SUBJECT_DEFAULT', "Un enlace procedente de %s");
define('_CO_SOBJECT_SUBMIT', 'Enviar');
define('_CO_SOBJECT_TAG_DESCRIPTION_CAPTION', "Descripción");
define('_CO_SOBJECT_TAG_DESCRIPTION_DSC', "Descripción de esta etiqueta (donde será usada, etc...)");
define('_CO_SOBJECT_TAG_TAGID_CAPTION', "Nombre de la etiqueta");
define('_CO_SOBJECT_TAG_TAGID_DSC', "Nombre que servirá para identificar esta etiqueta");
define('_CO_SOBJECT_TAG_VALUE_CAPTION', "Valor");
define('_CO_SOBJECT_TAG_VALUE_DSC', "Valor de esta etiqueta; por ejemplo: que será mostrada al usuario");
define('_CO_SOBJECT_UPDATE_MODULE', 'Actualizar el módulo');
define('_CO_SOBJECT_UPLOAD_IMAGE', 'Enviar una nueva imagen:');
define('_CO_SOBJECT_VERSION_HISTORY', 'Historial de las versiones');
define('_CO_SOBJECT_WARNING_BETA', "Este módulo se proporciona como es, sin ninguna garantía. Este módulo es BETA, lo que significa que todavía está en activo desarrollo. Esta versión es proporcionada <b>solo con la finalidad de testear</b> y nosotros <b>encarecidamente</b> recomendamos que no la use en un sitio web final.");
define('_CO_SOBJECT_WARNING_FINAL', "Este módulo se proporciona como es, sin ninguna garantía. Aunque no es una versión beta todavía está bajo desarrollo. Esta versión puede ser usada en un sitio web o entorno de producción pero bajo su propia responsabilidad; el autor no es responsable.");
define('_CO_SOBJECT_WARNING_RC', "Este módulo se proporciona como es, sin ninguna garantía. Este módulo es una Versión Candidata y no debería ser usada en un 'production web site'. Está todavía bajo desarrollo y su lo usa es bajo su propia responsabilidad, lo que significa que su autor no es responsable.");
define('_CO_SOBJECT_WEIGHT_FORM_CAPTION', 'Importancia');//Weight
define('_CO_SOBJECT_WEIGHT_FORM_DSC', "");

define('_CO_SOBJECT_ADMIN_VIEW', "Ver");
define('_CO_SOBJECT_EXPORT', "Exportar");
define('_CO_SOBJECT_UPDATE_ALL', "Actualizar todo");
define('_CO_SOBJECT_NO_RECORDS_TO_UPDATE', "No hay registros a actualizar");
define('_CO_SOBJECT_NO_RECORDS_UPDATED', "Los objetos se actualizaron con éxito");

define('_CO_SOBJECT_CLONE', "Duplicar este objeto");

define('_AM_SCONTENT_CATEGORY_VIEW', "Vista de categoría");

define('_CO_SOBJECT_BLOCKS_ADDTO_LAYOUT', "Estructura: ");
define('_CO_SOBJECT_BLOCKS_ADDTO_LAYOUT_OPTION0', "Horizontal 1 fila");
define('_CO_SOBJECT_BLOCKS_ADDTO_LAYOUT_OPTION1', "Horizontal 2 filas");
define('_CO_SOBJECT_BLOCKS_ADDTO_LAYOUT_OPTION2', "Vertical con iconos");
define('_CO_SOBJECT_BLOCKS_ADDTO_LAYOUT_OPTION3', "Vertical sin iconos");
define('_CO_SOBJECT_CURRENT_FILE', "Archivo actual: ");
define('_CO_SOBJECT_URL_FILE_DSC', "Alternativamente puede usar un URL. Si selecciona un archivo usando el botón 'Examinar', el URL será ignorado. Puede usar la etiqueta {XOOPS_URL} para imprimir".XOOPS_URL);
define('_CO_SOBJECT_URL_FILE', "URL: ");
define('_CO_SOBJECT_UPLOAD', "Seleccione el archivo a enviar: ");

define('_CO_SOBJECT_CHANGE_FILE', "<hr/><b>Cambiar el archivo</b><br/>");
define('_CO_SOBJECT_CAPTION', "Subtítulo: ");
define('_CO_SOBJECT_URLLINK_URL', "URL: ");
define('_CO_SOBJECT_DESC', "Descripción");
define('_CO_SOBJECT_URLLINK_TARGET', "Abrir el enlace en:");
define('_CO_SOBJECT_URLLINK_SELF', "la misma ventana");
define('_CO_SOBJECT_URLLINK_BLANK', "una nueva ventana");

define('_CO_SOBJECT_ANY', "Cualquiera");
define('_CO_SOBJECT_EDITOR', "Editor de texto preferido");
define('_CO_SOBJECT_WITH_SELECTED', "Con seleccionado: ");

?>