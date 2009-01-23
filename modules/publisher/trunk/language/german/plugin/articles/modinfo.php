<?php

/**
* $Id: modinfo.php 331 2007-12-23 16:01:11Z malanciault $
* Module: Publisher
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

// Sub menus in main menu block
define("_MI_PUB_SUB_SMNAME1", "Artikel Einreichen");
define("_MI_PUB_SUB_SMNAME2", "Popul&auml;re Artikel");

// Config options
define('_MI_PUB_ALLOWADMINHITS', 'Admin Z&auml;hler liest :');
define('_MI_PUB_ALLOWADMINHITSDSC', 'Wenn Administratoren sich einen Artikel ansieht, soll der Z&auml;hler dies mitz&auml;hlen?');
define('_MI_PUB_ALLOWCOMMENTS', "Kommentare auf Artikelebene kontrollieren :");
define('_MI_PUB_ALLOWCOMMENTSDSC', "Sollten Sie 'Ja' w&auml;hlen, werden Kommentare nur bei denjenigen Artikeln angezeigt, welche die Kommentareoption eingestellt haben.<br /><br />Sollten Sie 'Nein' w&auml;hlen, so werden die Kommentare auf globaler Ebene kontrolliert (weiteres unter 'Regeln f&uuml;r Kommentare', etwas weiter unten).");
define("_MI_PUB_ALLOWSUBMIT", "Benutzer Einsendungen :");
define("_MI_PUB_ALLOWSUBMITDSC", "Soll es den Benutzern gestatted sein, Artikel einzureichen?");
define("_MI_PUB_ALLOWUPLOAD", "Hochladen von Benutzer Dateien ");
define("_MI_PUB_ALLOWUPLOADDSC", "Soll es den Benutzern gestatted sein, Dateien auf Ihre Webseiten hochzuladen?");
define("_MI_PUB_ANONPOST", "Erlaube annoyme Beitr&auml;ge");
define("_MI_PUB_ANONPOSTDSC", "Soll es annoymen Benutzern gestatted sein, Artikel einzureichen?");
define('_MI_PUB_AUTOAP_SUBITEM', "Automatische Bewilligung von eingereichten Artikeln :");
define('_MI_PUB_AUTOAP_SUBITEMDSC', "Automatische Bewilligung von eingereichten Artikeln, ohne das Hinzutun des Administrators.");
define('_MI_PUB_CATPERPAGE', 'Maximal per Seite anzuzeigende Kategorien (benutzerseits):');
define('_MI_PUB_CATPERPAGEDSC', 'Mazimal per Seite anzuzeigende Kategorien, welche dem Benutzer zug&auml;gnlich sind.');
define('_MI_PUB_COLLAP_HEADING', "Klappbare Anzeige anzeigen :");
define('_MI_PUB_COLLAP_HEADING_DSC', "Sollten Sie die 'Ja' Option w&auml;hlen, wird die Kategoriezusammenfassung in einer klappbaren Anzeige dargestellt, zowie die sich darin befindenden Arikel. Sollten Sie die 'Nein' Option w&auml;hlen, so wird die klappbare Anzeige nicht dargestellt.");
define('_MI_PUB_DATEFORMAT', 'Datumsformat:');
define('_MI_PUB_DATEFORMATDSC', 'Benutzen Sie die sich im letzten Abschnitt befindlichen Teil in language/english/global.php, um das Anzeigeformat einzustellen. Beispiel: &quot;d-M-Y H:i&quot; zeigt &quot;30-M&auml;rz-2004 22:35&quot; an');
define('_MI_PUB_DISPLAY_CAT_SUMMARY', "Zusammenfassung der Kategorie anzeigen?");
define('_MI_PUB_DISPLAY_CAT_SUMMARY_DSC', "W&auml;hlen Sie 'Ja' aus, um in diesem Module die Zusammenfassung der Kategorien anzuzeigen.");
define("_MI_PUB_DISPLAY_CATEGORY", "Name der Kategorie anzeigen?");
define("_MI_PUB_DISPLAY_CATEGORY_DSC", "W&auml;hlen Sie 'Ja' aus, um einen Link zur Kategorie in deren Artikeln anzuzeigen.");
define("_MI_PUB_DISPLAY_COMMENT", "Kommentarz&auml;hler anzeigen?");
define("_MI_PUB_DISPLAY_COMMENT_DSC", "W&auml;hlen Sie 'Ja' aus, um den Kommentarz&auml;hler in den jeweiligen Artikeln anzuzeigen.");
define('_MI_PUB_DISPLAY_DATE_COL', "Zeige 'Ver&ouml;ffentlicht am' Kolumne an?");
define('_MI_PUB_DISPLAY_DATE_COLDSC', "Falls die 'Zusammenfassung' angezeigt wird, w&auml;hlen Sie 'Ja' aus, um das 'Ver&ouml;ffentlichungsdatum' in der Artikel Tabele auf der Indexseite, sowie der Kategorieseite anzuzeigen.");
define('_MI_PUB_DISPLAY_HITS_COL', "Zeige die 'Treffer' Kolumne an?");
define('_MI_PUB_DISPLAY_HITS_COLDSC', "Falls die 'Zusammenfassung' angezeigt wird, w&auml;hlen Sie 'Ja' aus, um die 'Teffer' des jeweiligen Artikels auf der Indexseite, sowie der Kategorieseite anzuzeigen.");
define('_MI_PUB_DISPLAY_LAST_ITEM', 'Zeige Neuste Artikel Kolumne an?');
define('_MI_PUB_DISPLAY_LAST_ITEMDSC', "W&auml;hlen Sie 'Ja' aus, um die neusten Artikel Kolumne auf der Indexseite, sowie der Kategorieseite, anzuzeigen.");
define('_MI_PUB_DISPLAY_LAST_ITEMS', 'Zeige liste neuster Artikel an?');
define('_MI_PUB_DISPLAY_LAST_ITEMS_DSC', "W&auml;hlen Sie 'Ja' aus, um eine Liste neuster Artikel auf der Indexseite.");
/* Ich bin nicht zufrieden mit der gewaehlten uebersetzung
 * 'last' mit 'neuster' zu ersetzen, doch kann ich zur Zeit nicht ausmachen
 * dies besser zu tun...
 */
define('_MI_PUB_DISPLAY_SBCAT_DSC', 'Subkategorienbeschreibung anzeigen?');
define('_MI_PUB_DISPLAY_SBCAT_DSCDSC', "W&auml;hlen Sie 'Ja' aus, um die Beschbreibung der Subkategorie anzuzeigen.");
define("_MI_PUB_DISPLAY_WHOWHEN", "Zeige den Author und das Ver&ouml;ffentlichungsdatum an?");
define("_MI_PUB_DISPLAY_WHOWHEN_DSC", "W&auml;hlen Sie bitte 'Ja', um den Author, sowie das Ver&ouml;ffentlichungsdatum anzuzeigen.");
define('_MI_PUB_DISPLAYTYPE', "Artikel Darstellungsart:");
define('_MI_PUB_DISPLAYTYPE_FULL', "Volltext");
define('_MI_PUB_DISPLAYTYPE_SUMMARY', "Zusammenfassung");
define('_MI_PUB_DISPLAYTYPEDSC', "Bei der Auswahlt von 'Zusammenfassung', werden lediglich der Autor, das Ver&ouml;ffentlichungsdatum, sowie die Treffer des Artikels in der jeweiligen Kategorie angezeigt. Bei der 'Volltext' Auswahl, wird der komplette Artikel in der jeweiligen Kategorie, dargestellt.");
define('_MI_PUB_FILEUPLOADDIR', 'Hochlademappe f&uuml;r angef&uuml;gte Dateien :');
define('_MI_PUB_FILEUPLOADDIRDSC', "Die Mappe in welche Dateien, die hochgeladen und Artikeln angef&uuml;gt werden, abgespeichert werden sollen. Bitte keine Schr&auml;gstriche, weder vor, noch hinter, anf&uuml;gen.");
define('_MI_PUB_HELP_CUSTOM', "Individueller Pfad");
define('_MI_PUB_HELP_INSIDE', "Im Module");
define('_MI_PUB_HELP_PATH_CUSTOM', "Individueller Pfad der Publisher Hilfsdateien");
define('_MI_PUB_HELP_PATH_CUSTOM_DSC', "Falls Sie 'Individueller Pfad' in der vorherigen Option 'Individueller Pfad der Publisher Hilfsdateien' ausgew&auml;hlt haben, geben sie bitte die exacte URL der Publisher's in diesem Format an : http://www.ihreseiten.de/doc");
define('_MI_PUB_HELP_PATH_SELECT', "Pfad zu den Publisher Hilfsdateien");
define('_MI_PUB_HELP_PATH_SELECT_DSC', "W&auml;hlen Sie bitte aus, von wo aus Sie die Publisher Hilfsdateien erreichen m&ouml;chten. Falls Sie das 'Publisher Hilfs Paket' haben, und dieses in 'modules/publisher/doc/' hochgeladen haben, k&ouml;nnen Sie 'Im Module' ausw&auml;hlen. Sie k&ouml;nnen selbstverst&auml;ndlich auch die Hilfsdateien von docs.xoops.org aus einsehen, falls Sie dies bei der Option angeben. Desweiteren k&ouml;nnen Sie in der nachfolgenden Option einen 'Individuellen Pfad' angeben, 'Individueller Pfad zu den Publisher Hilfsdateien'.");
define('_MI_PUB_INDEXWELCOMEMSG', 'Indexseite Wilkommensgruss :');
define('_MI_PUB_INDEXWELCOMEMSGDEF', ""); 
define('_MI_PUB_INDEXWELCOMEMSGDSC', 'Wilkommensgruss zur darstellung auf der Indexseite dieses Modules.');
define("_MI_PUB_ITEM_TYPE", "Artikelart:");
define("_MI_PUB_ITEM_TYPEDSC", "W&auml;len Sie die Artikelart, welche dieses Module kontrollieren wird.");
define('_MI_PUB_LAST_ITEM_SIZE', 'Gr&ouml;sse des letzten Artikels :');
define('_MI_PUB_LAST_ITEM_SIZEDSC', "Geben Sie bitte die maximale L&auml;nge der Titel an, welche in der 'Letzten Artikel Kolumne' angezeigt wird.");
/* schon wieder diese "unschoenheit"!!! */
define('_MI_PUB_ORDERBYDATE', 'Artikel nach Datum sortieren :');
define('_MI_PUB_ORDERBYDATEDSC', 'Falls Sie bei dieser Option &quot;Ja&quot; ausgew&auml;hlt haben, werden die Artikel dieser Kategorie, nach abfallendem Datum sortiert werden, anderfalls wird nach Gewichtung sortiert.');
define('_MI_PUB_OTHER_ITEMS_TYPE', 'Weitere Artikeldarstellungsarten');
define('_MI_PUB_OTHER_ITEMS_TYPE_ALL', "Alle Artikel");
define('_MI_PUB_OTHER_ITEMS_TYPE_DSC', 'Bitte w&auml;hlen Sie aus, wie weitere Artikel dieser Kategorie auf der Artikelseite dargestellt werden sollen.');
define('_MI_PUB_OTHER_ITEMS_TYPE_NONE', "Keine");
define('_MI_PUB_OTHER_ITEMS_TYPE_PREVIOUS_NEXT', "Vorheriger und nachfolgender Artikel");
define('_MI_PUB_PERPAGE', "Maximale Anzahl anzuzeigender Artikel (Administrationsseite):");
define('_MI_PUB_PERPAGEDSC', "Die maximale Anzahl per Seite, der im Administrationsbereich anzuzeigenden Artikel.");
define('_MI_PUB_PERPAGEINDEX', "Maximale Anzahl anzuzeigender Artikel (Benutzerseite):");
define('_MI_PUB_PERPAGEINDEXDSC', "Die maximale Anzahl per Seite, dem Besucher anzuzeigender Artikel.");
define('_MI_PUB_SHOW_SUBCATS', 'Subkategorien anzeigen');
define('_MI_PUB_SHOW_SUBCATS_DSC', "W&auml;hlen Sie bitte 'Ja' aus, um die Subkategorien unterhalb der Hauptkategorie anzuzeigen.");
define('_MI_PUB_SUBMITINTROMSG', 'Einf&uuml;hrungstext der Einreichungsseite :');
define('_MI_PUB_SUBMITINTROMSGDEF', "");
define('_MI_PUB_SUBMITINTROMSGDSC', 'Einf&uuml;hrungstext, welcher auf der Seite zum Einreichen von Artikeln dieses Modules dargestellt werden soll.');
define('_MI_PUB_TITLE_AND_WELCOME', 'Wilkommenstitle und Text darstellen :');
define('_MI_PUB_TITLE_AND_WELCOME_DSC', "Falls Sie bei dieser Option 'Ja' ge&auml;hlt haben sollten, wird 'Wikommen in der Publisher von...' dargestellt werden, gefolgt vom Wilkommenstext, welcher weiter unten eingegeben wird. Bei 'Nein' werden beide fallen gelassen, und nicht dargestellt.");
define('_MI_PUB_TITLE_SIZE', "Titelgr&ouml;sse :");
define('_MI_PUB_TITLE_SIZEDSC', "Stellen Sie die maximale Titel&auml;nge ein, f&uuml;r die Artikeleinzeldarstellungsseite.");
define('_MI_PUB_USE_WYSIWYG', "Den Koivi WYSIWYG editor benutzen?");
define('_MI_PUB_USE_WYSIWYG_DSC', "Die 'wysiwyg' Mappe muss in " . XOOPS_URL . "/class/ vorhanden sein");
define('_MI_PUB_USEIMAGENAVPAGE', 'Benutze Bildseitennavigation :');
define('_MI_PUB_USEIMAGENAVPAGEDSC', 'Falls Sie &quot;Ja&quot; angegeben haben, wird die Seitennavigation mittels Bilddarstellung erfolgen. Andernfalls wird die klassische Navigationsmethode benutzt.');
define('_MI_PUB_USEREALNAME', 'Benutze den b&uuml;rgerlichen Namen des Benutzers');
define('_MI_PUB_USEREALNAMEDSC', 'Wird der Benutzername ausgedruckt, so sollte, falls vorhanden, der b&uuml;rgerliche Name verwendet werden.');

// Names of admin menu items
define("_MI_PUB_ADMENU1", "Index");
define("_MI_PUB_ADMENU2", "Kategorien");
define("_MI_PUB_ADMENU3", "Artikel");
define("_MI_PUB_ADMENU4", "Zugangsberechtigungen");
define("_MI_PUB_ADMENU5", "Bl&ouml;cke und Gruppen");
define("_MI_PUB_ADMENU6", "Zum Module");

//Names of Blocks and Block information
define("_MI_PUB_ITEMSNEW", "Liste neuer Artikel");
define("_MI_PUB_ITEMSPOT", "Im Rampenlicht!");
define("_MI_PUB_ITEMSRANDOM_ITEM", "Zufallsbedingter Artikel!");
define("_MI_PUB_RECENTITEMS", "Neuste Artikel (Detail)");

// Text for notifications
define('_MI_PUB_CATEGORY_ITEM_NOTIFY', 'Kategorie Artikel');
define('_MI_PUB_CATEGORY_ITEM_NOTIFY_DSC', 'Benachrichtigungsoptionenen welche f&uuml;r diese Kategorie zutreffen.');
define('_MI_PUB_CATEGORY_ITEM_PUBLISHED_NOTIFY', "Ver&ouml;ffentlichung eines neuen Artikels");
define('_MI_PUB_CATEGORY_ITEM_PUBLISHED_NOTIFY_CAP', "Benachrichtgen Sie mich, falls ein neuer Artikel in dieser Kategorie ver&ouml;ffentlicht wird.");   
define('_MI_PUB_CATEGORY_ITEM_PUBLISHED_NOTIFY_DSC', "Benachrichtigen erhalten, falls ein neuer Artikel in dieser Kategorie ver&ouml;ffentlicht wird.");      
define('_MI_PUB_CATEGORY_ITEM_PUBLISHED_NOTIFY_SBJ', "[{X_SITENAME}] {X_MODULE} automatische Benachrichtigung : Ein neuer Artikel wurde in dieser Kategorie ver&ouml;ffentlicht"); 
define('_MI_PUB_CATEGORY_ITEM_SUBMITTED_NOTIFY', "'Einreichung eines Artikels");
define('_MI_PUB_CATEGORY_ITEM_SUBMITTED_NOTIFY_CAP', "Benachrichtigen Sie mich, falls ein neuer Artiekl f&uuml;r diese Kategorie eingereicht wird.");   
define('_MI_PUB_CATEGORY_ITEM_SUBMITTED_NOTIFY_DSC', "Benachrichtigung erhalten, falls ein neuer Artikel f&uuml;r diese Kategorie eingereicht wird.");      
define('_MI_PUB_CATEGORY_ITEM_SUBMITTED_NOTIFY_SBJ', "[{X_SITENAME}] {X_MODULE} automatische Benachrichtigung : Einreichung eines neuen Artikels in dieser Kategorie"); 
define('_MI_PUB_GLOBAL_ITEM_CATEGORY_CREATED_NOTIFY', 'Neue Kategorie');
define('_MI_PUB_GLOBAL_ITEM_CATEGORY_CREATED_NOTIFY_CAP', 'Benachrichtigen Sie mich, falls eine neue Katgorie erstellt wird.');
define('_MI_PUB_GLOBAL_ITEM_CATEGORY_CREATED_NOTIFY_DSC', 'Benachrichtigung erhalten, falls eine neue Kategorie erstellt wird.');
define('_MI_PUB_GLOBAL_ITEM_CATEGORY_CREATED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} automatische Benachrichtigung : Neue Kategorie');
define('_MI_PUB_GLOBAL_ITEM_NOTIFY', "Globale Artikel");
define('_MI_PUB_GLOBAL_ITEM_NOTIFY_DSC', "Benachrichtigungsoptionen welche f&uuml;r alle Artikel zutreffen.");
define('_MI_PUB_GLOBAL_ITEM_PUBLISHED_NOTIFY', "Ver&ouml;ffentlichung eines neuen Artikels");
define('_MI_PUB_GLOBAL_ITEM_PUBLISHED_NOTIFY_CAP', "Benachrichtigen Sie mich, falls ein neuer Artikel ver&ouml;ffentlicht wird.");
define('_MI_PUB_GLOBAL_ITEM_PUBLISHED_NOTIFY_DSC', "Benachrichtigung erhalten, falls ein neuer Artikel ver&ouml;ffentlicht wird.");
define('_MI_PUB_GLOBAL_ITEM_PUBLISHED_NOTIFY_SBJ', "[{X_SITENAME}] {X_MODULE} auto-notify : Ver&ouml;ffentlichung eines neuen Artikels");
define('_MI_PUB_GLOBAL_ITEM_SUBMITTED_NOTIFY', "Artikel eingereicht");
define('_MI_PUB_GLOBAL_ITEM_SUBMITTED_NOTIFY_CAP', "Benachrichtigen sie mich, falls ein Artikel eingereicht wird, und auf bewilligung wartet..");
define('_MI_PUB_GLOBAL_ITEM_SUBMITTED_NOTIFY_DSC', "Benachrichtigung erhalten, falls ein Artikel eingereicht wird, und auf bewilligung wartet.");
define('_MI_PUB_GLOBAL_ITEM_SUBMITTED_NOTIFY_SBJ', "[{X_SITENAME}] {X_MODULE} automatische Benachrichtigung : Neuer Artikel eingereicht");
define('_MI_PUB_ITEM_APPROVED_NOTIFY', "Artikel bewilligt");
define('_MI_PUB_ITEM_APPROVED_NOTIFY_CAP', "Benachrichtigen sie mich, falls der Artikel bewilligt wird.");   
define('_MI_PUB_ITEM_APPROVED_NOTIFY_DSC', "Benachrichtgung erhalten, falls der Artikel bewilligt wird.");      
define('_MI_PUB_ITEM_APPROVED_NOTIFY_SBJ', "[{X_SITENAME}] {X_MODULE} automatische Benachrichtigung : Artikel bewilligt"); 
define('_MI_PUB_ITEM_NOTIFY', "Article");
define('_MI_PUB_ITEM_NOTIFY_DSC', "Benachrichtigugsoptionen f&uuml;r den aktuellen Artikel.");
define('_MI_PUB_ITEM_REJECTED_NOTIFY', "Artikel abgelehnt");
define('_MI_PUB_ITEM_REJECTED_NOTIFY_CAP', "Benachrichtigen Sie mich, falls der Artikel abgelehnt wird..");   
define('_MI_PUB_ITEM_REJECTED_NOTIFY_DSC', "Benachrichtigung erhalten, falls der Artikel abgelehnt wird.");      
define('_MI_PUB_ITEM_REJECTED_NOTIFY_SBJ', "[{X_SITENAME}] {X_MODULE} automatische Benachrichtigung : Artikel abgelehnt"); 

?>