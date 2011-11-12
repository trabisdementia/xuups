<?php

include_once XOOPS_ROOT_PATH . "/language/" . $GLOBALS['xoopsConfig']['language']
    . "/calendar.php";

define('_MD_EXTCAL_NAV_CALMONTH', 'Mois (calendrier)');
define('_MD_EXTCAL_NAV_CALWEEK', 'Semaine (calendrier)');
define('_MD_EXTCAL_NAV_YEAR', 'Année');
define('_MD_EXTCAL_NAV_MONTH', 'Mois');
define('_MD_EXTCAL_NAV_WEEK', 'Semaine');
define('_MD_EXTCAL_NAV_DAY', 'Jour');
define('_MD_EXTCAL_NAV_AGENDA_DAY', 'Agenda jour');
define('_MD_EXTCAL_NAV_AGENDA_WEEK', 'Agenda semaine');

define("_MD_EXTCAL_START", "Début");
define("_MD_EXTCAL_END", "Fin");
define('_MD_EXTCAL_RECCUR_RULE', 'Régles de récurrence');
define("_MD_EXTCAL_CONTACT_INFO", "Contact");
define("_MD_EXTCAL_EMAIL", "Email");
define("_MD_EXTCAL_URL", "URL");
define("_MD_EXTCAL_WHOS_GOING", "Qui vient ?");
define("_MD_EXTCAL_WHOSNOT_GOING", "Qui ne vient pas ?");
define("_MD_EXTCAL_ADD_ME", "Ajoutez-moi");
define("_MD_EXTCAL_REMOVE_ME", "Retirez-moi");
define("_MD_EXTCAL_POSTED_BY", "Posté par");

define('_MD_EXTCAL_SUBMITED_EVENT', 'Evènement soumis');

define('_MD_EXTCAL_SUBMIT_EVENT', 'Soumettre un évènement');
define('_MD_EXTCAL_EDIT_EVENT', 'Editer un évènement');
define('_MD_EXTCAL_TITLE', 'Titre');
define('_MD_EXTCAL_CATEGORY', 'Catégorie');
define('_MD_EXTCAL_DESCRIPTION', 'Description');
define('_MD_EXTCAL_NBMEMBER', 'Limite de participants');
define('_MD_EXTCAL_NBMEMBER_DESC', '0 = pas de limite');
define('_MD_EXTCAL_CONTACT', 'Contact');
define('_MD_EXTCAL_ADDRESS', 'Adresse');
define('_MD_EXTCAL_START_DATE', 'Début');
define('_MD_EXTCAL_END_DATE', 'Fin');
define('_MD_EXTCAL_EVENT_END', 'A une fin ?');
define('_MD_EXTCAL_FILE_ATTACHEMENT', 'Attacher un fichier');
define('_MD_EXTCAL_PREVIEW', 'Prévisualisation');
define('_MD_EXTCAL_EVENT_CREATED', 'Evènement créé');
define('_MD_EXTCAL_MAX_MEMBER_REACHED', 'Le nombre maximum de participant est atteint');
define('_MD_EXTCAL_WHOS_GOING_ADDED_TO_EVENT', 'Ajouté aux participants');
define('_MD_EXTCAL_WHOS_GOING_REMOVED_TO_EVENT', 'Supprimé des participants');
define('_MD_EXTCAL_WHOSNOT_GOING_ADDED_TO_EVENT', 'Ajouté aux non participants');
define('_MD_EXTCAL_WHOSNOT_GOING_REMOVED_TO_EVENT', 'Supprimé des non participants');

define('_MD_EXTCAL_WRONG_DATE_FORMAT', 'Mauvais format de date');
define('_MD_EXTCAL_NO_RECCUR_EVENT', 'Evènement non réccurent');
define('_MD_EXTCAL_RECCUR_POLICY', 'Type de récurence');
define('_MD_EXTCAL_DAILY', 'Journalière');
define('_MD_EXTCAL_WEEKLY', 'Hebdomadaire');
define('_MD_EXTCAL_MONTHLY', 'Mensuelle');
define('_MD_EXTCAL_YEARLY', 'Annuelle');
define('_MD_EXTCAL_DURING', 'Pendant');
define('_MD_EXTCAL_DAYS', 'jour(s)');
define('_MD_EXTCAL_WEEKS', 'semaine(s)');
define('_MD_EXTCAL_MONTH', 'mois');
define('_MD_EXTCAL_ON', 'le');
define('_MD_EXTCAL_OR_THE', 'ou le');
define('_MD_EXTCAL_DAY_NUM_MONTH', '(Jour du mois)');
define('_MD_EXTCAL_YEARS', 'année(s)');
define('_MD_EXTCAL_SAME_ST_DATE', 'Identique à la date de début');

define('_MD_EXTCAL_1_MO', '1er ' . _CAL_MONDAY);
define('_MD_EXTCAL_1_TU', '1er ' . _CAL_TUESDAY);
define('_MD_EXTCAL_1_WE', '1er ' . _CAL_WEDNESDAY);
define('_MD_EXTCAL_1_TH', '1er ' . _CAL_THURSDAY);
define('_MD_EXTCAL_1_FR', '1er ' . _CAL_FRIDAY);
define('_MD_EXTCAL_1_SA', '1er ' . _CAL_SATURDAY);
define('_MD_EXTCAL_1_SU', '1er ' . _CAL_SUNDAY);
define('_MD_EXTCAL_2_MO', '2nd ' . _CAL_MONDAY);
define('_MD_EXTCAL_2_TU', '2nd ' . _CAL_TUESDAY);
define('_MD_EXTCAL_2_WE', '2nd ' . _CAL_WEDNESDAY);
define('_MD_EXTCAL_2_TH', '2nd ' . _CAL_THURSDAY);
define('_MD_EXTCAL_2_FR', '2nd ' . _CAL_FRIDAY);
define('_MD_EXTCAL_2_SA', '2nd ' . _CAL_SATURDAY);
define('_MD_EXTCAL_2_SU', '2nd ' . _CAL_SUNDAY);
define('_MD_EXTCAL_3_MO', '3eme ' . _CAL_MONDAY);
define('_MD_EXTCAL_3_TU', '3eme ' . _CAL_TUESDAY);
define('_MD_EXTCAL_3_WE', '3eme ' . _CAL_WEDNESDAY);
define('_MD_EXTCAL_3_TH', '3eme ' . _CAL_THURSDAY);
define('_MD_EXTCAL_3_FR', '3eme ' . _CAL_FRIDAY);
define('_MD_EXTCAL_3_SA', '3eme ' . _CAL_SATURDAY);
define('_MD_EXTCAL_3_SU', '3eme ' . _CAL_SUNDAY);
define('_MD_EXTCAL_4_MO', '4eme ' . _CAL_MONDAY);
define('_MD_EXTCAL_4_TU', '4eme ' . _CAL_TUESDAY);
define('_MD_EXTCAL_4_WE', '4eme ' . _CAL_WEDNESDAY);
define('_MD_EXTCAL_4_TH', '4eme ' . _CAL_THURSDAY);
define('_MD_EXTCAL_4_FR', '4eme ' . _CAL_FRIDAY);
define('_MD_EXTCAL_4_SA', '4eme ' . _CAL_SATURDAY);
define('_MD_EXTCAL_4_SU', '4eme' . _CAL_SUNDAY);
define('_MD_EXTCAL_LAST_MO', 'Dernier ' . _CAL_MONDAY);
define('_MD_EXTCAL_LAST_TU', 'Dernier ' . _CAL_TUESDAY);
define('_MD_EXTCAL_LAST_WE', 'Dernier ' . _CAL_WEDNESDAY);
define('_MD_EXTCAL_LAST_TH', 'Dernier ' . _CAL_THURSDAY);
define('_MD_EXTCAL_LAST_FR', 'Dernier ' . _CAL_FRIDAY);
define('_MD_EXTCAL_LAST_SA', 'Dernier ' . _CAL_SATURDAY);
define('_MD_EXTCAL_LAST_SU', 'Dernier ' . _CAL_SUNDAY);
define('_MD_EXTCAL_MO2', 'Lu');
define('_MD_EXTCAL_TU2', 'Ma');
define('_MD_EXTCAL_WE2', 'Me');
define('_MD_EXTCAL_TH2', 'Je');
define('_MD_EXTCAL_FR2', 'Ve');
define('_MD_EXTCAL_SA2', 'Sa');
define('_MD_EXTCAL_SU2', 'Di');
define('_MD_EXTCAL_JAN', 'Jan');
define('_MD_EXTCAL_FEB', 'Fev');
define('_MD_EXTCAL_MAR', 'Mar');
define('_MD_EXTCAL_APR', 'Avr');
define('_MD_EXTCAL_MAY', 'Mai');
define('_MD_EXTCAL_JUN', 'Jun');
define('_MD_EXTCAL_JUL', 'Jui');
define('_MD_EXTCAL_AUG', 'Aou');
define('_MD_EXTCAL_SEP', 'Sep');
define('_MD_EXTCAL_OCT', 'Oct');
define('_MD_EXTCAL_NOV', 'Nov');
define('_MD_EXTCAL_DEC', 'Dec');

define('_MD_EXTCAL_RR_DAILY', 'Tous les jours pendant %u jours');
define('_MD_EXTCAL_RR_WEEKLY', 'Toutes les semaines, le%s pendant %u semaines');
define('_MD_EXTCAL_RR_MONTHLY', 'Tous les mois, le %s pendant %u mois');
define('_MD_EXTCAL_RR_YEARLY', 'Toutes les années, le%s le %s, pendant %u années');


/**
 * @translation     AFUX (Association Francophone des Utilisateurs de Xoops) <http://www.afux.org/>
 * @specification   _LANGCODE: fr
 * @specification   _CHARSET: UTF-8
 *
 * @version         $Id$
 **/

?>
