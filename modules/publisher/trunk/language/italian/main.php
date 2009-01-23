<?php

/**
* $Id: main.php 331 2007-12-23 16:01:11Z malanciault $
* Module: Publisher
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

/*global $xoopsConfig, $xoopsModule, $xoopsModuleConfig;
if (isset($xoopsModuleConfig) && isset($xoopsModule) && $xoopsModule->getVar('dirname') == 'publisher') {
	$itemType = $xoopsModuleConfig['itemtype'];
} else {
	$hModule = &xoops_gethandler('module');
	$hModConfig = &xoops_gethandler('config');
	if ($publisher_Module = &$hModule->getByDirname('publisher')) {
		$module_id = $publisher_Module->getVar('mid');
		$publisher_Config = &$hModConfig->getConfigsByCat(0, $publisher_Module->getVar('mid'));
		$itemType = $publisher_Config['itemtype'];
	} else {
		$itemType = 'article';
	}	
}

include_once(XOOPS_ROOT_PATH . "/modules/publisher/language/" . $xoopsConfig['language'] . "/plugin/" . $itemType . "/main.php");
*/

define("_MD_PUB_ACTION", "Azione");
define("_MD_PUB_ADD_FILE", "Aggiungi un file");
define("_MD_PUB_ADD_FILE_INTRO", "Compila il modulo seguente per allegare un file a questo articolo : '%s'.");
define("_MD_PUB_ADD_FILE_TITLE", "Allega un file a questo articolo");
define("_MD_PUB_ADMIN_PAGE", ":: Menu di Amministrazione ::");
define("_MD_PUB_ALL", "Tutto");
define("_MD_PUB_ALLOWCOMMENTS", "Permetti di inviare commenti a questo articolo?");
define("_MD_PUB_APPROVE", "Approva");
define("_MD_PUB_BODY", "Articolo");
define("_MD_PUB_BODY_DSC", "Testo esteso dell'articolo");
define("_MD_PUB_BODY_REQ", "Articolo*");
define("_MD_PUB_CANCEL", "Cancella");
define("_MD_PUB_CATEGORY", "Categoria");
define("_MD_PUB_CATEGORY_DSC", "Categoria alla quale appartiene questo articolo.");
define("_MD_PUB_CATEGORY_EDIT", "Modifica categoria");
define("_MD_PUB_CATEGORY_SUMMARY", "Sommario di %s");
define("_MD_PUB_CATEGORY_SUMMARY_DESC", "Elenco di tutti gli articoli associati a questa categoria. Clicca sul titolo per vedere l'articolo completo.");
define("_MD_PUB_CATEGORY_SUMMARY_INFO", "Sub categorie associate %s.");
define("_MD_PUB_CLEAR", "Pulisci");
define("_MD_PUB_COMMENTS", "Commento(i)");
define("_MD_PUB_CREATE", "Crea un articolo");
define("_MD_PUB_DATE", "Data");
define("_MD_PUB_DATESUB", "Data");
define("_MD_PUB_DELETE", "Elimina questo articolo");
define("_MD_PUB_DESCRIPTION", "Descrizione");
define("_MD_PUB_DOHTML", "Abilita tags HTML ");
define("_MD_PUB_DOIMAGE", "Abilita immagini");
define("_MD_PUB_DOLINEBREAK", "Abilita le interruzioni di riga");
define("_MD_PUB_DOSMILEY", "Abilita le faccine");
define("_MD_PUB_DOWNLOAD_FILE", "Download questo file");
define("_MD_PUB_DOXCODE", "Abilita codici XOOPS");
define("_MD_PUB_EDIT", "Modifica questo articolo");
define("_MD_PUB_EMPTY", "In questa categoria non ci sono articoli o sub categorie");
define("_MD_PUB_ERROR_ITEM_NOT_SAVED", "Si è verificato un errore. L'articolo non è stato salvato nel database.");
define("_MD_PUB_FILE", "Files");
define("_MD_PUB_FILE_ADD", "Aggiungi un file");
define("_MD_PUB_FILE_ADDING", "Aggiungi un nuovo file");
define("_MD_PUB_FILE_ADDING_DSC", "Riempi il modulo per allegare un nuovo file a questo articolo.");
define("_MD_PUB_FILE_DESCRIPTION", "Descrizione");
define("_MD_PUB_FILE_DESCRIPTION_DSC", "Descrizione da associare al file.");
define("_MD_PUB_FILE_EDITING", "Modifica un file");
define("_MD_PUB_FILE_EDITING_DSC", "Puoi modificare questo file. Le modifiche saranno immediatamente visibili dal lato utente.");
define("_MD_PUB_FILE_EDITING_ERROR", "Si è verificato un errore nel tentativo di aggiornare il file.");
define("_MD_PUB_FILE_EDITING_SUCCESS", "Il file è stato modificato con successo.");
define("_MD_PUB_FILE_INFORMATIONS", "Informazioni del file");
define("_MD_PUB_FILE_NAME_DSC", "Nome che sarà usato per identificare il file.");
define("_MD_PUB_FILE_TO_UPLOAD", "File da caricare :");
define("_MD_PUB_FILE_TYPE", "Tipo di file");
define("_MD_PUB_FILENAME", "Nome file");
define("_MD_PUB_FILES_LINKED", "Files allegati");
define("_MD_PUB_FILEUPLOAD_ERROR", "Si è verificato un errore durante l'upload del file.");
define("_MD_PUB_FILEUPLOAD_SUCCESS", "Il file è stato caricato con successo.");
define("_MD_PUB_FINDITEMHERE", "Ho trovato questo articolo qui : ");
define("_MD_PUB_GOODDAY", "Buon giorno, ");
define("_MD_PUB_HITS", "Letture");
define("_MD_PUB_HITSDETAIL", "" . "Questo articolo è stato letto");
define("_MD_PUB_HOME", "Home");
define("_MD_PUB_INDEX_CATEGORIES_SUMMARY", "Sommario delle categorie");
define("_MD_PUB_INDEX_CATEGORIES_SUMMARY_INFO", "Elenco delle categorie principali e delle sub categorie. Seleziona una categoria per vedere gli articoli collegati.");
define("_MD_PUB_INDEX_ITEMS", "Ultime pubblicazioni");
define("_MD_PUB_INDEX_ITEMS_INFO", "Elenco delle pubblicazioni recenti");
define("_MD_PUB_INTITEM", "Guarda questo articolo su %s");
define("_MD_PUB_INTITEMFOUND", "Ho trovato un interessante articolo su %s");
define("_MD_PUB_ITEM", "articolo");
define("_MD_PUB_ITEM_CAP", "Articolo");
define("_MD_PUB_ITEM_RECEIVED_AND_PUBLISHED", "Articolo inviato e pubblicato. Grazie per il contributo!");
define("_MD_PUB_ITEM_RECEIVED_NEED_APPROVAL", "Articolo inviato, sarà pubblicato non un moderatore lo approverà.<br />Grazie per il contributo!");
define("_MD_PUB_ITEMCOMEFROM", "Questo articolo proviene da ");
define("_MD_PUB_ITEMS", "Articoli");
define("_MD_PUB_ITEMS_INFO", "Altri articoli in questa categoria.");
define("_MD_PUB_ITEMS_LINKS", "Precedente-Successivo");
define("_MD_PUB_ITEMS_TITLE", "Articoli in %s");
define("_MD_PUB_LAST_SMARTITEM", "Ultima pubblicazione");
define("_MD_PUB_MAIL", "Invia a un amico...");
define("_MD_PUB_MAINHEAD", "Benvenuto in");
define("_MD_PUB_MAINNOITEMS", "Nessuno articolo in questa categoria");
define("_MD_PUB_MAINNOSELECTCAT", "Non hai selezionato una categoria valida");
define("_MD_PUB_NAME", "Nome");
define("_MD_PUB_NEXT_ITEM", "Successivo");
define("_MD_PUB_NO", "No");
define("_MD_PUB_NO_CAT_EXISTS", "Spiacente nessuna categoria è stata ancora creata.<br />Contatta l'amministratore del sito e richiedi informazioni.");
define("_MD_PUB_NO_CAT_PERMISSIONS", "Spiacente, non hai i permessi per accedere in questa sezione.");
define("_MD_PUB_NO_TOP_PERMISSIONS", "Spiacente, non ci sono articoli da mostrare.");
define("_MD_PUB_NOCATEGORYSELECTED", "Non hai selezionare una categoria valida!");
define("_MD_PUB_NOITEMS_INFO", "Nessun articolo da mostrare.");
define("_MD_PUB_NOITEMSELECTED", "Non hai selezionato un articolo valido!");
define("_MD_PUB_NONE", "Nessuno");
define("_MD_PUB_NOTIFY", "Vuoi essere avvisato non appena sarà pubblicato?");
define("_MD_PUB_OF", "di");
define("_MD_PUB_ON", "il");
define("_MD_PUB_OPTIONS", "Opzioni");
define("_MD_PUB_OTHER_ITEMS", "Altri articoli in questa categoria");
define("_MD_PUB_PAGE", "Pagina");
define("_MD_PUB_POSTEDBY", "Pubblicato da %s il %s");
define("_MD_PUB_PREVIEW", "Anteprima");
define("_MD_PUB_PREVIOUS_ITEM", "Precedente");
define("_MD_PUB_PRINT", "Versione per la stampa");
define("_MD_PUB_PRINTERFRIENDLY", "Versione per la stampa");
define("_MD_PUB_READMORE", "Leggi tutto...");
define("_MD_PUB_READS", "letture");
define("_MD_PUB_SENDSTORY", "Invia a un amico...");
define("_MD_PUB_SMARTITEMS_INFO", "Qui trovi gli articoli pubblicati in questa categoria.");
define("_MD_PUB_SUB_INTRO", "compila il modulo per inviare il tuo articolo. L'amministratore del sito provvederà a revisionarlo e a disporne la pubblicazione quanto prima. Grazie per il contributo.");
define("_MD_PUB_SUB_SMNAME", "Invia un articolo");
define("_MD_PUB_SUB_SNEWNAME", "Invia un articolo");
define("_MD_PUB_SUBMIT", "Invia un articolo");
define("_MD_PUB_SUBMIT_ERROR", "Si è verificato un errore. L'articolo non è stato inviato.");
define("_MD_PUB_SUBMITITEM", "Invia un articolo");
define("_MD_PUB_SUMMARY", "Introduzione");
define("_MD_PUB_SUMMARY_DSC", "Introduzione - Sommario dell'articolo.");
define("_MD_PUB_THE", "il");
define("_MD_PUB_TIMES", "tempo");
define("_MD_PUB_TITLE", "Titolo");
define("_MD_PUB_TITLE_REQ", "Titolo*");
define("_MD_PUB_TOTAL_SMARTITEMS", "Totale articoli");
define("_MD_PUB_UNKNOWNERROR", "ERRORE. Stiamo riportandoti dove eri!");
define("_MD_PUB_UPLOAD", "Upload");
define("_MD_PUB_UPLOAD_FILE", "Carica un file");
define("_MD_PUB_VIEW_MORE", "Leggi l'articolo completo");
define("_MD_PUB_WEIGHT", "Peso");
define("_MD_PUB_WHO_WHEN", "Pubblicato da %s il %s");
define("_MD_PUB_YES", "Si");

?>