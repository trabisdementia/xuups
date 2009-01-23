<?php

/**
* $Id: modinfo.php 331 2007-12-23 16:01:11Z malanciault $
* Module: Publisher
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

// Module Info
// The name of this module

global $xoopsModule;

define("_MI_PUB_MD_NAME", "Publisher");

// A brief description of this module
define("_MI_PUB_MD_DESC", "Section Management System for your XOOPS Site");

// Sub menus in main menu block
define("_MI_PUB_SUB_SMNAME1", "Invia un articolo");
define("_MI_PUB_SUB_SMNAME2", "Articoli più visti");

// Config options
define('_MI_PUB_ALLOWADMINHITS', 'Contatore delle letture per Admin:');
define('_MI_PUB_ALLOWADMINHITSDSC', 'Consenti di contare le letture effettuate come admin?');
define('_MI_PUB_ALLOWCOMMENTS', "Controlla i commenti a livello di articolo:");
define('_MI_PUB_ALLOWCOMMENTSDSC', "Se scegli 'Si', vedrai i commenti solo sugli elementi che hanno la casella di selezione dei commenti. <br /><br />Seleziona 'No' per gestire i commenti a livello globale (guarda nella sezione 'Preferenze modulo').");
define("_MI_PUB_ALLOWSUBMIT", "Invio da parte di utenti registrati:");
define("_MI_PUB_ALLOWSUBMITDSC", "Consenti agli utenti registrati di inviare articoli?");
define("_MI_PUB_ALLOWUPLOAD", "Upload di file da parte degli Utenti");
define("_MI_PUB_ALLOWUPLOADDSC", "Consenti agli utenti registrati di allegare files agli articoli?");
define("_MI_PUB_ANONPOST", "Invio da parte di utenti anonimi:");
define("_MI_PUB_ANONPOSTDSC", "Consenti agli utenti anonimi di inviare articoli?");
define('_MI_PUB_AUTOAP_SUBITEM', "Gli articoli sono automaticamente approvati:");
define('_MI_PUB_AUTOAP_SUBITEMDSC', "Gli articoli sono automaticamente approvati senza l'intervento dell'amministratore.");
define('_MI_PUB_BOTH_FOOTERS','Entrambi');
define('_MI_PUB_CAT_CON_OPT', 'Impostazione Generali');
define('_MI_PUB_CAT_CON_OPT_DSC', '');
define('_MI_PUB_CAT_PRI_OPT', 'Impostazione di Stampa');
define('_MI_PUB_CAT_PRI_OPT_DSC', '');
define('_MI_PUB_CAT_FOR_OPT', 'Impostazioni di Impaginazione');
define('_MI_PUB_CAT_FOR_OPT_DSC', '');
define('_MI_PUB_CAT_PERM', 'Permessi opzionali');
define('_MI_PUB_CAT_PERM_DSC', '');
define('_MI_PUB_CATPERPAGE', 'Numero di Categorie per pagina (Lato utente):');
define('_MI_PUB_CATPERPAGEDSC', 'Numero massimo di categorie principali da mostrare dal lato utente in una pagina alla volta.');
define('_MI_PUB_COLLAP_HEADING', "Mostra barra a scomparsa");
define('_MI_PUB_COLLAP_HEADING_DSC', "Se scegli 'Si', La 'Vista Sommario' delle Categorie sarà mostrata in una barra a scomparsa, così come gli articoli. Se scegli 'No', la barra a scomparsa non sarà mostrata.");
define('_MI_PUB_DATEFORMAT', 'Formato data:');
define('_MI_PUB_DATEFORMATDSC', 'Usa le impostazioni riportate alla fine di language/.../global.php per selezionare una modalità di visualizzazione. Esempio: "d-M-Y H:i" verrà tradotto in "30-Mar-2004 22:35"');
define('_MI_PUB_DISPLAY_CAT_SUMMARY', "Mostra il sommario della categoria?");
define('_MI_PUB_DISPLAY_CAT_SUMMARY_DSC', "Selezionando 'Si' il sommario della categoria sarà mostrato nel modulo.");
define("_MI_PUB_DISPLAY_CATEGORY", "Mostra il nome della categoria?");
define("_MI_PUB_DISPLAY_CATEGORY_DSC", "Selezionando 'Si' sarà mostrato il link della categoria in ogni articolo");
define("_MI_PUB_DISPLAY_COMMENT", "Mostra il contatore dei commenti?");
define("_MI_PUB_DISPLAY_COMMENT_DSC", "Selezionando 'Si' sarà mostrato il contatore dei commenti in ogni articolo.");
define('_MI_PUB_DISPLAY_DATE_COL', "Mostra la colonna 'Data'?");
define('_MI_PUB_DISPLAY_DATE_COLDSC', "Quando la modalità 'Vista Sommario' è selezionata, selezionando 'Si' sarà mostrata la data nella tabella dell'elemento nella pagina della categoria e nella pagina principale.");
define('_MI_PUB_DISPLAY_HITS_COL', "Mostra la colonna 'Letture'?");
define('_MI_PUB_DISPLAY_HITS_COLDSC', "Quando la modalità 'Vista Sommario' è selezionata, selezionando 'Si' sarà mostrata la colonna 'Letture' nella tabella degli elementi nella pagina principale e in quella delle categorie.");
define('_MI_PUB_DISPLAY_LAST_ITEM', 'Mostra la colonna Ultimo elemento?');
define('_MI_PUB_DISPLAY_LAST_ITEMDSC', "Seleziona 'Si' per mostrare l'ultimo elemento di ciacuna categoria nella pagina principale e in quella delle categorie.");
define('_MI_PUB_DISPLAY_LAST_ITEMS', 'Mostra la lista degli articoli recentemente pubblicati:');
define('_MI_PUB_DISPLAY_LAST_ITEMS_DSC', "Seleziona 'Si' per avere la lista in fondo alla pagina principale del modulo");
define('_MI_PUB_DISPLAY_SBCAT_DSC', 'Mostra la descrizione delle sub categorie ?');
define('_MI_PUB_DISPLAY_SBCAT_DSCDSC', "Seleziona 'Si' per mostrare la descrizione delle sub categorie nella nella pagina principale e nella pagina delle categorie.");
define("_MI_PUB_DISPLAY_WHOWHEN", "Mostra l'autore e la data?");
define("_MI_PUB_DISPLAY_WHOWHEN_DSC", "Seleziona 'Si' per mostrare l'autore e la data in ogni articolo.");
define('_MI_PUB_DISPLAYTYPE', "Modalità di visualizzazione degli articoli:");
define('_MI_PUB_DISPLAYTYPE_FULL', "Vista Completa");
define('_MI_PUB_DISPLAYTYPE_LIST', "Elenco Puntato");
define('_MI_PUB_DISPLAYTYPE_SUMMARY', "Vista Sommario");
define('_MI_PUB_DISPLAYTYPEDSC', "Se è selezionata la modalità 'Vista Sommario', sarà mostrato solo il Titolo, Data e le Letture di ciascun articolo della categoria selezionata. Se è selezionata 'Vista Completa', sarà mostrato il testo completo degli articoli della categoria selezionata.");
define('_MI_PUB_FILEUPLOADDIR', "Directory per l'upload dei file allegati:");
define('_MI_PUB_FILEUPLOADDIRDSC', "Directory dove saranno importati i files allegati agli articoli. Non includere alcun leading e nemmeno trailing slashes.");
define('_MI_PUB_FOOTERPRINT',"Stampa piè di pagina");
define('_MI_PUB_FOOTERPRINTDSC',"Seleziona il piè di pagina che vuoi stampare insieme ad ogni articolo scegliendo tra quelli impostati in Preferenze - Impostazioni Generali.");
define('_MI_PUB_HEADERPRINT',"Intestazione della pagina di stampa");
define('_MI_PUB_HEADERPRINTDSC',"Intestazione che vuoi stampare insieme ad ogni articolo");
define('_MI_PUB_HELP_CUSTOM', "Percorso personale");
define('_MI_PUB_HELP_INSIDE', "Nel modulo");
define('_MI_PUB_HELP_PATH_CUSTOM', "Percorso personale dei files di help di Publisher");
define('_MI_PUB_HELP_PATH_CUSTOM_DSC', "Se hai selezionato 'Percorso personale' nella precedente opzione 'Percorso dei files di help di Publisher', devi specificare il percorso nel formato: http://www.yoursite.com/doc");
define('_MI_PUB_HELP_PATH_SELECT', "Percorso dei files di help di Publisher");
define('_MI_PUB_HELP_PATH_SELECT_DSC', "Scegliere dove sono i files di Help di Publisher. Se hai scaricato lo 'Publisher's Help Package' ed è stato caricato in' modules/publisher/doc/', potete scegliere 'Nel modulo'. In alternativa, potete accedere ai files di Help del modulo direttamente da docs.xoops.org mediante il selettore. Puoi anche scegliere 'Percorso personale' e indicare il percorso dei files di Help nel successivo 'Percorso personale dei files di help di Publisher'");
define('_MI_PUB_HIGHLIGHT_COLOR', "Colore per evidenziare le parole chiave");
define('_MI_PUB_HIGHLIGHT_COLORDSC', "Colore da usare per evidenziare le parole chiave usate nella funzione di ricerca");
define('_MI_PUB_INDEXFOOTER',"Piè di pagina della pagina principale");
define('_MI_PUB_INDEXFOOTER_SEL',"Piè di pagina della pagina principale");
define('_MI_PUB_INDEXFOOTERDSC',"Piè di pagina da mostrare nella pagina principale del modulo");
define('_MI_PUB_INDEXWELCOMEMSG', "Messaggio di benvenuto della pagina principale:");
define('_MI_PUB_INDEXWELCOMEMSGDEF', ""); 
define('_MI_PUB_INDEXWELCOMEMSGDSC', "Messaggio iniziale da mostrare nella pagina principale del modulo.");
define('_MI_PUB_ITEMFOOTER', "Piè di pagina elemento");
define('_MI_PUB_ITEMFOOTER_SEL', "Piè di pagina elemento");
define('_MI_PUB_ITEMFOOTERDSC',"Piè di pagina da mostrare in ogni articolo");
define("_MI_PUB_ITEM_TYPE", "Tipologia di elementi:");
define("_MI_PUB_ITEM_TYPEDSC", "Seleziona il tipo di elementi che il modulo gestisce.");
define('_MI_PUB_LAST_ITEM_SIZE', 'Lunghezza titolo Ultimo elemento:');
define('_MI_PUB_LAST_ITEM_SIZEDSC', "Imposta la lunghezza massima del titolo nella colonna Ultimo elemento.");
define('_MI_PUB_LINKED_PATH', 'Abilita links ipertestuali sul percorso:');
define('_MI_PUB_LINKED_PATHDSC', "Questa opzione consente agli utenti di navigare cliccando su una parte del percorso corrente mostrato in cima alla pagina");
define('_MI_PUB_ORDERBYDATE', 'Ordina in base a:');
define('_MI_PUB_ORDERBYDATEDSC', 'Seleziona la modalità di ordinamento degli elementi. La modalità influisce sulla presentazione dal lato utente');
define('_MI_PUB_ORDERBY_DATE', 'Data DECR');
define('_MI_PUB_ORDERBY_TITLE', 'Titolo A-Z');
define('_MI_PUB_ORDERBY_WEIGHT', 'Peso 0-1');
define('_MI_PUB_OTHER_ITEMS_TYPE', 'Modalità di visualizzazione per gli altri articoli');
define('_MI_PUB_OTHER_ITEMS_TYPE_ALL', "Tutti gli articoli");
define('_MI_PUB_OTHER_ITEMS_TYPE_DSC', 'Seleziona come mostrare gli altri articoli della categoria nella pagina dell\'articolo');
define('_MI_PUB_OTHER_ITEMS_TYPE_NONE', "Nessuno");
define('_MI_PUB_OTHER_ITEMS_TYPE_PREVIOUS_NEXT', "Precedente e successivo");
define('_MI_PUB_NO_FOOTERS','Nessuno');
define('_MI_PUB_PAGE_CATEGORY','Pagine Categoria');
define('_MI_PUB_PAGE_ITEM','Pagine Articolo');
define('_MI_PUB_PERPAGE', "Numero di articoli per pagina (Lato Amministratore):");
define('_MI_PUB_PERPAGEDSC', "Numero massimo di articoli per pagina da mostrare dal lato Amministratore.");
define('_MI_PUB_PERPAGEINDEX', "Numero di articoli per pagina (Lato utente):");
define('_MI_PUB_PERPAGEINDEXDSC', "Numero massimo di articoli per pagina da mostrare dal lato utente.");
define('_MI_PUB_PRINTLOGOURL', 'Url del Logo per la stampa');
define('_MI_PUB_PRINTLOGOURLDSC', 'Indica il percorso del logo da stampare in cima alla pagina insieme ad ogni articolo');
define('_MI_PUB_SHOW_MOD_BCRUMB', 'Mostra il nome del modulo nella riga di orientamento');
define('_MI_PUB_SHOW_MOD_BCRUMBDSC', 'Se selezioni "Si", la riga di orientamento sarà "Publisher > nome della categoria > titolo Articolo". <br>Altrimenti, sarà mostrato solo "nome della categoria > titolo Articolo"');
define('_MI_PUB_SHOW_SUBCATS', "Mostra le sub categorie nella pagina principale");
define('_MI_PUB_SHOW_SUBCATS_DSC', "Seleziona 'Si' per mostrare le sub categorie nella pagina principale del modulo");
define('_MI_PUB_SUBMITINTROMSG', "Messaggio per la pagina di invio:");
define('_MI_PUB_SUBMITINTROMSGDEF', "");
define('_MI_PUB_SUBMITINTROMSGDSC', "Messaggio introduttivo da mostrare nella pagina principale del modulo quando un utente vuole inviare un articolo");
define('_MI_PUB_TITLE_AND_WELCOME', "Mostra il titolo di benvenuto e il messaggio:");
define('_MI_PUB_TITLE_AND_WELCOME_DSC', "Scegliendo 'Si', nella pagina principale del modulo sarà mostrata la frase 'Welcome in the Publisher of...', seguita dal messaggio di benvenuto definito sopra. Se scegli 'No', non sarà mostrato nessun messaggio.");
define('_MI_PUB_TITLE_SIZE', "Lunghezza del titolo:");
define('_MI_PUB_TITLE_SIZEDSC', "Imposta la massima lunghezza del titolo da mostrare per ogni singolo elemento.");
define('_MI_PUB_USE_WYSIWYG', "Text editor");
define('_MI_PUB_USE_WYSIWYG_DSC', "Seleziona il tipo di editor da usare in questo modulo.");
define('_MI_PUB_USEIMAGENAVPAGE', 'Usa le immagini per navigare tra le pagine:');
define('_MI_PUB_USEIMAGENAVPAGEDSC', 'Se scegli "Si", la Pagina di navigazione sarà mostrata con le icone, altrimenti sarà usata la Pagina di navigazione originale.');
define('_MI_PUB_USEREALNAME', 'Usa il Nome Utente Reale degli utenti');
define('_MI_PUB_USEREALNAMEDSC', 'Se si deve mostrare il nome utente, usa il Nome Utente Reale, se questo è stato inserito dall\'utente.');

// Names of admin menu items
define("_MI_PUB_ADMENU1", "Indice");
define("_MI_PUB_ADMENU2", "Categorie");
define("_MI_PUB_ADMENU3", "Articoli");
define("_MI_PUB_ADMENU4", "Permessi");
define("_MI_PUB_ADMENU5", "Blocchi e Gruppi");
define("_MI_PUB_ADMENU6", "Vai al modulo");

//Names of Blocks and Block information
define("_MI_PUB_ITEMSNEW", "Elementi recenti - Elenco");
define("_MI_PUB_ITEMSPOT", "Nello Spotlight!");
define("_MI_PUB_ITEMSRANDOM_ITEM", "Un elemento a caso!");
define("_MI_PUB_RECENTITEMS", "Elementi recenti - Dettagli");
define("_MI_PUB_ITEMSMENU", "Menu");

// Text for notifications
define('_MI_PUB_CATEGORY_ITEM_NOTIFY', 'Categoria');
define('_MI_PUB_CATEGORY_ITEM_NOTIFY_DSC', 'Opzioni di notifica per la categoria corrente.');
define('_MI_PUB_CATEGORY_ITEM_PUBLISHED_NOTIFY', 'Nuovo articolo pubblicato');
define('_MI_PUB_CATEGORY_ITEM_PUBLISHED_NOTIFY_CAP', "Desidero ricevere un messaggio di notifica quando un nuovo articolo è pubblicato in questa categoria.");   
define('_MI_PUB_CATEGORY_ITEM_PUBLISHED_NOTIFY_DSC', "Ricevi un messaggio di notifica quando un nuovo articolo è pubblicato in questa categoria.");      
define('_MI_PUB_CATEGORY_ITEM_PUBLISHED_NOTIFY_SBJ', "[{X_SITENAME}] {X_MODULE} notifica automatica : Nuovo articolo pubblicato nella categoria"); 
define('_MI_PUB_CATEGORY_ITEM_SUBMITTED_NOTIFY', "Articolo inviato");
define('_MI_PUB_CATEGORY_ITEM_SUBMITTED_NOTIFY_CAP', "Desidero ricevere un messaggio di notifica quando un nuovo articolo è inviato in questa categoria.");   
define('_MI_PUB_CATEGORY_ITEM_SUBMITTED_NOTIFY_DSC', "Ricevi un messaggio di notifica quando un nuovo articolo è inviato in questa categoria.");      
define('_MI_PUB_CATEGORY_ITEM_SUBMITTED_NOTIFY_SBJ', "[{X_SITENAME}] {X_MODULE} notifica automatica : Nuovo articolo inviato nella categoria"); 
define('_MI_PUB_GLOBAL_ITEM_CATEGORY_CREATED_NOTIFY', 'Nuova categoria');
define('_MI_PUB_GLOBAL_ITEM_CATEGORY_CREATED_NOTIFY_CAP', 'Desidero ricevere un messaggio di notifica, per ogni nuova categoria creata.');
define('_MI_PUB_GLOBAL_ITEM_CATEGORY_CREATED_NOTIFY_DSC', 'Ricevi un messaggio di notifica quando è creata una nuova categoria.');
define('_MI_PUB_GLOBAL_ITEM_CATEGORY_CREATED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} notifica automatica : Creata una nuova categoria');
define('_MI_PUB_GLOBAL_ITEM_NOTIFY', "Globale");
define('_MI_PUB_GLOBAL_ITEM_NOTIFY_DSC', "Opzioni di notifica da applicare a tutti gli articoli.");
define('_MI_PUB_GLOBAL_ITEM_PUBLISHED_NOTIFY', "Articolo pubblicato");
define('_MI_PUB_GLOBAL_ITEM_PUBLISHED_NOTIFY_CAP', "Desidero ricevere un messaggio di notifica, per ogni nuovo articolo pubblicato.");
define('_MI_PUB_GLOBAL_ITEM_PUBLISHED_NOTIFY_DSC', "Ricevi un messaggio di notifica, per ogni nuovo articolo inviato.");
define('_MI_PUB_GLOBAL_ITEM_PUBLISHED_NOTIFY_SBJ', "[{X_SITENAME}] {X_MODULE} notifica automatica : Pubblicato un nuovo articolo");
define('_MI_PUB_GLOBAL_ITEM_SUBMITTED_NOTIFY', "Articolo inviato");
define('_MI_PUB_GLOBAL_ITEM_SUBMITTED_NOTIFY_CAP', "Desidero ricevere un messaggio di notifica, per ogni nuovo articolo inviato (in attesa di approvazione).");
define('_MI_PUB_GLOBAL_ITEM_SUBMITTED_NOTIFY_DSC', "Ricevi un messaggio di notifica quando un qualsiasi articolo è inviato ed è in attesa di approvazione.");
define('_MI_PUB_GLOBAL_ITEM_SUBMITTED_NOTIFY_SBJ', "[{X_SITENAME}] {X_MODULE} notifica automatica : Inviato un nuovo articolo");
define('_MI_PUB_ITEM_APPROVED_NOTIFY', "Articolo approvato");
define('_MI_PUB_ITEM_APPROVED_NOTIFY_CAP', "Desidero ricevere un messaggio di notifica, quando l'articolo è approvato.");   
define('_MI_PUB_ITEM_APPROVED_NOTIFY_DSC', "Ricevi un messaggio di notifica quando questo articolo è approvato.");      
define('_MI_PUB_ITEM_APPROVED_NOTIFY_SBJ', "[{X_SITENAME}] {X_MODULE} notifica automatica : L'articolo è stato approvato"); 
define('_MI_PUB_ITEM_NOTIFY', "Articolo");
define('_MI_PUB_ITEM_NOTIFY_DSC', "Opzioni di notifica da applicare all'articolo corrente.");
define('_MI_PUB_ITEM_REJECTED_NOTIFY', "Articolo rifiutato");
define('_MI_PUB_ITEM_REJECTED_NOTIFY_CAP', "Desidero ricevere un messaggio di notifica, se l'articolo è rifiutato.");   
define('_MI_PUB_ITEM_REJECTED_NOTIFY_DSC', "Ricevi un messaggio di notifica quando se questo articolo è rifiutato.");      
define('_MI_PUB_ITEM_REJECTED_NOTIFY_SBJ', "[{X_SITENAME}] {X_MODULE} notifica automatica : L'articolo è stato rifiutato"); 

// About.php constants
define('_MI_PUB_AUTHOR_INFO', "Sviluppatori");
define('_MI_PUB_AUTHOR_WORD', "Parole d'Autore");
define('_MI_PUB_BY', "by");
define('_MI_PUB_DEMO_SITE', "Sito demo di SmartFactory");
define('_MI_PUB_DEVELOPER_CONTRIBUTOR', "Collaboratore(i)");
define('_MI_PUB_DEVELOPER_CREDITS', "Crediti");
define('_MI_PUB_DEVELOPER_EMAIL', "Email");
define('_MI_PUB_DEVELOPER_LEAD', "Ultimo(i) sviluppatore(i)");
define('_MI_PUB_DEVELOPER_WEBSITE', "Website");
define('_MI_PUB_MODULE_BUG', "Segnala un bug per questo modulo");
define('_MI_PUB_MODULE_DEMO', "Sito dimostrativo");
define('_MI_PUB_MODULE_DISCLAIMER', "Disclaimer");
define('_MI_PUB_MODULE_FEATURE', "Suggerisci una nuova caratteristica da implementare a questo modulo");
define('_MI_PUB_VERSION_HISTORY', "Storia delle versioni");
define('_MI_PUB_MODULE_INFO', "Informazioni sullo sviluppo del modulo");
define('_MI_PUB_MODULE_RELEASE_DATE', "Data di rilascio");
define('_MI_PUB_MODULE_STATUS', "Status");
define('_MI_PUB_MODULE_SUBMIT_BUG', "Segnala un bug");
define('_MI_PUB_MODULE_SUBMIT_FEATURE', "Segnala una caratteristica che desideri");
define('_MI_PUB_MODULE_SUPPORT', "Sito ufficiale di supporto");

// Beta
define('_MI_PUB_WARNING_BETA', "This module comes as is, without any guarantees whatsoever. 
This module is BETA, meaning it is still under active development. This release is meant for
<b>testing purposes only</b> and we <b>strongly</b> recommend that you do not use it on a live 
website or in a production environment.");

// RC
define('_MI_PUB_WARNING_RC', "This module comes as is, without any guarantees whatsoever. This module 
is a Release Candidate and should not be used on a production web site. The module is still under 
active development and its use is under your own responsibility, which means the author is not responsible.");

// Final
define('_MI_PUB_WARNING_FINAL', "This module comes as is, without any guarantees whatsoever. Although this 
module is not beta, it is still under active development. This release can be used in a live website 
or a production environment, but its use is under your own responsibility, which means the author 
is not responsible.");




?>