<?php

/**
* $Id: modinfo.php 3443 2008-07-05 12:03:31Z gibaphp $
* Module: Publisher
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

// Module Info
// The name of this module

global $xoopsModule;

define("_MI_PUB_ADMENU1", "Accueil");
define("_MI_PUB_ADMENU2", "Cat&eacute;gories");
define("_MI_PUB_ADMENU3", "Articles");
define("_MI_PUB_ADMENU4", "Permissions");
define("_MI_PUB_ADMENU5", "Blocs et groupes");
define("_MI_PUB_ADMENU6", "Mimetypes");
define("_MI_PUB_ADMENU7", "Aller au module");

define("_MI_PUB_ADMINHITS", "[OPTIONS DE CONTENU] Compter les lectures de l'administrateur:");
define("_MI_PUB_ADMINHITSDSC", "Compiler le nombre de lectures de l'administrateur dans les statistiques?");
define("_MI_PUB_ALLOWSUBMIT", "[PERMISSIONS] Propositions des utilisateurs:");
define("_MI_PUB_ALLOWSUBMITDSC", "Permettre aux utilisateurs de proposer des articles?");
define("_MI_PUB_ANONPOST", "[PERMISSIONS] Permettre aux utilisateurs anonymes de proposer des articles");
define("_MI_PUB_ANONPOSTDSC", "Permission aux utilisateurs non inscrits au site de proposer des articles.");
define("_MI_PUB_AUTHOR_INFO", "D&eacute;veloppeurs");
define("_MI_PUB_AUTHOR_WORD", "Le mot de l'auteur");
define("_MI_PUB_AUTOAPP", "[PERMISSIONS] Approuver automatiquement les articles proposés:");
define("_MI_PUB_AUTOAPPDSC", "Approuver automatiquement les articles proposés sans que l'administrateur n'intervienne.");
define("_MI_PUB_BCRUMB", "[OPTIONS DE FORMAT] Inclure le nom du module dans l'affichage de la branche courante");
define("_MI_PUB_BCRUMBDSC", "Si vous choisissez oui, la branche sera affich&eacute;e 'Publisher > nom de cat&eacute;gorie > nom de l article '. <br>Sinon, seulement 'nom de cat&eacute;gorie > nom de l article' seront affich&eacute;s");
define("_MI_PUB_BOTH_FOOTERS", "Les deux");
define("_MI_PUB_BY", "Par");
define("_MI_PUB_CATEGORY_ITEM_NOTIFY", "Notifications de cat&eacute;gorie");
define("_MI_PUB_CATEGORY_ITEM_NOTIFY_DSC", "Notification s'appliquant &agrave; la cat&eacute;gorie courante.");
define("_MI_PUB_CATEGORY_ITEM_PUBLISHED_NOTIFY", "Nouveaux articles publi&eacute;s");
define("_MI_PUB_CATEGORY_ITEM_PUBLISHED_NOTIFY_CAP", "Notifiez moi quand un nouvel article est publi&eacute; dans cette cat&eacute;gorie.");
define("_MI_PUB_CATEGORY_ITEM_PUBLISHED_NOTIFY_DSC", "Recevoir une notification quand un nouvel article est publi&eacute; dans cette cat&eacute;gorie.");
define("_MI_PUB_CATEGORY_ITEM_PUBLISHED_NOTIFY_SBJ", "[{X_SITENAME}] {X_MODULE} auto-notification: Nouvel article dans cette cat&eacute;gorie");
define("_MI_PUB_CATEGORY_ITEM_SUBMITTED_NOTIFY", "Article soumis");
define("_MI_PUB_CATEGORY_ITEM_SUBMITTED_NOTIFY_CAP", "Notifiez moi quand un nouvel article est soumis dans cette cat&eacute;gorie.");
define("_MI_PUB_CATEGORY_ITEM_SUBMITTED_NOTIFY_DSC", "Recevoir une notification quand un nouvel article est soumis dans cette cat&eacute;gorie.");
define("_MI_PUB_CATEGORY_ITEM_SUBMITTED_NOTIFY_SBJ", "[{X_SITENAME}] {X_MODULE} auto-notification: Nouvel article soumis dans cette cat&eacute;gorie");
define("_MI_PUB_CATLIST_IMG_W", "[OPTIONS DE FORMAT] Largeur de l'image dans la liste des cat&eacute;gories");
define("_MI_PUB_CATLIST_IMG_WDSC", "Sp&eacute;cifiez la largeur des images à afficher au listage des cat&eacute;gories.");
define("_MI_PUB_CATMAINIMG_W", "[OPTIONS DE FORMAT] Largeur de l'image principale");
define("_MI_PUB_CATMAINIMG_WDSC", "Sp&eacute;cifiez la largeur de l'images à afficher à la page de la cat&eacute;gories.");
define("_MI_PUB_CATPERPAGE", "[OPTIONS DE FORMAT] Maximum de cat&eacute;gories par page (cot&eacute; utilisateur):");
define("_MI_PUB_CATPERPAGEDSC", "Maximum de cat&eacute;gories par page &agrave; afficher &agrave; la fois du cot&eacute; utilisateur.");
define("_MI_PUB_CLONE", "[PERMISSIONS] Permettre la duplication d'article ?");
define("_MI_PUB_CLONEDSC", "S&eacute;lectionner 'Oui' pour permettre aux utilisateurs poss&eacute;dant les droits appropri&eacute;s de dupliquer un article.");
define("_MI_PUB_COLLHEAD", "[OPTIONS DE FORMAT] Afficher la barre r&eacute;tractable:");
define("_MI_PUB_COLLHEADDSC", "Si vous choisissez 'Oui', le r&eacute;sum&eacute; des cat&eacute;gories sera affich&eacute; dans une barre r&eacute;tractable, tout comme les articles. Si vous choisissez 'Non', la barre r&eacute;tractable n'apparaîtra pas.");
define("_MI_PUB_COMMENTS", "[PERMISSIONS] Contr&ocirc;le des commentaires au niveau des cat&eacute;gories:");
define("_MI_PUB_COMMENTSDSC", "Si vous choisissez 'Oui', vous ne verrez les commentaires que sur les articles qui ont leur case d'option coch&eacute;e. <br /><br />Choisissez 'Non' pour administrer les commentaires &agrave; un niveau global(voir ci-dessous la balise 'R&egrave;gles des Commentaires').");
define("_MI_PUB_DATEFORMAT", "[OPTIONS DE FORMAT] Format de la date:");
define("_MI_PUB_DATEFORMATDSC", "Utilisez la fin de language/french/global.php pour choisir de montrer un style. Exemple: 'd-M-Y H:i' traduits en '30-Mar-2004 22:35'");
define("_MI_PUB_DEMO_SITE", "Site de d&eacute;monstration de SmartFactory");
define("_MI_PUB_DEVELOPER_CONTRIBUTOR", "Collaborateurs(s)");
define("_MI_PUB_DEVELOPER_CREDITS", "Cr&eacute;dits");
define("_MI_PUB_DEVELOPER_EMAIL", "Courriel");
define("_MI_PUB_DEVELOPER_LEAD", "D&eacute;veloppeur(s) en chef");
define("_MI_PUB_DEVELOPER_WEBSITE", "Site web");
define("_MI_PUB_DISCOM", "[OPTIONS DE CONTENU] Afficher le nombre de commentaires?");
define("_MI_PUB_DISCOM_DSC", "Choisissez 'Oui' pour afficher le nombre de commentaires pour chaque article");
define("_MI_PUB_DISDATECOL", "[OPTIONS DE CONTENU] Afficher la colonne 'Publi&eacute; le'?");
define("_MI_PUB_DISDATECOLDSC", "Lorsque 'Vue sommaire' est s&eacute;lectionn&eacute; comme type d'affichage, choisissez 'Oui' pour afficher la date de publication dans le tableau des articles sur les pages index et cat&eacute;gories.");
define("_MI_PUB_DCS", "[OPTIONS DE CONTENU] Afficher le Sommaire de catégorie?");
define("_MI_PUB_DCS_DSC", "Choisissez 'Non' pour ne pas afficher le Sommaire d'une catégorie lorsque sur une page de catégoie qui ne possède aucune sous-catégorie.");
define("_MI_PUB_DISPLAY_CATEGORY", "Afficher le nom des cat&eacute;gories?");
define("_MI_PUB_DISPLAY_CATEGORY_DSC", "Choisissez 'Oui' pour afficher le lien vers la cat&eacute;gorie dans chaque article");
define("_MI_PUB_DISPLAYTYPE_FULL", "Vue compl&egrave;te");
define("_MI_PUB_DISPLAYTYPE_LIST", "Liste &agrave; puce");
define("_MI_PUB_DISPLAYTYPE_WFSECTION", "Style WFSection");
define("_MI_PUB_DISPLAYTYPE_SUMMARY", "Vue sommaire");
define("_MI_PUB_DISSBCATDSC", "[OPTIONS DE CONTENU] Afficher les description des sous-cat&eacute;gories?");
define("_MI_PUB_DISSBCATDSCDSC", "Choisissez 'Oui' pour afficher la description des sous-cat&eacute;gories dans les pages index et cat&eacute;gories.");
define("_MI_PUB_DISTYPE", "[OPTIONS DE FORMAT] Type d'affichage des cat&eacute;gories:");
define("_MI_PUB_DISYPEDSC", "Si le type 'Vue sommaire' est choisi, seulement le titre, la date et le nombre de clics de chaque article seront affich&eacute;s pour la cat&eacute;gorie selectionn&eacute;e. Si le type 'Vue compl&egrave;te' est choisi, chaque article sera compl&egrave;tement affich&eacute; pour la cat&eacute;gorie s&eacute;lectionn&eacute;e.");
define("_MI_PUB_FILEUPLOADDIR", "R&eacute;pertoire des fichiers charg&eacute;s par l'utilisateur:");
define("_MI_PUB_FILEUPLOADDIRDSC", "R&eacute;pertoire dans lequel seront import&eacute;s les fichiers joints aux articles. Ne pas mettre '/' ni au d&eacute;but ni &agrave; la fin.");
define("_MI_PUB_FOOTERPRINT", "[OPTIONS D'IMPRESSION] Pied de page &agrave; imprimer");
define("_MI_PUB_FOOTERPRINTDSC", "Pied de page pour les pages d'impression");
define("_MI_PUB_GLOBAL_ITEM_CATEGORY_CREATED_NOTIFY", "Nouvelle cat&eacute;gorie");
define("_MI_PUB_GLOBAL_ITEM_CATEGORY_CREATED_NOTIFY_CAP", "Notifiez moi quand une cat&eacute;gorie est cr&eacute;&eacute;e.");
define("_MI_PUB_GLOBAL_ITEM_CATEGORY_CREATED_NOTIFY_DSC", "Recevoir une notification quand une cat&eacute;gorie est cr&eacute;&eacute;e.");
define("_MI_PUB_GLOBAL_ITEM_CATEGORY_CREATED_NOTIFY_SBJ", "[{X_SITENAME}] {X_MODULE} auto-notification: Nouvelle cat&eacute;gorie");
define("_MI_PUB_GLOBAL_ITEM_NOTIFY", "Notifications globales");
define("_MI_PUB_GLOBAL_ITEM_NOTIFY_DSC", "Options de notification s'appliquant &agrave; toutes les cat&eacute;gories.");
define("_MI_PUB_GLOBAL_ITEM_PUBLISHED_NOTIFY", "Nouveaux articles publi&eacute;s");
define("_MI_PUB_GLOBAL_ITEM_PUBLISHED_NOTIFY_CAP", "Notifiez moi quand un article est publi&eacute;e.");
define("_MI_PUB_GLOBAL_ITEM_PUBLISHED_NOTIFY_DSC", "Recevoir une notification quand un article est publi&eacute;.");
define("_MI_PUB_GLOBAL_ITEM_PUBLISHED_NOTIFY_SBJ", "[{X_SITENAME}] {X_MODULE} auto-notification: nouvel article publi&eacute;");
define("_MI_PUB_GLOBAL_ITEM_SUBMITTED_NOTIFY", "Article soumis");
define("_MI_PUB_GLOBAL_ITEM_SUBMITTED_NOTIFY_CAP", "Notifiez moi quand un article est soumis et en attente d'&ecirc;tre approuv&eacute;.");
define("_MI_PUB_GLOBAL_ITEM_SUBMITTED_NOTIFY_DSC", "Recevoir une notification quand un article est soumis et en attente d'&ecirc;tre approuv&eacute;.");
define("_MI_PUB_GLOBAL_ITEM_SUBMITTED_NOTIFY_SBJ", "[{X_SITENAME}] {X_MODULE} auto-notification: nouvel article soumis");
define("_MI_PUB_HEADERPRINT", "[OPTIONS D'IMPRESSION] Ent&ecirc;te &agrave; imprimer");
define("_MI_PUB_HEADERPRINTDSC", "Ent&ecirc;te pour les pages d'impression");
define("_MI_PUB_HELP_CUSTOM", "R&eacute;pertoire personnalis&eacute;");
define("_MI_PUB_HELP_INSIDE", "&Agrave; l'int&eacute;rieur du module");
define("_MI_PUB_HELP_PATH_CUSTOM", "R&eacute;pertoire personnalis&eacute; des fichiers d'aide de Publisher");
define("_MI_PUB_HELP_PATH_CUSTOM_DSC", "Si vous avez choisi 'R&eacute;pertoire personnalis&eacute;' dans l'option pr&eacute;c&eacute;dente 'R&eacute;pertoire des fichiers d'aide de Publisher', sp&eacute;cifiez leur url, dans ce format: http://www.votresite.com/doc");
define("_MI_PUB_HELP_PATH_SELECT", "R&eacute;pertoire des fichiers d'aide de Publisher");
define("_MI_PUB_HELP_PATH_SELECT_DSC", "Choisissez l'emplacement des fichiers d'aide de Publisher. Si vous avez t&eacute;l&eacute;charg&eacute; le 'Publisher's Help Package' et l'avez plac&eacute; dans 'modules/publisher/doc/', choisissez '&Agrave; l'int&eacute;rieur du module'. Autrement, vous pouvez acc&eacute;der aux fichiers d'aide du module module directement sur docs.xoops.org en le choisissant dans le selecteur. Vous pouvez aussi choisir 'R&eacute;pertoire personnalis&eacute;' et sp&eacute;cifier vous-m&ecirc;me le chemin d'acc&egrave;s aux fichiers d'aide dans le champ 'R&eacute;pertoire personalis&eacute; aux fichiers d'aide.'");
define("_MI_PUB_HITSCOL", "[OPTIONS DE CONTENU] Afficher la colonne 'Clics'?");
define("_MI_PUB_HITSCOLDSC", "Lorsque 'Vue sommaire' est s&eacute;lectionn&eacute; comme type d'affichage, choisissez 'Oui' pour afficher la colonne 'Clics' dans le tableau des articles sur les pages index et cat&eacute;gories.");
define("_MI_PUB_HLCOLOR", "[OPTIONS DE FORMAT] Couleur du surlignage des mots cl&eacute;s");
define("_MI_PUB_HLCOLORDSC", "Couleur avec laquelle les mots cl&eacute;s seront surlign&eacute;s lors de l'ex&eacute;cution de la fonction de recherche");
define("_MI_PUB_IMAGENAV", "[OPTIONS DE FORMAT] Utiliser la page  de navigation par images:");
define("_MI_PUB_IMAGENAVDSC", "Si vous choisissez 'Oui', la page de navigation sera affich&eacute;e avec des images, sinon, le mode original sera utilis&eacute;");
define("_MI_PUB_INDEXFOOTER", "[OPTIONS DE CONTENU] Pied de page de l'index");
define("_MI_PUB_INDEXFOOTER_SEL", "Pied de page de l'index");
define("_MI_PUB_INDEXFOOTERDSC", "Pied de page qui sera affich&eacute; &agrave; la page d'acceuil du module");
define("_MI_PUB_INDEXMSG", "[OPTIONS DE CONTENU] Message de bienvenue de la page d'accueil:");
define("_MI_PUB_INDEXMSGDEF", "");
define("_MI_PUB_INDEXMSGDSC", "Ce message sera affich&eacute; dans la page d'accueil de ce module.");
define("_MI_PUB_ITEM_APPROVED_NOTIFY", "article approuv&eacute;");
define("_MI_PUB_ITEM_APPROVED_NOTIFY_CAP", "Notifiez moi quand cet article sera approuv&eacute;.");
define("_MI_PUB_ITEM_APPROVED_NOTIFY_DSC", "Recevoir une notification quand cet article sera approuv&eacute;.");
define("_MI_PUB_ITEM_APPROVED_NOTIFY_SBJ", "[{X_SITENAME}] {X_MODULE} auto-notification: article approuv&eacute;.");
define("_MI_PUB_ITEM_NOTIFY", "Articles");
define("_MI_PUB_ITEM_NOTIFY_DSC", "Option de notification s'appliquant au pr&eacute;sent article.");
define("_MI_PUB_ITEM_REJECTED_NOTIFY", "article rejet&eacute;");
define("_MI_PUB_ITEM_REJECTED_NOTIFY_CAP", "Notifiez moi si cet article est rejet&eacute;.");
define("_MI_PUB_ITEM_REJECTED_NOTIFY_DSC", "Recevoir une notification si cet article est rejet&eacute;.");
define("_MI_PUB_ITEM_REJECTED_NOTIFY_SBJ", "[{X_SITENAME}] {X_MODULE} auto-notification: article rejet&eacute;");
define("_MI_PUB_ITEM_TYPE", "Type d'item:");
define("_MI_PUB_ITEM_TYPEDSC", "Choisissez le type des items qui seront g&eacute;r&eacute;s dans ce module.");
define("_MI_PUB_ITEMFOOTER", "[OPTIONS DE CONTENU] Pied de page des articles");
define("_MI_PUB_ITEMFOOTER_SEL", "Pied de page des articles");
define("_MI_PUB_ITEMFOOTERDSC", "Pied de page qui sera affich&eacute; pour chaque article");
define("_MI_PUB_ITEMSMENU", "Menu navigation des catégories");
//bd tree block hack
define("_MI_PUB_ITEMSTREE", "Guide arborescent du contenu du module");
//--/bd
define("_MI_PUB_ITEMSNEW", "Liste des articles r&eacute;cents");
define("_MI_PUB_ITEMSPOT", "En vedette!");
define("_MI_PUB_ITEMSRANDOM_ITEM", "Article au hasard!");
define("_MI_PUB_LASTITEM", "[OPTIONS DE CONTENU] Afficher la colonne 'dernier article'?");
define("_MI_PUB_LASTITEMDSC", "Choisissez 'Oui' pour afficher le dernier article de chaque cat&eacute;gorie dans les pages index et cat&eacute;gories.");
define("_MI_PUB_LASTITEMS", "[OPTIONS DE CONTENU] Afficher la liste des articles nouvellement publi&eacute;s:");
define("_MI_PUB_LASTITEMSDSC", "Choisissez 'Oui' pour avoir cette liste au bas de la premi&egrave;re page du module");
define("_MI_PUB_LASTITSIZE", "[OPTIONS DE FORMAT] Taille du titre du dernier article:");
define("_MI_PUB_LASTITSIZEDSC", "Choisissez la taille maximale du titre dans la colonne du dernier article.");
define("_MI_PUB_LINKPATH", "[OPTIONS DE FORMAT] Activer les liens de la branche courante:");
define("_MI_PUB_LINKPATHDSC", "Cette option permet &agrave; l'utilisateur de remonter de niveau en cliquant sur un &eacute;l&eacute;ment du chemin affich&eacute; dans le haut des page");
define("_MI_PUB_MAX_HEIGHT", "[PERMISSIONS] Hauteur maximale d'une image");
define("_MI_PUB_MAX_HEIGHTDSC", "Hauteur maximale d'une image upload&eacute;e.");
define("_MI_PUB_MAX_SIZE", "[PERMISSIONS] Taille maximale");
define("_MI_PUB_MAX_SIZEDSC", "Taille maximale (en octets) d'un fichier upload&eacute;.");
define("_MI_PUB_MAX_WIDTH", "[PERMISSIONS] Largeur maximale d'une image");
define("_MI_PUB_MAX_WIDTHDSC", "Largeur maximale d'une image upload&eacute;e.");
define("_MI_PUB_MD_DESC", "Syst&egrave;me de Management de Section pour votre site XOOPS.");
define("_MI_PUB_MD_NAME", "Publisher");
define("_MI_PUB_MODULE_BUG", "Rapporter un bug de ce module");
define("_MI_PUB_MODULE_DEMO", " Site de d&eacute;monstration");
define("_MI_PUB_MODULE_DISCLAIMER", "Avertissement");
define("_MI_PUB_MODULE_FEATURE", "Sugg&eacute;rer de nouvelles options pour ce module");
define("_MI_PUB_MODULE_INFO", "Informations sur le d&eacute;veloppement du module");
define("_MI_PUB_MODULE_RELEASE_DATE", "Date de diffusion");
define("_MI_PUB_MODULE_STATUS", "Statut");
define("_MI_PUB_MODULE_SUBMIT_BUG", "Soumettre un bug");
define("_MI_PUB_MODULE_SUBMIT_FEATURE", "Soumettre une suggestion");
define("_MI_PUB_MODULE_SUPPORT", "Site officiel d'aide");
define("_MI_PUB_NO_FOOTERS", "Aucun");
define("_MI_PUB_ORDERBY", "[OPTIONS DE FORMAT] Ordre de tri des articles");
define("_MI_PUB_ORDERBY_DATE", "Date DESC");
define("_MI_PUB_ORDERBY_TITLE", "Titre ASC");
define("_MI_PUB_ORDERBY_WEIGHT", "Poids ASC");
define("_MI_PUB_ORDERBYDSC", "S&eacute;lectionn&eacute; la façon dont les articles seront tri&eacute; &agrave; travers le module.");
define("_MI_PUB_OTHER_ITEMS_TYPE_ALL", "Tous les articles");
define("_MI_PUB_OTHER_ITEMS_TYPE_NONE", "Aucun");
define("_MI_PUB_OTHER_ITEMS_TYPE_PREVIOUS_NEXT", "Article suivant et pr&eacute;c&eacute;dent");
define("_MI_PUB_OTHERITEMS", "[OPTIONS DE FORMAT] Type d'affichage des autres articles");
define("_MI_PUB_OTHERITEMSDSC", "S&eacute;lectionnez comment vous aimeriez afficher les autres articles de la cat&eacute;gorie, dans la page d'article.");
define("_MI_PUB_PERPAGE", "[OPTIONS DE FORMAT] Maximum d'articles par page (cot&eacute; administration):");
define("_MI_PUB_PERPAGEDSC", "Maximum d'articles &agrave; afficher en m&ecirc;me temps du cot&eacute; administration.");
define("_MI_PUB_PERPAGEINDEX", "[OPTIONS DE FORMAT] Maximum d'articles par page (cot&eacute; utilisateur):");
define("_MI_PUB_PERPAGEINDEXDSC", "Maximum d'articles par page &agrave; afficher en m&ecirc;me temps du cot&eacute; utilisateur.");
define("_MI_PUB_PRINTLOGOURL", "[OPTIONS D'IMPRESSION] Url du logo imprim&eacute;");
define("_MI_PUB_PRINTLOGOURLDSC", "Url du logo qui sera imprim&eacute; dans le haut de chaque article");
define("_MI_PUB_RECENTITEMS", "Articles r&eacute;cents(D&eacute;tails)");
define("_MI_PUB_SHOW_RSS", "[OPTIONS DE CONTENU] Afficher le lien pour le fil RSS");
define("_MI_PUB_SHOW_RSSDSC", "");
define("_MI_PUB_SHOW_SUBCATS", "[OPTIONS DE CONTENU] Afficher les sous cat&eacute;gories");
define("_MI_PUB_SHOW_SUBCATS_ALL", "Afficher toutes les sous-cat&eacute;gories");
define("_MI_PUB_SHOW_SUBCATS_DSC", "Choisissez d'afficher ou non les sous cat&eacute;gories de chaque cat&eacute;gorie dans la page d'index et de cat&eacute;gories du module");
define("_MI_PUB_SHOW_SUBCATS_NO", "Ne pas afficher les sous-cat&eacute;gories");
define("_MI_PUB_SHOW_SUBCATS_NOTEMPTY", "Afficher les sous-cat&eacute;gories qui contiennent des articles");
define("_MI_PUB_SUB_SMNAME1", "Proposer un article");
define("_MI_PUB_SUB_SMNAME2", "Articles populaires");
define("_MI_PUB_SUBMITMSG", "[OPTIONS DE CONTENU] Message d'introduction de la page de proposition d'articles:");
define("_MI_PUB_SUBMITMSGDEF", "");
define("_MI_PUB_SUBMITMSGDSC", "Ce message sera affich&eacute; dans a page de proposition d'articles.");
define("_MI_PUB_TITLE_SIZE", "[OPTIONS DE FORMAT] Taille du titre:");
define("_MI_PUB_TITLE_SIZEDSC", "Choisissez la taille maximale du titre dans la page d'affichage des articles.");
define("_MI_PUB_UPLOAD", "[PERMISSIONS] Permettre le chargement de fichiers par les utilisateurs?");
define("_MI_PUB_UPLOADDSC", "D&eacute;termine si l'utilisateur peut 'uploader' sur le site des fichiers &agrave; joindre aux articles?");
define("_MI_PUB_USEREALNAME", "[OPTIONS DE FORMAT] Utiliser le nom r&eacute;el des utilisateurs");
define("_MI_PUB_USEREALNAMEDSC", "Quand le nom d'un utilisateur est affich&eacute;, utiliser son nom r&eacute;el si son profil contient cette information.");
define("_MI_PUB_VERSION_HISTORY", "Historique de la version");
define("_MI_PUB_WARNING_BETA", "Ce module est fourni en l'&eacute;tat, sans aucune garantie de quelque nature que ce soit. Ce module reste une BETA, signifiant qu'il est toujours l'objet d'un d&eacute;veloppement intense. Cette distribution n'est pr&eacute;vue que pour des <b>tests</b> et nous <b>insistons fortement</b> sur le fait de ne pas l'utiliser dans un environnement de production ou sur un site web accessible au public.");
define("_MI_PUB_WARNING_FINAL", "Ce module est fourni en l'&eacute;tat, sans aucune garantie de quelque nature que ce soit. Bien que ce module ne soit plus une BETA, il reste l\'objet d\'un d&eacute;veloppement important. Cette distribution est utilisable dans un environnement de production ou sur un site web accessible au public, o&ugrave; seule votre responsabilit&eacute;, et non celle de l\'auteur, sera engag&eacute;e.");
define("_MI_PUB_WARNING_RC", "Ce module est fourni en l'&eacute;tat, sans aucune garantie de quelque nature que ce soit. Bien que ce module ne soit plus une BETA, il reste l\'objet d\'un d&eacute;veloppement important. Cette distribution est utilisable dans un environnement de production ou sur un site web accessible au public, o&ugrave; seule votre responsabilit&eacute;, et non celle de l\'auteur, sera engag&eacute;e.");
define("_MI_PUB_WELCOME", "[OPTIONS DE CONTENU] Afficher le message de bienvenue et son titre:");
define("_MI_PUB_WELCOMEDSC", "Si vous chisissez 'OUI', la page d'accueil du module affichera 'Bienvenue dans la 'Publisher' de...', suivi par le message d'accueil cr&eacute;&eacute; pr&eacute;c&eacute;demment. Sinon, aucune de ces lignes ne sera affich&eacute;e.");
define("_MI_PUB_WHOWHEN", "[OPTIONS DE CONTENU] Afficher l'auteur et la date?");
define("_MI_PUB_WHOWHENDSC", "Choisissez 'Oui' pour afficher les informations sur l'auteur et la date dans chaque article");
define("_MI_PUB_WYSIWYG", "[OPTIONS DE FORMAT]Type d'&eacute;diteur ");
define("_MI_PUB_WYSIWYGDSC", "S&eacute;lectionner le type d.diteur que vous d&eacute;sirez utiliser. Veuillez noter que tout autre &eacute;diteur que XoopsEditor doit &ecirc;tre install&eacute; sur votre site.");

define("_MI_PUB_PV_TEXT", "Message pour la vue partielle");
define("_MI_PUB_PV_TEXTDSC", "Message qui sera affich&eacute; à la place du corps du texte pour la vue partielle.");
define("_MI_PUB_PV_TEXT_DEF", "Pour lire l'article complet, vous devez vous inscrire au site.");

define("_MI_PUB_SEOMODNAME", "Nom du module pour l'URL Rewriting");
define("_MI_PUB_SEOMODNAMEDSC", "Si l'URL Rewriting eas activé pour ce module, voici le nom de module qui sera utilisé. Par exemple : http://yoursite.com/smartection/...");

define("_MI_PUB_ARTCOUNT", "[OPTIONS] Afficher le nombre d'articles");
define("_MI_PUB_ARTCOUNTDSC", "Choisissez 'Oui' pour afficher le nombre d'articles de chaque catégorie dans la table de sommaire des catégories. Veuillez noter que le module ne compte actuellement QUE les articles dans une catégorie et ne tient pas compte des articles des sous-catégories de ladite catégorie.");

define("_MI_PUB_LATESTFILES", "Derniers fichiers uploadés");

define("_MI_PUB_PATHSEARCH", "[OPTIONS DE FORMAT] Afficher le chemin de la catégorie dans les résultats de recherche");
define("_MI_PUB_PATHSEARCHDSC", "");
define("_MI_PUB_SHOW_SUBCATS_NOMAIN", "Display sub-categories on index page only");
define("_MI_PUB_RATING_ENABLED", "Enable rating system");
define("_MI_PUB_RATING_ENABLEDDSC", "This features requires the SmartObject Framework");

define("_MI_PUB_DISPBREAD", "Afficher le fil d'ariane");
define("_MI_PUB_DISPBREADDSC", "Breadcrumb navigation displays the current page's context within the site structure.");

define("_MI_PUB_DATE_TO_DATE", "D'une date à une autre");
?>