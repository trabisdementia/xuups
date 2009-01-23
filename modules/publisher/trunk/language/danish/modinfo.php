<?php

/**
* $Id: modinfo.php,v 1.48 2007/02/03 16:23:35 malanciault Exp $
* Module: Publisher
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

// Module Info
// The name of this module

global $xoopsModule;

define('_MI_PUB_ADMENU1', 'Indeks');
define('_MI_PUB_ADMENU2', 'Kategorier');
define('_MI_PUB_ADMENU3', 'Artikler');
define('_MI_PUB_ADMENU4', 'Rettigheder');
define('_MI_PUB_ADMENU5', 'Blokke og grupper');
define('_MI_PUB_ADMENU6', 'Filtyper');
define('_MI_PUB_ADMENU7', 'Gå til modulet');

define('_MI_PUB_ADMINHITS', '[INDHOLDS MULIGHEDER] Læst af administrator?');
define('_MI_PUB_ADMINHITSDSC', 'Tillad at administrators hits tælles med i antallet af læste gange?');
define('_MI_PUB_ALLOWSUBMIT', '[RETTIGHEDER] Bruger indsendelser?');
define('_MI_PUB_ALLOWSUBMITDSC', 'Tillad brugere at indsende artikler til din side?');
define('_MI_PUB_ANONPOST', '[RETTIGHEDER] Tillad anonym indsendelse?');
define('_MI_PUB_ANONPOSTDSC', 'Tillad at anonyme brugere indsender artikler?');
define('_MI_PUB_AUTHOR_INFO', 'Udviklere');
define('_MI_PUB_AUTHOR_WORD', 'Udviklernes ord');
define('_MI_PUB_AUTOAPP', '[RETTIGHEDER] Auto-godkend indsendte artikler?');
define('_MI_PUB_AUTOAPPDSC', 'Auto-godkender artikler uden administrators indblanding');
define('_MI_PUB_BCRUMB', '[PRINT MULIGHEDER] Vis modulnavnet i brevhovedet?');
define('_MI_PUB_BCRUMBDSC', 'hvis du vælger ja, vil brevhovedet vise "Publisher > kategori-navn > artikel navn". <br>ellers vil kun "kategori navn > artikel navn" blive vist.');
define('_MI_PUB_BOTH_FOOTERS', 'Begge fodnoter');
define('_MI_PUB_BY', 'af');
define('_MI_PUB_CATEGORY_ITEM_NOTIFY', 'Artikler i kategorien');
define('_MI_PUB_CATEGORY_ITEM_NOTIFY_DSC', 'Notifikations muligheder til den aktuelle kategori');
define('_MI_PUB_CATEGORY_ITEM_PUBLISHED_NOTIFY', 'Ny artikel udgivet');
define('_MI_PUB_CATEGORY_ITEM_PUBLISHED_NOTIFY_CAP', 'Informér mig når en ny artikel udgives i den aktuelle kategori');
define('_MI_PUB_CATEGORY_ITEM_PUBLISHED_NOTIFY_DSC', 'Modtag notifikation når en ny artikel udgives i den aktuelle kategori.');
define('_MI_PUB_CATEGORY_ITEM_PUBLISHED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} Auto-besked : Ny artikel udgivet i kategorien');
define('_MI_PUB_CATEGORY_ITEM_SUBMITTED_NOTIFY', '\'Artikel indsendt');
define('_MI_PUB_CATEGORY_ITEM_SUBMITTED_NOTIFY_CAP', 'Informer mig når en ny artikel er indsendt i den aktuelle kategori');
define('_MI_PUB_CATEGORY_ITEM_SUBMITTED_NOTIFY_DSC', 'Modtag notifikation når en ny artikel er indsendt i den aktuelle kategori');
define('_MI_PUB_CATEGORY_ITEM_SUBMITTED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} Auto-besked : Ny artikel indsendt i kategorien');
define('_MI_PUB_CATLIST_IMG_W', '[FORMATERINGS MULIGHEDER] Kategori billed liste bredde');
define('_MI_PUB_CATLIST_IMG_WDSC', 'Angiver bredden på kategori billedet når kategorier listes');
define('_MI_PUB_CATMAINIMG_W', '[FORMATERINGS MULIGHEDER] Kategori billed bredde');
define('_MI_PUB_CATMAINIMG_WDSC', 'Angiver bredden på kategori billedet');
define('_MI_PUB_CATPERPAGE', '[FORMATERINGS MULIGHEDER] Maksimalt antal kategorier på side (for bruger)?');
define('_MI_PUB_CATPERPAGEDSC', 'Angiver det maksimale antal top-kategorier der vises pr. side for brugeren?');
define('_MI_PUB_CLONE', '[Rettigheder] Tillad artikel kopiering ?');
define('_MI_PUB_CLONEDSC', 'Vælg \'Ja\' for at tillade brugere med gyldige rettigheder, at kopierer en artikel.');
define('_MI_PUB_COLLHEAD', '[FORMATERINGS MULIGHEDER] Vis den sammenfoldelige menubar?');
define('_MI_PUB_COLLHEADDSC', 'Hvis du sætter denne mulighed til \'Ja\', vil kategoriernes the Categories resumé blive vist i en sammenfoldet menu, som selve artiklerne. Hvis du sætter muligheden til  \'Nej\', vil den sammenfoldede bar ikke blive vist.');
define('_MI_PUB_COMMENTS', '[RETTIGHEDER] Kontroller kommentar i artikel niveau?');
define('_MI_PUB_COMMENTSDSC', 'Hvis du sætter denne mulighed til  \'Ja\', vil du kun se kommentar på de artikler, der tillader kommentar.<br /><br />Vælg \'Nej\' for at have kommentar vedligeholdt globalt. (Kig under \'Kommentar regler\'.');
define('_MI_PUB_DATEFORMAT', '[FORMAT MULIGHEDER] Dato format:');
define('_MI_PUB_DATEFORMATDSC', 'Brug den sidste del af language/english/global.php for at vise den stil du vil vise. F.eks: "d-M-Y H:i" Skriver "30-Mar-2004 22:35"');
define('_MI_PUB_DEMO_SITE', 'SmartFactory Demo Side');
define('_MI_PUB_DEVELOPER_CONTRIBUTOR', 'Bidragyder(e)');
define('_MI_PUB_DEVELOPER_CREDITS', 'Anerkendelser');
define('_MI_PUB_DEVELOPER_EMAIL', 'Email');
define('_MI_PUB_DEVELOPER_LEAD', 'Hoved udvikler(e)');
define('_MI_PUB_DEVELOPER_WEBSITE', 'Website');
define('_MI_PUB_DISCOM', '[INDHOLD MULIGHEDER] Vis kommentar tæller ?');
define('_MI_PUB_DISCOMDSC', 'Vælg \'Ja\' for at vise kommentar antal i den individuelle artikel');
define('_MI_PUB_DISDATECOL', '[INDHOLD MULIGHEDER] Vis \'Udgivet den\' rækken ?');
define('_MI_PUB_DISDATECOLDSC', 'Når \'Resume\' visningen er valgt, marker \'Ja\' for at vise en \'Udgivet den\' dato i genstans tabellen på indeks og brugersiden.');
define('_MI_PUB_DCS', '[INDHOLD MULIGHEDER] Vis kategori resume ?');
define('_MI_PUB_DCS_DSC', 'Vælg \'Nej\' for ikke at vise kategoriresume på en kategoriside der ikke har subkategorier.');
define('_MI_PUB_DISPLAY_CATEGORY', 'Vis kategori navn ?');
define('_MI_PUB_DISPLAY_CATEGORY_DSC', 'Vælg \'Ja\' for at vise kategori link på den individuelle artikel');
define('_MI_PUB_DISPLAYTYPE_FULL', 'Fuld visning');
define('_MI_PUB_DISPLAYTYPE_LIST', 'Punktliste');
define('_MI_PUB_DISPLAYTYPE_WFSECTION', 'WFSection stil');
define('_MI_PUB_DISPLAYTYPE_SUMMARY', 'Resume Visning');
define('_MI_PUB_DISSBCATDSC', '[INDHOLD MULIGHEDER] Vis sub-kategori beskrivelse ?');
define('_MI_PUB_DISSBCATDSCDSC', 'Vælg \'Ja\' for at vise beskrivelsen af en sub-kategori på indeks og kategori siden.');
define('_MI_PUB_DISTYPE', '[FORMAT MULIGHEDER] Artiklers visnings type:');
define('_MI_PUB_DISTYPEDSC', 'Hvis \'Resume visning\' er valgt, bliver kun dato, titel og hits vist i en valgt kategori. if \'Fuld Visning\' er valgt, bliver hver artikel vist fuldt ud i en valgt kategori.');
define('_MI_PUB_FILEUPLOADDIR', 'Tilføjede filer oploads mappe:');
define('_MI_PUB_FILEUPLOADDIRDSC', 'Mappen hvori filerne vil blive importeret når tilknyttet artikler. Skriv ikke begyndende eller afsluttende skråstreger.');
define('_MI_PUB_FOOTERPRINT', '[PRINT MULIGHEDER] Print sidefod');
define('_MI_PUB_FOOTERPRINTDSC', 'Sidefod der printes for hver artikel');
define('_MI_PUB_GLOBAL_ITEM_CATEGORY_CREATED_NOTIFY', 'Ny kategori');
define('_MI_PUB_GLOBAL_ITEM_CATEGORY_CREATED_NOTIFY_CAP', 'Giv besked når en ny kategori oprettes.');
define('_MI_PUB_GLOBAL_ITEM_CATEGORY_CREATED_NOTIFY_DSC', 'Modtage besked når en ny kategori er oprettet.');
define('_MI_PUB_GLOBAL_ITEM_CATEGORY_CREATED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} auto-besked : Ny kategori');
define('_MI_PUB_GLOBAL_ITEM_NOTIFY', 'Globale Artikler');
define('_MI_PUB_GLOBAL_ITEM_NOTIFY_DSC', 'Besked muligheder der gælder alle artikler');
define('_MI_PUB_GLOBAL_ITEM_PUBLISHED_NOTIFY', 'Ny artikel udgivet');
define('_MI_PUB_GLOBAL_ITEM_PUBLISHED_NOTIFY_CAP', 'Giv besked når en ny artikel er udgivet.');
define('_MI_PUB_GLOBAL_ITEM_PUBLISHED_NOTIFY_DSC', 'Modtag besked når en ny artikel er udgivet.');
define('_MI_PUB_GLOBAL_ITEM_PUBLISHED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} auto-besked : Ny artikel udgivet');
define('_MI_PUB_GLOBAL_ITEM_SUBMITTED_NOTIFY', 'Artikel indgivet');
define('_MI_PUB_GLOBAL_ITEM_SUBMITTED_NOTIFY_CAP', 'Giv besked når en ny artikel er indgivet og venter på godkendelse');
define('_MI_PUB_GLOBAL_ITEM_SUBMITTED_NOTIFY_DSC', 'Modtag besked når en ny artikel indgives og den venter på godkendelse');
define('_MI_PUB_GLOBAL_ITEM_SUBMITTED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} auto-besked : Ny artikel indgivet');
define('_MI_PUB_HEADERPRINT', '[PRINT MULIGHEDER] Print sidehoved');
define('_MI_PUB_HEADERPRINTDSC', 'Sidehoved der printes for hver artikel');
define('_MI_PUB_HELP_CUSTOM', 'Brugerdefineret sti');
define('_MI_PUB_HELP_INSIDE', 'Indeni modulet');
define('_MI_PUB_HELP_PATH_CUSTOM', 'Brugerdefineret sti til Publishers hjælpefiler');
define('_MI_PUB_HELP_PATH_CUSTOM_DSC', 'if you selected \'Custom path\' in the previous option \'Path of Publisher\'s help files\', please specify the URL of Publisher\'s help files, in that format : http:
define("_MI_PUB_HELP_PATH_SELECT", "Path of Publisher\'s help files');
define('_MI_PUB_HELP_PATH_SELECT_DSC', 'Vælg hvorfra du gerne vil ha adgang til publishers hjælpesider. Hvis du har downloaded pakken med \'Publishers\'s Help Package\' og oploadedet det til \'modules/publisher/doc/\', så kan du vælge \'Inside the module\'. Du kan også få adgang til modulets hjælpefiler direkte fra docs.xoops.org ved at vælge denne i valgfeltet. Du kan også vælge \'brugerbestemt sti\' og selv specificere adressen i det næste konfigurations felt \'Brugerbestemt sti til Publisher\'s hjælpe filer\'');
define('_MI_PUB_HITSCOL', '[INDHOLDS MULIGHEDER] Vis \'Hits\' rækken');
define('_MI_PUB_HITSCOLDSC', 'Når \'Resume\' visning er valgt, vælg \'Ja\' for at vise \'Hits\' column in the items table on the index and category page.');
define('_MI_PUB_HLCOLOR', '[FORMAT MULIGHEDER] Fremhævningsfarve ved stikord');
define('_MI_PUB_HLCOLORDSC', 'Farven på stikord i søge funktionen');
define('_MI_PUB_IMAGENAV', '[FORMAT OPTIONS] Use the image Page Navigation:');
define('_MI_PUB_IMAGENAVDSC', 'Hvis du har sat denne mulighed til "Ja", vil sidenavigationen blive vist med ikoner ellers vil den originale side navigation blive anvendt.');
define('_MI_PUB_INDEXFOOTER', '[INDHOLDS MULIGHEDER] Indeks sidefod');
define('_MI_PUB_INDEXFOOTER_SEL', 'Indeks sidefod');
define('_MI_PUB_INDEXFOOTERDSC', 'Sidefod der vises på indeks siden til modulet');
define('_MI_PUB_INDEXMSG', '[INDHOLDS MULIGHEDER] Hovedsides velkomst hilsen:');
define('_MI_PUB_INDEXMSGDEF', '');
define('_MI_PUB_INDEXMSGDSC', 'Velkomsthilsen der vises på hovedsiden af modulet');
define('_MI_PUB_ITEM_APPROVED_NOTIFY', 'Artiklen er godkendt');
define('_MI_PUB_ITEM_APPROVED_NOTIFY_CAP', 'Giv besked når artiklen er godkendt');
define('_MI_PUB_ITEM_APPROVED_NOTIFY_DSC', 'Modtag besked når artiklen er godkendt');
define('_MI_PUB_ITEM_APPROVED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} auto-besked : Artiklen er godkendt');
define('_MI_PUB_ITEM_NOTIFY', 'Artikel');
define('_MI_PUB_ITEM_NOTIFY_DSC', 'Beskeds mulighed som gælder denne artikel');
define('_MI_PUB_ITEM_REJECTED_NOTIFY', 'Artiklen er ikke godkendt');
define('_MI_PUB_ITEM_REJECTED_NOTIFY_CAP', 'Giv besked hvis artiklen ikke godkendes');
define('_MI_PUB_ITEM_REJECTED_NOTIFY_DSC', 'Modtag besked hvis artiklen ikke godkendes');
define('_MI_PUB_ITEM_REJECTED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} auto-besked : Artiklen blev ikke godkendt');
define('_MI_PUB_ITEM_TYPE', 'Element type:');
define('_MI_PUB_ITEM_TYPEDSC', 'Vælg det element som dette modul skal håndtere');
define('_MI_PUB_ITEMFOOTER', '[INDHOLDS MULIGHEDER] Element fod');
define('_MI_PUB_ITEMFOOTER_SEL', 'Element fod');
define('_MI_PUB_ITEMFOOTERDSC', 'Fod som vises for hver artikel');
define("_MI_PUB_ITEMSMENU", "Kategoriers Menu block");
//bd tree block hack
define('_MI_PUB_ITEMSTREE', 'Tree blok');
//--/bd
define('_MI_PUB_ITEMSNEW', 'Seneste elementer liste');
define('_MI_PUB_ITEMSPOT', 'I søgelyset !');
define('_MI_PUB_ITEMSRANDOM_ITEM', 'Tilfældig element !');
define('_MI_PUB_LASTITEM', '[INDHOLDS MULIGHEDER] Vis seneste element kolonne ?');
define('_MI_PUB_LASTITEMDSC', 'Vælg \'Ja\' for at vise det seneste element i hver kategori på hoved og kategori siden');
define('_MI_PUB_LASTITEMS', '[INDHOLDS MULIGHEDER] Vis listen af seneste udgivet artikler?');
define('_MI_PUB_LASTITEMSDSC', 'Vælg \'Ja\' for at vise listen på den første side af modulet');
define('_MI_PUB_LASTITSIZE', '[FORMATERINGS MULIGHEDER] Senest elements størrelse :');
define('_MI_PUB_LASTITSIZEDSC', 'Indstil maksimum størrelsen på titlen i det seneste elemnts kolonne');
define('_MI_PUB_LINKPATH', '[FORMATERINGS MULIGHEDER] Vis link på nuværende sti:');
define('_MI_PUB_LINKPATHDSC', 'Denne mulighed tillader brugeren at gå tilbage via klik på et element der viser nuværende sti på hver sidetop.');
define('_MI_PUB_MAX_HEIGHT', '[TILLADELSER] Maksimumhøjde på oploadet billede');
define('_MI_PUB_MAX_HEIGHTDSC', 'Maksimum højden på billeder der kan oploades');
define('_MI_PUB_MAX_SIZE', '[TILLADELSER] Maksimum filstørrelse');
define('_MI_PUB_MAX_SIZEDSC', 'Maksimum størrelsen (I bytes) på en fil der kan oploades');
define('_MI_PUB_MAX_WIDTH', '[TILLADELSER] Maksimum oploadet billed bredde');
define('_MI_PUB_MAX_WIDTHDSC', 'Maksimum bredde på et billede der kan oploades');
define('_MI_PUB_MD_DESC', 'Sektions Styrings System for din XOOPS side');
define('_MI_PUB_MD_NAME', 'Publisher');
define('_MI_PUB_MODULE_BUG', 'Rapporter en fejl i dette modul');
define('_MI_PUB_MODULE_DEMO', 'Demo side');
define('_MI_PUB_MODULE_DISCLAIMER', 'Fralæggelse af ansvar');
define('_MI_PUB_MODULE_FEATURE', 'Foreslå en ny egenskab til dette modul');
define('_MI_PUB_MODULE_INFO', 'Modul udviklings detaljer');
define('_MI_PUB_MODULE_RELEASE_DATE', 'Udgivelses dato');
define('_MI_PUB_MODULE_STATUS', 'Status');
define('_MI_PUB_MODULE_SUBMIT_BUG', 'Forelæg en fejl');
define('_MI_PUB_MODULE_SUBMIT_FEATURE', 'Forelæg et ønske om en egenskab');
define('_MI_PUB_MODULE_SUPPORT', 'Officiel hjælpe side');
define('_MI_PUB_NO_FOOTERS', 'Ingen');
define('_MI_PUB_ORDERBY', '[FORMAT MULIGHEDER] Sorterings orden');
define('_MI_PUB_ORDERBY_DATE', 'Dato Faldende');
define('_MI_PUB_ORDERBY_TITLE', 'Titel Stigende');
define('_MI_PUB_ORDERBY_WEIGHT', 'Vægt Stigende');
define('_MI_PUB_ORDERBYDSC', 'Vælg ordenen på elementerne gennem modulet');
define('_MI_PUB_OTHER_ITEMS_TYPE_ALL', 'Alle artikler');
define('_MI_PUB_OTHER_ITEMS_TYPE_NONE', 'Ingen');
define('_MI_PUB_OTHER_ITEMS_TYPE_PREVIOUS_NEXT', 'Foregående og Næste artikel');
define('_MI_PUB_OTHERITEMS', '[FORMAT MULIGHEDER] Andre artiklers visnings type');
define('_MI_PUB_OTHERITEMSDSC', 'Vælg hvordan du vil vise de andre artikler i kategorien på artikelsiden');
define('_MI_PUB_PERPAGE', '[FORMAT MULIGHEDER] Maks. antal artikler per side (Admin siden)');
define('_MI_PUB_PERPAGEDSC', 'Maksimum antal artikler der vises på en gang på admin siden');
define('_MI_PUB_PERPAGEINDEX', '[FORMAT MULIGHEDER] Maks. artikler per side (bruger side)');
define('_MI_PUB_PERPAGEINDEXDSC', '[UDSKRIVNINGS MULIGHEDER] Maks antal artikler der vises på en gang på bruger siden');
define('_MI_PUB_PRINTLOGOURL', '[UDSKRIVNINGS MULIGHEDER] Logo udskriv url');
define('_MI_PUB_PRINTLOGOURLDSC', 'Url på logoet som vil blive udskrevet på toppen af siden');
define('_MI_PUB_RECENTITEMS', 'Nyere elementer (detaljer)');
define('_MI_PUB_SHOW_RSS', '[INDHOLDS MULIGHEDER] Vis link på RSS ');
define('_MI_PUB_SHOW_RSSDSC', '');
define('_MI_PUB_SHOW_SUBCATS', '[INDHOLDS MULIGHEDER] Vis under kategorier');
define('_MI_PUB_SHOW_SUBCATS_ALL', 'Vis alle underkategorier');
define('_MI_PUB_SHOW_SUBCATS_DSC', 'Vælg hvorvidt du vil vise alle underkategorierne i kategorilisten på hovedsiden og på kategori siden af modulet');
define('_MI_PUB_SHOW_SUBCATS_NO', 'Vis ikke underkategorier');
define('_MI_PUB_SHOW_SUBCATS_NOTEMPTY', 'Vis ingen tomme underkategorier');
define('_MI_PUB_SUB_SMNAME1', 'Indgiv artikel');
define('_MI_PUB_SUB_SMNAME2', 'Populære artikler');
define('_MI_PUB_SUBMITMSG', '[INDHOLDS MULIGHEDER] Indgiv sideintro besked:');
define('_MI_PUB_SUBMITMSGDEF', '');
define('_MI_PUB_SUBMITMSGDSC', 'Intro besked der vises på indgivelses siden af modulet');
define('_MI_PUB_TITLE_SIZE', '[FORMAT MULIGHEDER] Titel størrelse:');
define('_MI_PUB_TITLE_SIZEDSC', 'Skriv maksimumstørrelsen på titlen på enkelt-element visnings siden.');
define('_MI_PUB_UPLOAD', '[TILLADELSER] Bruger filopload?');
define('_MI_PUB_UPLOADDSC', 'Tillad brugere at oploade filer vedhæftet artikler på din side?');
define('_MI_PUB_USEREALNAME', '[FORMAT MULIGHEDER] Anvend brugers rigtige navne');
define('_MI_PUB_USEREALNAMEDSC', 'Når der vises brugernavne så anvend brugerens rigtige navn hvis han har angivet et');
define('_MI_PUB_VERSION_HISTORY', 'Versions historik');
define('_MI_PUB_WARNING_BETA', 'Dette modul er som det er, uden nogen somhelst garantier. Dette modul er BETA, hvilket betyder det stadig undergår aktiv udvikling. Denne udgivelses anvendelse er sigtet <b>Test formål alene</b> og vi foreslår på det <b>kraftigste</b> at du ikke anvender det på en offentliggjort side elelr i et produktions miljø.');
define('_MI_PUB_WARNING_FINAL', 'Dette modul er som det er, uden nogen som helts garanti. Selvom modulet ikke er beta, så er det stadig under aktiv udvikling. Denne udgivelse kan anvendes på en offentliggjort side, men det er stadig på dit eget ansvar, hvilket betyder at forfatteren ikke kan blive gjort ansvarlig.');
define('_MI_PUB_WARNING_RC', 'Dette modul er som det er, uden nogen som helst garanti. Dette modul er kandidat til udgivelse og burde ikke anvendes på en offentliggjort side. Modulet er stadig under aktiv udvikling og anvendelsen er dit eget ansvar. Dette betyder at forfatteren ikke kan blive gjort ansvarlig.');
define('_MI_PUB_WELCOME', '[INDHOLDS MULIGHEDER] Vis velkomst titel og bested:');
define('_MI_PUB_WELCOMEDSC', 'hvis denne mulighed er sat til \'JA\', vil modulets hovedside vise titlen \'Velkommen til Publishers på...\', efterfult af understående velkomstbesked. Hvis muligheden er sat til \'Nej\', vil ingen af linjerne blive vist.');
define('_MI_PUB_WHOWHEN', '[INDHOLDSMULIGHEDER] Vis posterings dato');
define('_MI_PUB_WHOWHENDSC', 'Set to \'Yes\' to display the poster and date information in the individual article');
define('_MI_PUB_WYSIWYG', '[FORMAT MULIGHEDER] Editor type');
define('_MI_PUB_WYSIWYGDSC', 'Hvilken type af editor vil du anvende. Vær opmærksom på at den du vælger forskellig fra XoopsEditor skal være installeret på din side');

define('_MI_PUB_PV_TEXT', 'Delvis se artikel');
define('_MI_PUB_PV_TEXTDSC', 'Besked til artikler der tillader kun delvis visning.');
define('_MI_PUB_PV_TEXT_DEF', 'For at se den komplette side skal du være registreret bruger');

define('_MI_PUB_SEOMODNAME', 'Url omskrivnings modulnavn');
define('_MI_PUB_SEOMODNAMEDSC', 'Hvis URL omskrivning er tilladt for dette modul, er dette navnet på modulet der anvendes. F.eks. :Http:

define("_MI_PUB_ARTCOUNT", "Vis antal atikler');
define('_MI_PUB_ARTCOUNTDSC', 'Vælg \'Ja\' for at vise antal af artikler i hver kategori på kategori resumesiden. Vær opmærksom på at modulet nuværende kun tæller artikler fra hver kategori og tæller ikke underkategorier');

define('_MI_PUB_LATESTFILES', 'Seneste oploadet filer');

define('_MI_PUB_PATHSEARCH', '[FORMAT MULIGHEDER] Vis kategori sti i søge resultaterne');
define('_MI_PUB_PATHSEARCHDSC', '');
define("_MI_PUB_SHOW_SUBCATS_NOMAIN", "Display sub-categories on index page only");
define("_MI_PUB_RATING_ENABLED", "Enable rating system");
define("_MI_PUB_RATING_ENABLEDDSC", "This features requires the SmartObject Framework");

define("_MI_PUB_DISPBREAD", "Display the breadcrumb");
define("_MI_PUB_DISPBREADDSC", "Breadcrumb navigation displays the current page's context within the site structure.");

define('_MI_PUB_DATE_TO_DATE', 'Articles from date to date')
?>