<?php
// $Id$
// Module Info

// The name of this module
define("_MI_CONTACT_NAME","Contact");
define("_MI_CONTACT_TEMPLATES","Formulaire de contact");
// A brief description of this module
define("_MI_CONTACT_DESC","Page de contact par Email");

define('_MI_CONTACT_SETTINGS', 'Param&egrave;tres');
define('_MI_CONTACT_SETTINGS_DSC', 'Param&eacute;trage des options du module Contact');
define('_MI_CONTACT_GEN', 'Param&egrave;tres G&eacute;n&eacute;raux' );
define('_MI_CONTACT_GEN_DSC', "Configuration des param&egrave;tres g&eacute;n&eacute;raux pour l'ent&ecirc;te et les sujets/emails d'envoi" );

// Config stuff
define("_MI_CONTACT_GETICQ", "Demander l'adresse ICQ" );
define("_MI_CONTACT_GETICQDSC", "Oui - demande de l'adresse ICQ" );

define("_MI_CONTACT_ALLOWSENDCONFIRM", "Autoriser l'email de confirmation" );
define("_MI_CONTACT_ALLOWSENDCONFIRMDSC", "Oui - montrer une check box &agrave; l'exp&eacute;diteur"
."lui permetttant de recevoir un mail de confirmation." );

define("_MI_CONTACT_GETURL", "Demander l'adresse web du site de l'exp&eacute;diteur" );
define("_MI_CONTACT_GETURLDSC", "Oui - demander l'URL" );

define("_MI_CONTACT_GETCOMPANY", "Demander le nom de l'entreprise" );
define("_MI_CONTACT_GETCOMPANYDSC", "Oui - demande du nom de l'entreprise" );

define("_MI_CONTACT_GETLOC", "Demander le nom de la ville" );
define("_MI_CONTACT_GETLOCDSC", "Oui - Demande de la ville (pas l'adresse compl&egrave;te)!" );

define("_MI_CONTACT_ADDRESS", "Demander l'adresse de l'exp&eacute;diteur" );
define("_MI_CONTACT_ADDRESSDSC", "Oui - demander l'adresse" );

define("_MI_CONTACT_INTROHEAD", "Ent&ecirc;te d'introduction" );
define("_MI_CONTACT_INTROHEAD_DESC", "Ceci est l'ent&ecirc;te qui appara&icirc;tra comme  <b>Texte d'introduction</b>");
define("_MI_CONTACT_INTRO_DEFAULT","Merci de remplir le formulaire suivant, <br />Nous vous apporterons une r&eacute;ponse le plus vite possible!");

define("_MI_CONTACT_INTRO", "Texte d'introduction" );
define("_MI_CONTACT_INTRO_DESC", "Texte qui appara&icirc;tra au d&eacute;but du bloc  <b>Nous contacter</b><br />"
."Par exemple - Texte de bienvenue, num&eacute;ros de t&eacute;l&eacute;phone, etc." );

define("_MI_CONTACT_SECURITY", "Contr&ocirc;le de S&eacute;curit&eacute;" );
define("_MI_CONTACT_SECURITYDSC", "Oui - Activer le <b>Contr&ocirc;le de S&eacute;curit&eacute;</b> pour valider l'envoi du formulaire.<br />"
."Ceci pour aider &agrave; l'h&eacute;radication de SPAM via le module <b>\"Contact\"</b>!" );
	
define("_MI_CONTACT_SITEKEY", "Cl&eacute; al&eacute;atoire" );
define("_MI_CONTACT_SITEKEYDSC", "Cr&eacute;ation d'une cl&eacute; al&eacute;atoire m&eacute;langeant chiffres et lettres pour cr&eacute;er le <b>Code de s&eacute;curit&eacute;</b><br />"
."afin qu'il soit plus al&eacute;atoire!" );

define("_MI_CONTACT_HEAD", "Ent&ecirc;te du module Contact" );
define("_MI_CONTACT_HEADDSC", "Ent&ecirc;te du formulaire Contact");
define("_MI_CONTACT_HEADDEFAULT","Formulaire Contact");

define("_MI_CONTACT_THANKYOU", "Merci pour votre message");
define("_MI_CONTACT_THANKYOUDSC", "Message &agrave; l'exp&eacute;diteur pour le remercier de son envoi");
define("_MI_CONTACT_THANKYOUDEFAULT", "Merci de nous avoir contact&eacute;.  Nous prendrons contact avec nous le plus rapidement possible!");

define("_MI_CONTACT_TIMEOUT", "Timeout de redirection de page");
define("_MI_CONTACT_TIMEOUTDSC", "Nombre de seconde d'affichage de la page de redirection apr&egrave;s l'envoi du message");

define("_MI_CONTACT_SHOWDEPT", "Afficher l'option \"D&eacute;partements/Sujets\"");
define("_MI_CONTACT_SHOWDEPTDSC", "Oui - Affiche une liste d&eacute;roulante  contenant les D&eacute;partements/Sujets"
."Si aucun D&eacute;partement/Sujet n'est cr&eacute;&eacute;, l'Email sera envoy&eacute; par d&eacute;faut &agrave; l'Email du site" );

define("_MI_CONTACT_DEPTTITLE", "Titre de la section \"D&eacute;partements/Sujets\"");
define("_MI_CONTACT_DEPTTITLEDSC", "Titre affich&eacute; dans la section \"D&eacute;partements/Sujets\" du formulaire de Contact");
define("_MI_CONTACT_DEPTTITLEDEFAULT", "D&eacute;partement");

define("_MI_CONTACT_DEPT", "D&eacute;partements/Sujets" );
define("_MI_CONTACT_DEPTDSC", "D&eacute;partements/Sujets permet de d&eacute;finir une association D&eacute;partements / Email<br />"
."L'utilisateur en s&eacute;lectionnant un d&eacute;partement ou un sujet s&eacute;lectionne aussi l'Email du destinataire<br />"
."que vous d&eacute;finissez ici.<br /><br />"
."D&eacute;finissez la paire D&eacute;partement/Email ici:<br /><br />"
."dept1,email1|dept2,email2|dept3,email3 etc. - chaque paire D&eacute;partement/Email est s&eacute;par&eacute;e par le signe pipe '|'<br />"
."et par une virgule ',' entre les champs D&eacute;partement et Email" );

define("_MI_CONTACT_VALIDATEDOMAIN", "Validation du domaine de l'Email");
define("_MI_CONTACT_VALIDATEDOMAINDSC", "Oui - Activation \"de la v&eacute;rification en profondeur\" du nom de domaine figurant dans l'adresse Email.<br />"
."Non - V&eacute;rification simplifi&eacute;e de l'adresse Email.");

define("_MI_CONTACT_SHOWMOREINFO", "Afficher la section \"Informations compl&eacute;mentaires\"" );
define("_MI_CONTACT_SHOWMOREINFODSC", "Oui - Affichage de la section avec les choix possibles d&eacute;finis dans la liste des \"informations compl&eacute;mentaires\"");

define("_MI_CONTACT_MOREINFOTITLE", "\"Informations compl&eacute;mentaires\"" );
define("_MI_CONTACT_MOREINFOTITLEDSC", "Titre de la section \"Informations compl&eacute;mentaires\" du module Contact" );
define("_MI_CONTACT_MOREINFOTITLEDEFAULT","Demande d'informations compl&eacute;mentaires");

define("_MI_CONTACT_MOREINFO", "Liste des\"Informations compl&eacute;mentaires\"");
define("_MI_CONTACT_MOREINFODSC", "Les &eacute;l&eacute;ments \"Informations compl&eacute;mentaires\" permettrent d'afficher des &eacute;l&eacute;ments que l'utilisateur peut s&eacute;lectionner<br />"
."Comme par exemple ses centres d'int&eacute;r&ecirc;ts, ou une demande d'information.C'est un moyen pour mieux orienter vos clients<br />"
."Par exemple pour une application commerciale,un vendeur voudra proposer une demande de brochures, l'envoi d'un CD de d&eacute;monstration, ou proposer au client d'&ecirc;tre rappel&eacute; par un commercial<br />C'est un moyen de r&eacute;cup&eacute;rer des clients<br />"
."D&eacute;finissez la liste comme suit:<br /><br />"
."option1|option2|option3 etc. - Chacun d'eux s&eacute;par&eacute; par le symbole pipe '|'");

?>