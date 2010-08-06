<?php
//Traducción por debianus. Sugerencias y reporte de errores en http://es.impresscms.org
/**
 * $Id: smartdbupdater.php 159 2007-12-17 16:44:05Z malanciault $
 * Module: SmartContent
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */
if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

define("_SDU_IMPORT", "Importar");
define("_SDU_CURRENTVER", "Versión actual: <span class='currentVer'>%s</span>");
define("_SDU_DBVER", "Versión de la base de datos %s");
define("_SDU_MSG_ADD_DATA", "Datos añadidos en la tabla %s");
define("_SDU_MSG_ADD_DATA_ERR", "Error al añadir los datos en la tabla %s");
define("_SDU_MSG_CHGFIELD", "Cambiar el campo %s en la tabla %s");
define("_SDU_MSG_CHGFIELD_ERR", "Error al cambiar el campo %s en la tabla %s");
define("_SDU_MSG_CREATE_TABLE", "Tabla %s creada");
define("_SDU_MSG_CREATE_TABLE_ERR", "Error al crear la tabla %s");
define("_SDU_MSG_NEWFIELD", "Se adicionó con éxito el campo %s");
define("_SDU_MSG_NEWFIELD_ERR", "Error al adicionar el campo %s");
define("_SDU_NEEDUPDATE", "Su base de datos necesita una actualización. Por favor, actualice la tablas de la misma.<br><b>Nota: SmartFactory recomienda encarecidamente que haga una copia de seguridad de todas las tablas del módulo SmartSections antes de ejecutar el script de actualización.</b><br>");
define("_SDU_NOUPDATE", "Su base de datos está actualizada.");
define("_SDU_UPDATE_DB", "Actualizando la base de datos");
define("_SDU_UPDATE_ERR", "Se produjeron errores al actualizar a la versión %s");
define("_SDU_UPDATE_NOW", "Actualizar ahora");
define("_SDU_UPDATE_OK", "Actualización con éxito a la versión %s");
define("_SDU_UPDATE_TO", "Actualizando a la versión %s");
define("_SDU_UPDATE_UPDATING_DATABASE", "Actualizando la base de datos...");
define("_SDU_MSG_DROPFIELD", "Se eliminó con éxito el campo %s");

?>