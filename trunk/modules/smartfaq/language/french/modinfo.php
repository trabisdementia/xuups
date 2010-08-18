<?php

/**
* $Id: modinfo.php,v 1.22 2005/08/15 16:52:05 fx2024 Exp $
* Module: SmartFAQ
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

// Module Info
// The name of this module
global $xoopsModule;
define('_MI_SF_MD_NAME', 'SmartFAQ');

// A brief description of this module
define('_MI_SF_MD_DESC', 'Syst&egrave;me de gestion de Q&amp;R avanc&eacute;e pour votre site XOOPS');

// Sub menus in main menu block
define('_MI_SF_SUB_SMNAME1', 'Proposer une Q&amp;R');
define('_MI_SF_SUB_SMNAME2', 'Soumettre une Question');
define('_MI_SF_SUB_SMNAME3', 'Questions Ouvertes');
define('_MI_SF_SUB_SMNAME4', 'Mod&eacute;ration');

// Config options
define('_MI_SF_ALLOWSUBMIT', 'Propositions des utilisateurs :');
define('_MI_SF_ALLOWSUBMITDSC', 'Permettre aux utilisateurs de proposer une Q&amp;R sur votre site?');

define("_MI_SF_ALLOWREQUEST", "Demandes d'utilisateur :");
define('_MI_SF_ALLOWREQUESTDSC', 'Permettre aux utilisateurs de demander une Q&amp;R sur votre site?');

define("_MI_SF_NEWANSWER", "Permettre l'envoie de nouvelles r&eacute;ponses :");
define("_MI_SF_NEWANSWERDSC", "Choisissez 'Oui' pour permettre aux utilisateurs de proposer de nouvelles r&eacute;ponses pour des FAQ d&eacute;j&agrave; publi&eacute;es.");

define('_MI_SF_ANONPOST', 'Permettre aux anonymes de poster des messages');
define('_MI_SF_ANONPOSTDSC', 'Permettre aux utilisateurs anonymes de proposer ou demander une nouvelle Q&amp;R.');

define('_MI_SF_DATEFORMAT', 'Format de la date :');
define("_MI_SF_DATEFORMATDSC", "Utilisez la fin de language/french/global.php pour choisir de montrer un style. Exemple: 'd-M-Y H:i' traduits en '30-Mar-2004 22:35'");

define('_MI_SF_DISPLAY_COLLAPS', 'Afficher les barres r&eacute;tractables?');
define('_MI_SF_DISPLAY_COLLAPSDSC', "Choisissez 'Oui' pour afficher les barres r&eacute;tractables dans les page index et cat&eacute;gories du module.");

define("_MI_SF_DISPLAYTYPE", "Montrer les types de Q&amp;R :");
define('_MI_SF_DISPLAYTYPEDSC', 'Si Vue r&eacute;sum&eacute;e est s&eacute;lectionn&eacute;e, seule la question, la date et les clics de chaque Q&amp;R seront montr&eacute;s dans la cat&eacute;gorie choisie. Si Vue compl&egrave;te est s&eacute;lectionn&eacute;e, chaque Q&amp;R sera montr&eacute;e enti&egrave;rement dans la cat&eacute;gorie choisie.');
define('_MI_SF_DISPLAYTYPE_SUMMARY', 'Vue r&eacute;sum&eacute;e');
define('_MI_SF_DISPLAYTYPE_FULL', 'Vue compl&egrave;te');

define('_MI_SF_DISPLAY_LAST_FAQ', "Afficher la colonne 'Derni&egrave;re Q&amp;R'");
define('_MI_SF_DISPLAY_LAST_FAQDSC', "Choisissez 'Oui' pour afficher une colonne 'Derni&egrave;re Q&amp;R' pour chacune des cat&eacute;gories sur la page d'index et des cat&eacute;gories.");

define('_MI_SF_DISPLAY_LAST_FAQS', 'Afficher les derni&egrave;res Q&amp;As?');
define('_MI_SF_DISPLAY_LAST_FAQSDSC', "Selectionnez 'OUI' pour afficher les derni&egrave;res Q&amp;R.");
define('_MI_SF_LAST_FAQ_SIZE', "Taille des 'derni&egrave;res Q&amp;R' :");
define('_MI_SF_LAST_FAQ_SIZEDSC', "Param&egrave;trer la taille maximum des questions dans la colonne des derni&egrave;res Q&amp;R.");

define('_MI_SF_QUESTION_SIZE', "Taille de la question :");
define('_MI_SF_QUESTION_SIZEDSC', "Param&egrave;trer la taille maximum de la question en tant que titre dans le page d'affichage unique de la Q&amp;R.");
define('_MI_SF_DISPLAY_SUBCAT_INDEX', 'Affichez les sous-categories');
define('_MI_SF_DISPLAY_SUBCAT_INDEXDSC', "S&eacute;lectonnez 'Oui' pour afficher les sous cat&eacute;gories sur la page d index.");

define('_MI_SF_DISPLAY_TOPCAT_DSC', 'Afficher la description des cat&eacute;gories?');
define('_MI_SF_DISPLAY_TOPCAT_DSCDSC', "S&eacute;lectionnez 'Oui' pour afficher la description des cat&eacute;gories sur la page d index.");

define('_MI_SF_DISPLAY_SBCAT_DSC', 'Afficher la description des sous-cat&eacute;gories?');
define('_MI_SF_DISPLAY_SBCAT_DSCDSC', "Choisissez 'Oui' pour afficher la description des sous-cat&eacute;gories sur la page d'index et des cat&eacute;gories.");

define('_MI_SF_ORDERBYDATE', 'Trier les Q&amp;R par date :');
define('_MI_SF_ORDERBYDATEDSC', "Si vous choisissez 'Oui', Les Q&amp;R contenues dans la Cat&eacute;gorie seront ordonn&eacute;es par date descendante, sinon, elles seront ordonn&eacute;es par leur poids.");

define('_MI_SF_DISPLAY_DATE_COL', "Afficher la colonne 'Publi&eacute; le'?");
define('_MI_SF_DISPLAY_DATE_COLDSC', "Lorsque 'Vue sommaire' est s&eacute;lectionn&eacute; comme type d'affichage, choisissez 'Oui' pour afficher la colonne 'Publi&eacute; le' dans le tableau des Q&amp;R sur les pages index et cat&eacute;gories.");

define('_MI_SF_DISPLAY_HITS_COL', "Afficher la colonne 'Clics'?");
define('_MI_SF_DISPLAY_HITS_COLDSC', "Lorsque 'Vue sommaire' est s&eacute;lectionn&eacute; comme type d'affichage, choisissez 'Oui' pour afficher la colonne 'Clics' dans le tableau des Q&amp;R sur les pages index et cat&eacute;gories.");

define('_MI_SF_USEIMAGENAVPAGE', 'Utilisez les images sur la page de navigation :');
define("_MI_SF_USEIMAGENAVPAGEDSC", "Si vous choisissez 'Oui', la page de navigation sera montr&eacute;e avec une image, sinon, la page de navigation originale sera utilis&eacute;e.");

define('_MI_SF_ALLOWCOMMENTS', 'Contr&ocirc;le des commentaires au niveau des Q&amp;R :');
define("_MI_SF_ALLOWCOMMENTSDSC", "Si vous choisissez 'Oui', vous verrez les commentaires uniquement sur les Q&amp;R ayant la case commentaires coch&eacute;e. <br/><br/>Choisissez 'Non' pour g&eacute;rer les commentaires &agrave; un niveau global (voir ci-dessous la balise 'R&egrave;gles des Commentaires'.");

define("_MI_SF_ALLOWADMINHITS", "Compter les lectures de l'administrateur :");
define("_MI_SF_ALLOWADMINHITSDSC", "Ajouter les lectures de l'administrateur dans les statistiques?");

define('_MI_SF_AUTOAPPROVE_SUB_FAQ', 'Les Q&amp;R propos&eacute;es sont automatiquement approuv&eacute;es :');
define("_MI_SF_AUTOAPPROVE_SUB_FAQ_DSC", "Approbation automatique des Q&amp;R propos&eacute;es sans intervention de l'administrateur.");

define('_MI_SF_AUTOAPPROVE_REQUEST', 'Les demandes de Q&amp;R sont automatiquement approuv&eacute;es :');
define("_MI_SF_AUTOAPPROVE_REQUEST_DSC", "Approbation automatique des Q&amp;R demand&eacute;es sans intervention de l'administrateur.");

define('_MI_SF_AUTOAPPROVE_ANS', 'Les r&eacute;ponses sont automatiquement approuv&eacute;es :');
define('_MI_SF_AUTOAPPROVE_ANS_DSC', 'Approbation automatique des r&eacute;ponses pour les Q&amp;R sans r&eacute;ponse.');

define('_MI_SF_AUTOAPPROVE_ANS_NEW', 'Auto Approbation de nouvelle r&eacute;ponse:');
define('_MI_SF_AUTOAPPROVE_ANS_NEW_DSC', 'Auto approuver les r&eacute;ponses soumises pour les Q&amp;R publi&eacute;es.');

define('_MI_SF_LASTFAQSPERCAT', 'Maximum des derni&egrave;res Q&amp;R par cat&eacute;gorie :');
define('_MI_SF_LASTFAQSPERCATDSC', 'Nombre Maximum de Q&amp;R &agrave; montrer dans la colonne infos de la cat&eacute;gorie.');

define('_MI_SF_CATPERPAGE', 'Maximum de Cat&eacute;gories par page (c&ocirc;t&eacute; utilisateur):');
define('_MI_SF_CATPERPAGEDSC', 'Nombre Maximum de cat&eacute;gories &agrave; montrer par page c&ocirc;t&eacute; utilisateur.');

define('_MI_SF_PERPAGE', 'Maximum de Q&amp;R par page (C&ocirc;t&eacute; Admin):');
define("_MI_SF_PERPAGEDSC", "Nombre maximum de Q&amp;R &agrave; montrer par page dans l'administration des Q&amp;R.");

define('_MI_SF_PERPAGEINDEX', 'Maximum de Q&amp;R par page (C&ocirc;t&eacute; utilisateur):');
define('_MI_SF_PERPAGEINDEXDSC', 'Nombre maximum de Q&amp;R &agrave; montrer par page pour les visiteurs.');

define('_MI_SF_INDEXWELCOMEMSG', 'Index message de bienvenue:');
define('_MI_SF_INDEXWELCOMEMSGDSC', 'Message de bienvenue &agrave; montrer dans la page index du module.');
define("_MI_SF_INDEXWELCOMEMSGDEF", "Dans cet espace de votre site, vous trouverez les r&eacute;ponses aux questions fr&eacute;quemment pos&eacute;es, ainsi que les r&eacute;ponses &agrave; 'Comment fais-je' et les questions 'Le saviez-vous'. Merci de nous faire part de vos commentaires sur ces Q&amp;R."); 

define("_MI_SF_REQUESTINTROMSG", "Message d'introduction des demandes :");
define("_MI_SF_REQUESTINTROMSGDSC", "Message d'introduction &agrave; montrer en cas de demande de Q&amp;R sur un module.");
define("_MI_SF_REQUESTINTROMSGDEF", "Vous n'avez pas trouv&eacute; la r&eacute;ponse &agrave; votre question? Pas de probl&egrave;me! Remplissez simplement le formulaire suivant afin de nous faire parvenir votre question. Un administrateur du site verra et publiera cette nouvelle question dans la section des Questions Ouvertes afin que quelqu'un puisse y r&eacute;pondre!");

define('_MI_SF_OPENINTROMSG', 'Message d\'introduction des Questions Ouvertes:');
define('_MI_SF_OPENINTROMSGDSC', 'Message d\'introduction &agrave; montrer dans la page des Questions Ouvertes.');
define('_MI_SF_OPENINTROMSGDEF', 'Voici la liste des Questions Ouvertes. Ces derni&egrave;res sont des Questions pos&eacute;es par les utilisateurs du site ne disposant pas de r&eacute;ponse. Vous pouvez cliquer sur une Question Ouverte pour y r&eacute;pondre et les aider.');

define("_MI_SF_USEREALNAME", "Utiliser le nom r&eacute;el de l'utilisateur");
define("_MI_SF_USEREALNAMEDSC", "Quand le nom de l'utilisateur est montr&eacute;, utilise le nom r&eacute;el de cet utilisateur s'il a &eacute;t&eacute; param&eacute;tr&eacute;.");

define('_MI_SF_HELP_PATH_SELECT', "M&eacute;thode d'acc&egrave;s &agrave; la doc SmartFaq");
define('_MI_SF_HELP_PATH_SELECT_DSC', "S&eacute;lectionnez la m&eacute;thode que vous pr&eacute;ferez concernant l'acc&egrave;s &agrave; la documentation SmartFaqFAQ. Si vous d&eacute;cidez de t&eacute;l&eacute;charger le package comprennant les fichiers d'aide pour les d&eacute;poser dans 'modules/smartfaq/doc/', vous pouvez s&eacute;lectionnez \"A l'int&eacute;rieur du module\". Sinon, vous pouvez acc&eacute;der directement &agrave; la documentation depuis l'url \"docs.xoops.org\" en choisissant cette option dans le menu. Il est aussi possible de selectionner \"R&eacute;pertoire personnel\" et sp&eacute;cifier par vous m&ecirc;me l'url dans le champ ci-dessous.");

define('_MI_SF_HELP_PATH_CUSTOM', "Url de la doc 'SmartFAQ'");
define('_MI_SF_HELP_PATH_CUSTOM_DSC', "Si vous s&eacute;lectionnez \"R&eacute;pertoire personnel\" dans l'option ci-dessus, merci de pr&eacute;ciser l'url ou se trouve les fichiers d'aide en respectant le format suivant : <b>http://www.yoursite.com/doc</b>");

define('_MI_SF_HELP_INSIDE', "A l'int&eacute;rieur du module");
define('_MI_SF_HELP_CUSTOM', "R&eacute;pertoire personnel");

//define("_MI_SF_MODERATORSEDIT", "Permettre aux mod&eacute;rateurs d'&eacute;diter (mod&eacute;rateurs avanc&eacute;s)");
//define("_MI_SF_MODERATORSEDITDSC", "Cette option autorisera les mod&eacute;rateurs &agrave; &eacute;diter des questions et des Q&amp;R dans les cat&eacute;gories pour lesquelles ils sont mod&eacute;rateurs. Autrement, les mod&eacute;rateurs ne peuvent qu'approuver ou refuser les questions et les Q&amp;R.");

// Names of admin menu items
define('_MI_SF_ADMENU1', 'En attente');
define('_MI_SF_ADMENU2', 'Cat&eacute;gories');
define('_MI_SF_ADMENU3', 'Q&amp;R');
define('_MI_SF_ADMENU4', 'Questions ouvertes');
define('_MI_SF_ADMENU5', 'Permissions');
define('_MI_SF_ADMENU6', 'Blocs et Groupes');
define('_MI_SF_ADMENU7', 'Acc&eacute;der au Module');

//Names of Blocks and Block information
define('_MI_SF_ARTSNEW', 'Liste des Q&amp;R r&eacute;centes');
define('_MI_SF_ARTSRANDOM_DIDUNO', 'Le saviez-vous?');
define('_MI_SF_ARTSRANDOM_FAQ', 'Question al&eacute;atoire!');
define('_MI_SF_ARTSRANDOM_HOW', 'Comment fais-je!');
define('_MI_SF_ARTSCONTEXT', 'Q&amp;R Contextuel');
define('_MI_SF_RECENTFAQS', 'Q&amp;R R&eacute;cente (D&eacute;taill&eacute;e)');
define('_MI_SF_RECENT_QUESTIONS', 'Questions ouvertes r&eacute;centes');
define("_MI_SF_MOST_VIEWED", "Questions populaires");

// Text for notifications

define('_MI_SF_GLOBAL_FAQ_NOTIFY', 'Q&amp;R Globale');
define('_MI_SF_GLOBAL_FAQ_NOTIFY_DSC', 'Options de notification appliqu&eacute;es &agrave; toutes les Q&amp;R.');

define('_MI_SF_CATEGORY_FAQ_NOTIFY', 'Cat&eacute;gorie de Q&amp;R');
define('_MI_SF_CATEGORY_FAQ_NOTIFY_DSC', 'Options de notification appliqu&eacute;es &agrave; cette cat&eacute;gorie courante.');

define('_MI_SF_FAQ_NOTIFY', 'FAQs');
define('_MI_SF_FAQ_NOTIFY_DSC', 'Options de notification appliqu&eacute;es &agrave; la Q&amp;R en cours.');

define('_MI_SF_GLOBAL_QUESTION_NOTIFY', 'Globale : Questions ouvertes');
define('_MI_SF_GLOBAL_QUESTION_NOTIFY_DSC', 'Options de notification appliqu&eacute;es &agrave; toutes les questions ouvertes');

define('_MI_SF_CATEGORY_QUESTION_NOTIFY', 'Cat&eacute;gorie de la Q&amp;R');
define('_MI_SF_CATEGORY_QUESTION_NOTIFY_DSC', 'Options de notification appliqu&eacute;es &agrave; cette cat&eacute;gorie.');

define('_MI_SF_QUESTION_NOTIFY', 'Question ouverte');
define('_MI_SF_QUESTION_NOTIFY_DSC', 'Options de notification appliqu&eacute;es &agrave; la Question Ouverte courante.');

define('_MI_SF_GLOBAL_FAQ_CATEGORY_CREATED_NOTIFY', 'Nouvelle cat&eacute;gorie');
define("_MI_SF_GLOBAL_FAQ_CATEGORY_CREATED_NOTIFY_CAP", "M'avertir quand une nouvelle cat&eacute;gorie est cr&eacute;&eacute;e.");
define('_MI_SF_GLOBAL_FAQ_CATEGORY_CREATED_NOTIFY_DSC', 'Recevez une notification quand une nouvelle cat&eacute;gorie est cr&eacute;&eacute;e.');
define('_MI_SF_GLOBAL_FAQ_CATEGORY_CREATED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} Notification automatique : Nouvelle Cat&eacute;gorie');

define('_MI_SF_GLOBAL_FAQ_SUBMITTED_NOTIFY', 'Q&amp;R propos&eacute;es');
define("_MI_SF_GLOBAL_FAQ_SUBMITTED_NOTIFY_CAP", "M'avertir quand une nouvelle Q&amp;R est propos&eacute;e et en attente d'approbation.");
define("_MI_SF_GLOBAL_FAQ_SUBMITTED_NOTIFY_DSC", "Recevez une notification quand une Q&amp;R est propos&eacute;e et en attente d'approbation.");
define('_MI_SF_GLOBAL_FAQ_SUBMITTED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} Notification automatique : Nouvelle Q&amp;R propos&eacute;e');

define('_MI_SF_GLOBAL_FAQ_PUBLISHED_NOTIFY', 'Nouvelle Q&amp;R publi&eacute;e');
define("_MI_SF_GLOBAL_FAQ_PUBLISHED_NOTIFY_CAP", "M'avertir quand une nouvelle Q&amp;R est publi&eacute;e.");
define('_MI_SF_GLOBAL_FAQ_PUBLISHED_NOTIFY_DSC', 'Recevez une notification quand une Q&amp;R est publi&eacute;e.');
define('_MI_SF_GLOBAL_FAQ_PUBLISHED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} Notification automatique : Nouvealle Q&amp;R publi&eacute;e');

define('_MI_SF_GLOBAL_FAQ_ANSWER_PROPOSED_NOTIFY', 'Nouvelle r&eacute;ponse propos&eacute;e');
define("_MI_SF_GLOBAL_FAQ_ANSWER_PROPOSED_NOTIFY_CAP", "M'avertir quand une nouvelle r&eacute;ponse est propos&eacute;e pour n'importe quelle Q&amp;R.");
define("_MI_SF_GLOBAL_FAQ_ANSWER_PROPOSED_NOTIFY_DSC", "Recevez une notification quand une nouvelle r&eacute;ponse est propos&eacute;e pour n'importe quelle Q&amp;R.");
define('_MI_SF_GLOBAL_FAQ_ANSWER_PROPOSED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} Notification automatique : Nouvelle r&eacute;ponse propos&eacute;e');

define('_MI_SF_GLOBAL_FAQ_ANSWER_PUBLISHED_NOTIFY', 'Nouvelle r&eacute;ponse publi&eacute;e');
define("_MI_SF_GLOBAL_FAQ_ANSWER_PUBLISHED_NOTIFY_CAP", "M'avertir quand une nouvelle r&eacute;ponse est publi&eacute;e pour n'importe quelle Q&amp;R.");
define("_MI_SF_GLOBAL_FAQ_ANSWER_PUBLISHED_NOTIFY_DSC", "Recevez une notification quand une nouvelle r&eacute;ponse est publi&eacute;e pour n'importe quelle Q&amp;R.");
define('_MI_SF_GLOBAL_FAQ_ANSWER_PUBLISHED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} Notification automatique : Nouvelle r&eacute;ponse publi&eacute;e');

define('_MI_SF_CATEGORY_FAQ_SUBMITTED_NOTIFY', 'Q&amp;R propos&eacute;');
define("_MI_SF_CATEGORY_FAQ_SUBMITTED_NOTIFY_CAP", "M'avertir quand une nouvelle Q&amp;R est propos&eacute;e dans cette cat&eacute;gorie.");   
define('_MI_SF_CATEGORY_FAQ_SUBMITTED_NOTIFY_DSC', 'Recevez une notification quand une nouvelle Q&amp;R est propos&eacute;e dans cette cat&eacute;gorie.');
define('_MI_SF_CATEGORY_FAQ_SUBMITTED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} Notification automatique : Nouvelle Q&amp;R propos&eacute;e dans cette cat&eacute;gorie');

define('_MI_SF_CATEGORY_FAQ_PUBLISHED_NOTIFY', 'Nouvelle Q&amp;R publi&eacute;e');
define("_MI_SF_CATEGORY_FAQ_PUBLISHED_NOTIFY_CAP", "M'avertir quand une nouvelle Q&amp;R est publi&eacute;e dans cette cat&eacute;gorie.");   
define('_MI_SF_CATEGORY_FAQ_PUBLISHED_NOTIFY_DSC', 'Recevez une notification quand une nouvelle Q&amp;R est publi&eacute;e dans cette cat&eacute;gorie.');
define('_MI_SF_CATEGORY_FAQ_PUBLISHED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} Notification automatique: nouvelle Q&amp;R publi&eacute;e dans cette cat&eacute;gorie');

define('_MI_SF_CATEGORY_FAQ_ANSWER_PROPOSED_NOTIFY', 'Nouvelle r&eacute;ponse propos&eacute;e');
define("_MI_SF_CATEGORY_FAQ_ANSWER_PROPOSED_NOTIFY_CAP", "M'avertir quand une nouvelle r&eacute;ponse est propos&eacute;e pour une Q&amp;R dans cette cat&eacute;gorie.");   
define('_MI_SF_CATEGORY_FAQ_ANSWER_PROPOSED_NOTIFY_DSC', 'Recevez une notification quand une nouvelle r&eacute;ponse est propos&eacute;e pour une Q&amp;R dans cette cat&eacute;gorie.');
define('_MI_SF_CATEGORY_FAQ_ANSWER_PROPOSED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} Notification automatique: Nouvelle r&eacute;ponse propos&eacute;e');

define('_MI_SF_CATEGORY_FAQ_ANSWER_PUBLISHED_NOTIFY', 'Nouvelle r&eacute;ponse publi&eacute;e');
define("_MI_SF_CATEGORY_FAQ_ANSWER_PUBLISHED_NOTIFY_CAP", "M'avertir quand une nouvelle r&eacute;ponse est publi&eacute;e pour une Q&amp;R dans cette cat&eacute;gorie.");   
define('_MI_SF_CATEGORY_FAQ_ANSWER_PUBLISHED_NOTIFY_DSC', 'Recevez une notification quand une nouvelle r&eacute;ponse est publi&eacute;e pour une Q&amp;R dans cette cat&eacute;gorie.');
define('_MI_SF_CATEGORY_FAQ_ANSWER_PUBLISHED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} Notification automatique: Nouvelle r&eacute;ponse publi&eacute;e');

define('_MI_SF_FAQ_REJECTED_NOTIFY', 'Q&amp;R rejet&eacute;e');
define("_MI_SF_FAQ_REJECTED_NOTIFY_CAP", "M'avertir si cette Q&amp;R est rejet&eacute;e.");   
define('_MI_SF_FAQ_REJECTED_NOTIFY_DSC', 'Recevez une notification si cette Q&amp;R est rejet&eacute;e.');
define('_MI_SF_FAQ_REJECTED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} Notification automatique: Q&amp;R rejet&eacute;e');

define('_MI_SF_FAQ_APPROVED_NOTIFY', 'Q&amp;R approuv&eacute;e');
define("_MI_SF_FAQ_APPROVED_NOTIFY_CAP", "M'avertir quand un nouveau est approuv&eacute;e.");
define('_MI_SF_FAQ_APPROVED_NOTIFY_DSC', 'Recevez une notification quand une nouvelle Q&amp;R est approuv&eacute;e.');
define('_MI_SF_FAQ_APPROVED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} Notification automatique: Q&amp;R approuv&eacute;e');

define('_MI_SF_FAQ_ANSWER_APPROVED_NOTIFY', 'R&eacute;ponse approuv&eacute;e');
define('_MI_SF_FAQ_ANSWER_APPROVED_NOTIFY_CAP', "M'avertir quand cette r&eacute;ponse est approuv&eacute;e.");
define('_MI_SF_FAQ_ANSWER_APPROVED_NOTIFY_DSC', 'Recevez une notification quand cette r&eacute;ponse est approuv&eacute;e.');
define('_MI_SF_FAQ_ANSWER_APPROVED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} Notification automatique : R&eacute;ponse approuv&eacute;e');

define('_MI_SF_FAQ_ANSWER_REJECTED_NOTIFY', 'R&eacute;ponse rejet&eacute;e');
define('_MI_SF_FAQ_ANSWER_REJECTED_NOTIFY_CAP', "M'avertir quand cette r&eacute;ponse est rejet&eacute;e.");
define('_MI_SF_FAQ_ANSWER_REJECTED_NOTIFY_DSC', 'Recevez une notification si cette r&eacute;ponse est rejet&eacute;e.');
define('_MI_SF_FAQ_ANSWER_REJECTED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} Notification automatique : R&eacute;ponse Rejet&eacute;e');

define('_MI_SF_GLOBAL_QUESTION_SUBMITTED_NOTIFY', 'Question propos&eacute;e');
define("_MI_SF_GLOBAL_QUESTION_SUBMITTED_NOTIFY_CAP", "M'avertir lorsqu'une n'importe quelle question a &eacute;t&eacute; propos&eacute;e et est en attente d'approbation.");   
define("_MI_SF_GLOBAL_QUESTION_SUBMITTED_NOTIFY_DSC", "Recevez une notification lorsqu'une question a &eacute;t&eacute; propos&eacute;e et est en attente d'approbation.");      
define('_MI_SF_GLOBAL_QUESTION_SUBMITTED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} Notification automatique : Nouvelle proposition de question');

define('_MI_SF_GLOBAL_QUESTION_PUBLISHED_NOTIFY', 'Question publi&eacute;e');
define("_MI_SF_GLOBAL_QUESTION_PUBLISHED_NOTIFY_CAP","M'avertir quand une nouvelle question est publi&eacute;e dans la section des Questions ouvertes.");   
define('_MI_SF_GLOBAL_QUESTION_PUBLISHED_NOTIFY_DSC','Recevez une notification quand une nouvelle question est publi&eacute;e dans la section des Questions ouvertes.');
define('_MI_SF_GLOBAL_QUESTION_PUBLISHED_NOTIFY_SBJ','[{X_SITENAME}] {X_MODULE} Notification automatique: Nouvelle question publi&eacute;e');

define('_MI_SF_GLOBAL_QUESTION_ANSWER_PROPOSED_NOTIFY', 'R&eacute;ponse propos&eacute;e');
define("_MI_SF_GLOBAL_QUESTION_ANSWER_PROPOSED_NOTIFY_CAP", "M'avertir quand une nouvelle r&eacute;ponse est pos&eacute;e &agrave; n'importe quelle Question ouverte.");   
define("_MI_SF_GLOBAL_QUESTION_ANSWER_PROPOSED_NOTIFY_DSC", "Recevez une notification quand une nouvelle r&eacute;ponse est pos&eacute;e &agrave; n'importe quelle Question ouverte.");      
define('_MI_SF_GLOBAL_QUESTION_ANSWER_PROPOSED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} Notification automatique: Nouvelle r&eacute;ponse pos&eacute;e');

define('_MI_SF_CATEGORY_QUESTION_SUBMITTED_NOTIFY', 'Question propos&eacute;e');
define("_MI_SF_CATEGORY_QUESTION_SUBMITTED_NOTIFY_CAP", "M'avertir quand une nouvelle question est pos&eacute;e dans cette cat&eacute;gorie.");   
define('_MI_SF_CATEGORY_QUESTION_SUBMITTED_NOTIFY_DSC', 'Recevez une notification quand une question est propos&eacute;e dans cette cat&eacute;gorie.');
define('_MI_SF_CATEGORY_QUESTION_SUBMITTED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} Notification automatique: Nouvelle question propos&eacute;e');

define('_MI_SF_CATEGORY_QUESTION_PUBLISHED_NOTIFY', 'Question publi&eacute;e');
define("_MI_SF_CATEGORY_QUESTION_PUBLISHED_NOTIFY_CAP", "M'avertir quand une nouvelle question est publi&eacute;e dans la cat&eacute;gorie en cours.");   
define('_MI_SF_CATEGORY_QUESTION_PUBLISHED_NOTIFY_DSC', 'Recevez une notification quand une question est publi&eacute;e dans cette cat&eacute;gorie.');
define('_MI_SF_CATEGORY_QUESTION_PUBLISHED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} Notification automatique: Nouvelle question publi&eacute;e');

define('_MI_SF_CATEGORY_QUESTION_ANSWER_PROPOSED_NOTIFY', 'R&eacute;ponse propos&eacute;e');
define("_MI_SF_CATEGORY_QUESTION_ANSWER_PROPOSED_NOTIFY_CAP", "M'avertir quand une r&eacute;ponse est propos&eacute;e &agrave; une question ouverte de cette cat&eacute;gorie.");   
define('_MI_SF_CATEGORY_QUESTION_ANSWER_PROPOSED_NOTIFY_DSC', 'Recevez une notification quand une r&eacute;ponse est propos&eacute;e pour une question ouverte dans cette cat&eacute;gorie.');
define('_MI_SF_CATEGORY_QUESTION_ANSWER_PROPOSED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} Notification automatique: Nouvelle r&eacute;ponse propos&eacute;e');

define('_MI_SF_QUESTION_REJECTED_NOTIFY', 'Question rejet&eacute;e');
define("_MI_SF_QUESTION_REJECTED_NOTIFY_CAP", "M'avertir si ma question est rejet&eacute;e.");   
define('_MI_SF_QUESTION_REJECTED_NOTIFY_DSC', 'Recevez une notification si la question est rejet&eacute;e.');
define('_MI_SF_QUESTION_REJECTED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} Notification automatique: Question rejet&eacute;e');

define('_MI_SF_QUESTION_APPROVED_NOTIFY', 'Question approuv&eacute;e');
define("_MI_SF_QUESTION_APPROVED_NOTIFY_CAP", "M'avertir si ma question est approuv&eacute;e.");   
define("_MI_SF_QUESTION_APPROVED_NOTIFY_DSC", "Recevez une notification si la question est approuv&eacute;e.");      
define("_MI_SF_QUESTION_APPROVED_NOTIFY_SBJ", "[{X_SITENAME}] {X_MODULE} Notification automatique: Question approuv&eacute;e");

define('_MI_SF_QUESTION_ANSWER_APPROVED_NOTIFY', 'R&eacute;ponse approuv&eacute;e');
define("_MI_SF_QUESTION_ANSWER_APPROVED_NOTIFY_CAP", "M'avertir si ma r&eacute;ponse est approuv&eacute;e.");   
define('_MI_SF_QUESTION_ANSWER_APPROVED_NOTIFY_DSC', 'Recevez une notification si la r&eacute;ponse est approuv&eacute;e.');
define('_MI_SF_QUESTION_ANSWER_APPROVED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} Notification automatique : R&eacute;ponse approuv&eacute;e');

define('_MI_SF_QUESTION_ANSWER_REJECTED_NOTIFY', 'R&eacute;ponse rejet&eacute;e');
define("_MI_SF_QUESTION_ANSWER_REJECTED_NOTIFY_CAP", "M'avertir si ma r&eacute;ponse est rejet&eacute;e.");   
define('_MI_SF_QUESTION_ANSWER_REJECTED_NOTIFY_DSC', 'Recevez une notification si la r&eacute;ponse est rejet&eacute;e.');
define('_MI_SF_QUESTION_ANSWER_REJECTED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} Notification automatique : R&eacute;ponse rejet&eacute;e');

// About.php constants
define('_MI_SF_AUTHOR_INFO', "D&eacute;velopeurs");
define('_MI_SF_DEVELOPER_LEAD', "D&eacute;veloppeur principal");
define('_MI_SF_DEVELOPER_CONTRIBUTOR', "Contributeur(s)");
define('_MI_SF_DEVELOPER_WEBSITE', "Site web");
define('_MI_SF_DEVELOPER_EMAIL', "Email");
define('_MI_SF_DEVELOPER_CREDITS', "Cr&eacute;dits");
define('_MI_SF_DEMO_SITE', "Site Demo SmartFactory");
define('_MI_SF_MODULE_INFO', 'Informations sur le D&eacute;veloppement du Module');
define('_MI_SF_MODULE_STATUS', 'Statut');
define('_MI_SF_MODULE_RELEASE_DATE', "Date de sortie");
define('_MI_SF_MODULE_DEMO', 'Site de d&eacute;monstration');
define('_MI_SF_MODULE_SUPPORT', 'Site officiel de support');
define('_MI_SF_MODULE_BUG', 'Rapportez une erreur pour ce module');
define('_MI_SF_MODULE_FEATURE', 'Proposez de nouvelles options pour ce module');
define('_MI_SF_MODULE_DISCLAIMER', 'Avertissement');
define("_MI_SF_AUTHOR_WORD", "Le mot de l'auteur");
define('_MI_SF_VERSION_HISTORY', "Historique des versions");

// Beta
define('_MI_SF_WARNING_BETA', "This module comes as is, without any guarantees what so ever. 
This module is BETA, meaning it is still under active development. This release is meant for
<b>testing purposes only</b> and we <b>strongly</b> recommend that you do not use it on a live 
website or in a production environment.");

// RC
define('_MI_SF_WARNING_RC', "This module comes as is, without any guarantees whatsoever. This module 
is a Release Candidate and should not be used on a production web site. The module is still under 
active development and its use is under your own responsibility, which means the author is not responsible.");


// Final
define('_MI_SF_WARNING_FINAL', "This module comes as is, without any guarantees whatsoever. Although this 
module is not beta, it is still under active development. This release can be used in a live website 
or a production environment, but its use is under your own responsibility, which means the author 
is not responsible.");

?>