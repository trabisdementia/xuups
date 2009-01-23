<?php

/**
* $Id: modinfo.php 3211 2008-06-23 21:12:24Z gibaphp $
* Module: Publisher
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

// Module Info
// The name of this module

global $xoopsModule;

define("_MI_PUB_ADMENU1", "Õndice");
define("_MI_PUB_ADMENU2", "Categorias");
define("_MI_PUB_ADMENU3", "Artigos");
define("_MI_PUB_ADMENU4", "Permissıes");
define("_MI_PUB_ADMENU5", "Blocos e Grupos");
define("_MI_PUB_ADMENU6", "Formatos");
define("_MI_PUB_ADMENU7", "Ir para o mÛdulo");

define("_MI_PUB_ADMINHITS", "Contar cliques do admin?");
define("_MI_PUB_ADMINHITSDSC", "Permitir cliques de admin para estatÌsticas?");
define("_MI_PUB_ALLOWSUBMIT", "Submissıes do usu·rio:");
define("_MI_PUB_ALLOWSUBMITDSC", "Permitir a usu·rios submeter artigos em seu site?");
define("_MI_PUB_ANONPOST", "Permitir posts de visitantes");
define("_MI_PUB_ANONPOSTDSC", "Permitir a visitantes a submiss„o de artigos.");
define("_MI_PUB_AUTHOR_INFO", "Desenvolvedores");
define("_MI_PUB_AUTHOR_WORD", "A Palavra do Autor");
define("_MI_PUB_AUTOAPP", "Auto aprovar artigos submetidos?");
define("_MI_PUB_AUTOAPPDSC", "Auto aprovar os artigos submetidos sem intervenÁ„o do admin?");
define("_MI_PUB_BCRUMB","Mostrar o nome do mÛdulo no breadcrumb?");
define("_MI_PUB_BCRUMBDSC","Se vocÍ selecionar sim, o breadcrumb ir· mostrar \"Publisher > nome da categoria > nome do artigo\". <br>Se n„o, somente \"nome da categoria > nome do artigo\" ser· exibido.");
define("_MI_PUB_BOTH_FOOTERS","Ambos os rodapÈs");
define("_MI_PUB_BY", "por");
define("_MI_PUB_CATEGORY_ITEM_NOTIFY", "Itens da Categoria");
define("_MI_PUB_CATEGORY_ITEM_NOTIFY_DSC", "OpÁıes de notificaÁ„o que se aplicam a categoria atual.");
define("_MI_PUB_CATEGORY_ITEM_PUBLISHED_NOTIFY", "Novo artigo publicado");
define("_MI_PUB_CATEGORY_ITEM_PUBLISHED_NOTIFY_CAP", "Avise-me quando um novo artigo for publicado na categoria atual.");   
define("_MI_PUB_CATEGORY_ITEM_PUBLISHED_NOTIFY_DSC", "Receber notificaÁ„o quando um novo artigo for publicado na categoria atual.");      
define("_MI_PUB_CATEGORY_ITEM_PUBLISHED_NOTIFY_SBJ", "[{X_SITENAME}] {X_MODULE} auto-notificaÁ„o : Novo artigo publicado em categoria"); 
define("_MI_PUB_CATEGORY_ITEM_SUBMITTED_NOTIFY", "'Artigo submetido");
define("_MI_PUB_CATEGORY_ITEM_SUBMITTED_NOTIFY_CAP", "Avise-me quando um novo artigo for submetido na categoria atual.");   
define("_MI_PUB_CATEGORY_ITEM_SUBMITTED_NOTIFY_DSC", "Receber notificaÁ„o quando um novo artigo for submetido na categoria atual.");      
define("_MI_PUB_CATEGORY_ITEM_SUBMITTED_NOTIFY_SBJ", "[{X_SITENAME}] {X_MODULE} auto-notificaÁ„o : Novo artigo submetido em categoria"); 
define("_MI_PUB_CATLIST_IMG_W", "Lista de Imagens da Categoria width");
define("_MI_PUB_CATLIST_IMG_WDSC", "Specify the witdh of category images when listing the categories.");
define("_MI_PUB_CATMAINIMG_W", "Category main image width");
define("_MI_PUB_CATMAINIMG_WDSC", "Specify the width of the category main image.");
define("_MI_PUB_CATPERPAGE", "N˙mero m·ximo de categorias por p·gina (Lado de usu·rio):");
define("_MI_PUB_CATPERPAGEDSC", "N˙mero m·ximo de categorias principais a serem exibidas, por p·gina, pelo lado do usu·rio.");
define("_MI_PUB_CLONE", "Permitir duplicaÁ„o de artigo?");
define("_MI_PUB_CLONEDSC", "Selecione 'Sim' para permitir que os usu·rios apropriados dupliquem um artigo.");
define("_MI_PUB_COLLHEAD", "Mostrar a barra colaps·vel?");
define("_MI_PUB_COLLHEADDSC", "Se vocÍ marcar a opÁ„o como 'Sim', os resumos das Categorias v„o ser exibidos na barra colaps·vel, bem como os Artigos. Se vocÍ marcar 'N„o', a barra colaps·vel n„o ser· exibida.");
define("_MI_PUB_COMMENTS", "Controlar coment·rios ‡ nÌvel de artigo?");
define("_MI_PUB_COMMENTSDSC", "Se vocÍ marcar a opÁ„o 'Sim', vocÍ ver· coment·rios apenas nos itens em que seus coment·rios estiverem devidamente marcados.<br><br/> Selecionando 'N„o' vocÍ ter· os coment·rios gerenciados de forma global. Olhe abaixo em 'Regras de Coment·rios'.");
define("_MI_PUB_DATEFORMAT", "Formato de Data:");
define("_MI_PUB_DATEFORMATDSC", "Use a parte final de language/english/global.php para selecionar um estilo de exibiÁ„o. Exemplo: ");
define("_MI_PUB_DEMO_SITE", "Site de demonstraÁ„o da SmartFactory");
define("_MI_PUB_DEVELOPER_CONTRIBUTOR", "Colaborador(es)");
define("_MI_PUB_DEVELOPER_CREDITS", "CrÈditos");
define("_MI_PUB_DEVELOPER_EMAIL", "E-mail");
define("_MI_PUB_DEVELOPER_LEAD", "Desenvolvedor principal(is)");
define("_MI_PUB_DEVELOPER_WEBSITE", "Site da web");
define("_MI_PUB_DISCOM", "Mostrar contador de coment·rios?");
define("_MI_PUB_DISCOMDSC", "Marque 'Sim' para mostrar o contador de coment·rios em cada artigo");
define("_MI_PUB_DISDATECOL", "Mostar a coluna 'Publicado em'?");
define("_MI_PUB_DISDATECOLDSC", "Quando a opÁ„o mostrar 'Resumo' estiver selecionada, selecione 'Sim' para mostrar a data do 'Publicado em' na tabela de itens do Ìndice e na p·gina da categoria.");
define("_MI_PUB_DCS", "Mostrar o resumo da categoria?");
define("_MI_PUB_DCS_DSC", "Escolha 'N„o' para n„o mostrar o sum·rio da Categoria na p·gina de sub-categorias.");
define("_MI_PUB_DISPLAY_CATEGORY", "Mostrar o nome da Categoria?");
define("_MI_PUB_DISPLAY_CATEGORY_DSC", "Escolha para 'Sim' para mostrar dentro da Categoria o Link para um artigo individual");
define("_MI_PUB_DISPLAYTYPE_FULL", "VisualizaÁ„o Completa");
define("_MI_PUB_DISPLAYTYPE_LIST", "Lista de itens");
define("_MI_PUB_DISPLAYTYPE_WFSECTION", "Estilo WFSection");
define("_MI_PUB_DISPLAYTYPE_SUMMARY", "Visualizar Resumo");
define("_MI_PUB_DISSBCATDSC", "Mostar descriÁ„o das sub-categorias?");
define("_MI_PUB_DISSBCATDSCDSC", "Selecionar 'Sim' para mostrar a descriÁ„o das sub-categorias no Ìndice e na p·gina da categoria.");
define("_MI_PUB_DISTYPE", "Forma de exibiÁ„o do artigo:");
define("_MI_PUB_DISTYPEDSC", "Se a opÁ„o 'Resumo' estiver selecionada, apenas o tÌtulo, a data e os cliques de cada item ser„o mostrados na categoria selecionada. Se a opÁ„o 'Vis„o Completa' estiver selecionada, cada artigo ser· mostrado integralmente na categoria selecionada.");
define("_MI_PUB_FILEUPLOADDIR", "Arquivos enviados para a pasta de upload:");
define("_MI_PUB_FILEUPLOADDIRDSC", "Pasta de destino para os arquivos anexados aos artigos. artigos. N„o inclua qualquer tag ou barra.");
define("_MI_PUB_FOOTERPRINT","Imprimir rodapÈ da p·gina");
define("_MI_PUB_FOOTERPRINTDSC","Selecionar o rodapÈ que estar· impresso em cada artigo entre aquelas criadas nas opÁıes de preferÍncia/conte˙do");
define("_MI_PUB_GLOBAL_ITEM_CATEGORY_CREATED_NOTIFY", "Nova categoria");
define("_MI_PUB_GLOBAL_ITEM_CATEGORY_CREATED_NOTIFY_CAP", "Avise-me quando uma nova categoria for criada.");
define("_MI_PUB_GLOBAL_ITEM_CATEGORY_CREATED_NOTIFY_DSC", "Receba notificaÁ„o quando uma nova categoria for criada.");
define("_MI_PUB_GLOBAL_ITEM_CATEGORY_CREATED_NOTIFY_SBJ", "[{X_SITENAME}] {X_MODULE} auto-notificaÁ„o : Nova categoria");
define("_MI_PUB_GLOBAL_ITEM_NOTIFY", "Artigos em Geral");
define("_MI_PUB_GLOBAL_ITEM_NOTIFY_DSC", "OpÁıes de notificaÁ„o que se aplicam a todos os artigos.");
define("_MI_PUB_GLOBAL_ITEM_PUBLISHED_NOTIFY", "Novo artigo publicado");
define("_MI_PUB_GLOBAL_ITEM_PUBLISHED_NOTIFY_CAP", "Avise-me quando qualquer novo artigo for publicado.");
define("_MI_PUB_GLOBAL_ITEM_PUBLISHED_NOTIFY_DSC", "Receber notificaÁ„o quando qualquer novo artigo for publicado.");
define("_MI_PUB_GLOBAL_ITEM_PUBLISHED_NOTIFY_SBJ", "[{X_SITENAME}] {X_MODULE} auto-notificaÁ„o : Novo artigo publicado");
define("_MI_PUB_GLOBAL_ITEM_SUBMITTED_NOTIFY", "Artigo submetido");
define("_MI_PUB_GLOBAL_ITEM_SUBMITTED_NOTIFY_CAP", "Avise-me quando qualquer artigo for submetido e estiver aguardando aprovaÁ„o.");
define("_MI_PUB_GLOBAL_ITEM_SUBMITTED_NOTIFY_DSC", "Receber notificaÁ„o quando qualquer artigo for submetido e estiver esperando aprovaÁ„o.");
define("_MI_PUB_GLOBAL_ITEM_SUBMITTED_NOTIFY_SBJ", "[{X_SITENAME}] {X_MODULE} auto-notificaÁ„o : Novo artigo submetido");
define("_MI_PUB_HEADERPRINT","Imprimir o cabeÁalho da p·gina");
define("_MI_PUB_HEADERPRINTDSC","CabeÁalho que estar· impresso em cada artigo");
define("_MI_PUB_HELP_CUSTOM", "Caminho Personalizado");
define("_MI_PUB_HELP_INSIDE", "Dentro do mÛdulo");
define("_MI_PUB_HELP_PATH_CUSTOM", "Caminho personalizado dos arquivos de ajuda do Publisher");
define("_MI_PUB_HELP_PATH_CUSTOM_DSC", "Se vocÍ selecionar caminho personalizado  na opÁ„o prÈvia de caminho dos arquivos de ajuda do Publisher, por favor especifique a URL dos arquivos de ajuda do Publisher, no formato : http://www.yoursite.com/doc");
define("_MI_PUB_HELP_PATH_SELECT", "Caminho de arquivos de ajuda do Publisher");
define("_MI_PUB_HELP_PATH_SELECT_DSC", "Selecione de onde vocÍ gostaria de acessar arquivos de ajuda do Publisher. Se vocÍ fez o download do'Pacote de Ajuda do Publisher' e fez upload dele em'modules/publisher/doc/', vocÍ pode selecionar'dentro do mÛdulo'. Alternativamente, vocÍ pode acessar a ajuda do mÛdulo diretamente de docs.xoops.org escolhendo esta via no seletor. VocÍ tambÈm pode selecionar'Caminho de Costume' e especificar vocÍ mesmo o caminho dos arquivos de ajuda na prÛxima opÁ„o de configuraÁ„o'Caminho de Costume para opÁ„o de arquivos de ajuda do Publisher'");
define("_MI_PUB_HITSCOL", "Mostrar a coluna de 'Cliques'?");
define("_MI_PUB_HITSCOLDSC", "Quando a opÁ„o 'Resumo' estiver selecionada, selecione 'Sim' para mostrar a coluna de 'Cliques' na tabela de itens do Ìndice e na p·gina da categoria.");
define("_MI_PUB_HLCOLOR", "Cor de destaque para palavras-chave");
define("_MI_PUB_HLCOLORDSC", "Mostrar as palavras-chave com cor de destaque quando pesquisar");
define("_MI_PUB_IMAGENAV", "Usar a imagem NavegaÁ„o na P·gina:");
define("_MI_PUB_IMAGENAVDSC", "Se vocÍ marcou esta opÁ„o como \"Sim\", a NavegaÁ„o na P·gina ser· exibida com imagens, se n„o, a NavegaÁ„o na P·gina original ser· exibida.");
define("_MI_PUB_INDEXFOOTER","Indexar rodapÈ");
define("_MI_PUB_INDEXFOOTER_SEL","Indexar rodapÈ");
define("_MI_PUB_INDEXFOOTERDSC","RodapÈ que ser· exibido na p·gina de Ìndice do mÛdulo");
define("_MI_PUB_INDEXMSG", "Mensagem de boas-vindas do Õndice");
define("_MI_PUB_INDEXMSGDEF", ""); 
define("_MI_PUB_INDEXMSGDSC", "Mensagem de boas-vindas ser· exibida na p·gina-Ìndice do mÛdulo.");
define("_MI_PUB_ITEM_APPROVED_NOTIFY", "Artigo aprovado");
define("_MI_PUB_ITEM_APPROVED_NOTIFY_CAP", "Avise-me quando este artigo for aprovado.");   
define("_MI_PUB_ITEM_APPROVED_NOTIFY_DSC", "Receber notificaÁ„o quando este artigo for aprovado.");      
define("_MI_PUB_ITEM_APPROVED_NOTIFY_SBJ", "[{X_SITENAME}] {X_MODULE} auto-notificaÁ„o : artigo aprovado"); 
define("_MI_PUB_ITEM_NOTIFY", "Artigo");
define("_MI_PUB_ITEM_NOTIFY_DSC", "OpÁıes de notificaÁ„o que se aplicam ao artigo atual.");
define("_MI_PUB_ITEM_REJECTED_NOTIFY", "Artigo rejeitado");
define("_MI_PUB_ITEM_REJECTED_NOTIFY_CAP", "Avise-me se este artigo for rejeitado.");   
define("_MI_PUB_ITEM_REJECTED_NOTIFY_DSC", "Receba notificaÁ„o se este artigo for rejeitado.");      
define("_MI_PUB_ITEM_REJECTED_NOTIFY_SBJ", "[{X_SITENAME}] {X_MODULE} auto-notificaÁ„o : artigo rejeitado"); 
define("_MI_PUB_ITEM_TYPE", "Tipo de artigo:");
define("_MI_PUB_ITEM_TYPEDSC", "Selecione o tipo de artigos este mÛdulo vai administrar.");
define("_MI_PUB_ITEMFOOTER", "RodapÈ de artigo");
define("_MI_PUB_ITEMFOOTER_SEL", "RodapÈ de artigo");
define("_MI_PUB_ITEMFOOTERDSC","RodapÈ que ser· exibido em cada artigo");
define("_MI_PUB_ITEMSMENU", "Menu de navegaÁ„o");
//bd tree block hack
define("_MI_PUB_ITEMSTREE", "Bloco em ¡rvore");
//--/bd
define("_MI_PUB_ITEMSNEW", "Lista de artigos recentes");
define("_MI_PUB_ITEMSPOT", "Em destaque!");
define("_MI_PUB_ITEMSRANDOM_ITEM", "Artigo aleatÛrio !");
define("_MI_PUB_LASTITEM", "Mostrar coluna '˙ltimo item'?");
define("_MI_PUB_LASTITEMDSC", "Marcar 'Sim' para mostrar o ˙ltimo item em cada categoria no Ìndice e na p·gina da categoria.");
define("_MI_PUB_LASTITEMS", "Mostrar a lista dos artigos publicados mais recentes?");
define("_MI_PUB_LASTITEMSDSC", "Marque 'Sim' para ter a lista embaixo, na primeira p·gina do mÛdulo");
define("_MI_PUB_LASTITSIZE", "Tamanho do ˙ltimo item :");
define("_MI_PUB_LASTITSIZEDSC", "Defina o tamanho m·ximo do tÌtulo na coluna ⁄ltimos Itens");
define("_MI_PUB_LINKPATH", "Permitir links no caminho atual:");
define("_MI_PUB_LINKPATHDSC", "Esta opÁ„o permitir· ao usu·rio retornar, com um clique, ao caminho exibido no topo da p·gina");
define("_MI_PUB_MAX_HEIGHT", "Altura m·xima da imagem");
define("_MI_PUB_MAX_HEIGHTDSC", "Altura m·xima do arquivo de imagem que pode ser carregado");
define("_MI_PUB_MAX_SIZE", "Tamanho m·ximo de arquivo");
define("_MI_PUB_MAX_SIZEDSC", "Tamanho m·ximo [em bytes] de um arquivo para ser carregado.");
define("_MI_PUB_MAX_WIDTH", "Largura m·xima da imagem a ser carregada");
define("_MI_PUB_MAX_WIDTHDSC", "Largura m·xima permitida para um arquivo ser carregado.");
define("_MI_PUB_MD_DESC", "Sistema de Gerenciamento de SeÁıes para seu Portal em XOOPS");
define("_MI_PUB_MD_NAME", "Publisher");
define("_MI_PUB_MODULE_BUG", "Reportar um erro neste mÛdulo");
define("_MI_PUB_MODULE_DEMO", "Site de demonstraÁ„o");
define("_MI_PUB_MODULE_DISCLAIMER", "Carta de ren˙ncia");
define("_MI_PUB_MODULE_FEATURE", "Sugerir uma nova caracterÌstica para este mÛdulo");
define("_MI_PUB_MODULE_INFO", "InformaÁıes do desenvolvimento do MÛdulo");
define("_MI_PUB_MODULE_RELEASE_DATE", "Data do release");
define("_MI_PUB_MODULE_STATUS", "Status");
define("_MI_PUB_MODULE_SUBMIT_BUG", "Submeter um erro");
define("_MI_PUB_MODULE_SUBMIT_FEATURE", "Submeter um pedido de alteraÁ„o");
define("_MI_PUB_MODULE_SUPPORT", "Site de suporte oficial");
define("_MI_PUB_NO_FOOTERS","Nenhum");
define("_MI_PUB_ORDERBY", "Ordem de classificaÁ„o");
define("_MI_PUB_ORDERBY_DATE", "Date DESC");
define("_MI_PUB_ORDERBY_TITLE", "TÌtulo ASC");
define("_MI_PUB_ORDERBY_WEIGHT", "Peso ASC");
define("_MI_PUB_ORDERBYDSC", "Selecione a ordem de classificaÁ„o dos itens para todo o mÛdulo.");
define("_MI_PUB_OTHER_ITEMS_TYPE_ALL", "Todos os artigos");
define("_MI_PUB_OTHER_ITEMS_TYPE_NONE", "Nenhum");
define("_MI_PUB_OTHER_ITEMS_TYPE_PREVIOUS_NEXT", "PrÈvio e prÛximo artigo");
define("_MI_PUB_OTHERITEMS", "Tipo de exibiÁ„o de outros artigos");
define("_MI_PUB_OTHERITEMSDSC", "Selecione como vocÍ gostaria de exibir os outros artigos da categoria na p·gina de um artigo.");
define("_MI_PUB_PERPAGE", "M·ximo de artigos por p·gina (Lado do Admin):");
define("_MI_PUB_PERPAGEDSC", "N˙mero de m·ximo de artigos por p·gina a ser exibido de uma vez no lado do admin.");
define("_MI_PUB_PERPAGEINDEX", "Artigos de m·ximo pela p·gina (Lado de usu·rio):");
define("_MI_PUB_PERPAGEINDEXDSC", "N˙mero de m·ximo de artigos por p·gina a ser exibido de uma vez no lado de usu·rio.");
define("_MI_PUB_PRINTLOGOURL","Logotipo imprimir URL");
define("_MI_PUB_PRINTLOGOURLDSC","URL do logotipo que estar· impresso no topo da p·gina");
define("_MI_PUB_RECENTITEMS", "Artigos recentes (Detalhe)");
define("_MI_PUB_SHOW_RSS","Mostrar link para RSS feed");
define("_MI_PUB_SHOW_RSSDSC","");
define("_MI_PUB_SHOW_SUBCATS", "Exibir sub-categorias na p·gina de Ìndice");
define("_MI_PUB_SHOW_SUBCATS_ALL", "Mostrar todas as sub-categorias");
define("_MI_PUB_SHOW_SUBCATS_DSC", "Selecione sim para exibir as sub-categorias na lista de categorias da p·gina de Ìndice do mÛdulo");
define("_MI_PUB_SHOW_SUBCATS_NO", "N„o mostrar sub-categorias");
define("_MI_PUB_SHOW_SUBCATS_NOTEMPTY", "Mostrar sub-categorias que n„o est„o vazias");
define("_MI_PUB_SUB_SMNAME1", "Submeter um artigo");
define("_MI_PUB_SUB_SMNAME2", "Artigos populares");
define("_MI_PUB_SUBMITMSG", "Apresentar p·gina de introduÁ„o:");
define("_MI_PUB_SUBMITMSGDEF", "");
define("_MI_PUB_SUBMITMSGDSC", "Mensagem de introduÁ„o que ser· exibida quando um artigo for submetido ‡ aprovaÁ„o.");
define("_MI_PUB_TITLE_SIZE", "Tamanho de tÌtulo :");
define("_MI_PUB_TITLE_SIZEDSC", "Determinar o tamanho m·ximo do tÌtulo na p·gina de exibiÁ„o de um ˙nico artigo.");
define("_MI_PUB_UPLOAD", "Usu·rio pode fazer upload?");
define("_MI_PUB_UPLOADDSC", "Permitir que usu·rios faÁam uploads de arquivos vinculados a artigos em seu site?");
define("_MI_PUB_USEREALNAME", "Usar o Nome Real dos usu·rios");
define("_MI_PUB_USEREALNAMEDSC", "Quando exibir um nickname, use o nome real do usu·rio se ele tiver escolhido usar seu nome real.");
define("_MI_PUB_VERSION_HISTORY", "HistÛrico da Vers„o");
define("_MI_PUB_WARNING_BETA", "Este mÛdulo est· neste est·gio, sem qualquer garantia.");
define("_MI_PUB_WARNING_FINAL", "Este mÛdulo est· neste est·gio, sem qualquer garantia.");
define("_MI_PUB_WARNING_RC", "Este mÛdulo est· neste est·gio, sem qualquer garantia.");
define("_MI_PUB_WELCOME", "Mostrar o tÌtulo e a mensagem de boas-vindas:");
define("_MI_PUB_WELCOMEDSC", "Se vocÍ marcar 'Sim', a p·gina-Ìndice do mÛdulo ir· mostrar o tÌtulo 'Bem-vindo ao Publisher de...', seguida da mensagem de boas-vindas definida abaixo. Se vocÍ marcar 'N„o', nenhuma dessas linhas ser· exibida.");
define("_MI_PUB_WHOWHEN", "Mostrar o an˙ncio e a data?");
define("_MI_PUB_WHOWHENDSC", "Marque 'Sim' para mostrar o an˙ncio e a informaÁ„o da data de cada artigo, individualmente.");
define("_MI_PUB_WYSIWYG", "Tipo de editor");
define("_MI_PUB_WYSIWYGDSC", "Para escolher que tipo de editor vocÍ quer usar. Note, no entanto, que se vocÍ escolher qualquer editor que n„o o XoopsEditor, ele dever· estar instalado em seu site.");

define("_MI_PUB_PV_TEXT", "VisualizaÁ„o parcial de Mensagem");
define("_MI_PUB_PV_TEXTDSC", "Mensagem para artigos de visualizaÁ„o parcial apenas.");
define("_MI_PUB_PV_TEXT_DEF", "Para ver o artigo completo, vocÍ deve estar registrado no site.");

define("_MI_PUB_SEOMODNAME", "URL - Reescrevendo o nome do mÛdulo");
define("_MI_PUB_SEOMODNAMEDSC", "Se URL para reescrevendo estiver habilitada para este mÛdulo, este È o nome do mÛdulo que ser· usado. Por exemplo : http://yoursite.com/smartection/...");

define("_MI_PUB_ARTCOUNT", "Mostrar quantidade de artigos");
define("_MI_PUB_ARTCOUNTDSC", "Escolher 'Sim' para mostrar a quantidade de artigos na categoria ou dentro do sum·rio. AtenÁ„o, o mÛdulo atualmente conta somente artigos dentro de cada categoria e n„o o conta dentro dos subcategoies.");

define("_MI_PUB_LATESTFILES", "⁄ltimos arquivos enviados");

define("_MI_PUB_PATHSEARCH", "ExposiÁ„o do trajeto da categoria em resultados da busca");
define("_MI_PUB_PATHSEARCHDSC", "");
define("_MI_PUB_SHOW_SUBCATS_NOMAIN", "Mostrar sub-categorias no inÌcio da p·gina somente");
define("_MI_PUB_RATING_ENABLED", "Habilitar sistema de votaÁ„o");
define("_MI_PUB_RATING_ENABLEDDSC", "Isso exige recursos do FrameWork SmartObject");

define("_MI_PUB_DISPBREAD", "Mostrar um breadcrumb");
define("_MI_PUB_DISPBREADDSC", "Breadcrumb navigation displays the current page's context within the site structure");

define('_MI_PUB_DATE_TO_DATE', 'Artigos da data atÈ ‡ data')

?><?php

/**
* $Id: modinfo.php 3211 2008-06-23 21:12:24Z gibaphp $
* Module: Publisher
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

// Module Info
// The name of this module

global $xoopsModule;

define("_MI_PUB_ADMENU1", "√çndice");
define("_MI_PUB_ADMENU2", "Categorias");
define("_MI_PUB_ADMENU3", "Artigos");
define("_MI_PUB_ADMENU4", "Permiss√µes");
define("_MI_PUB_ADMENU5", "Blocos e Grupos");
define("_MI_PUB_ADMENU6", "Formatos");
define("_MI_PUB_ADMENU7", "Ir para o m√≥dulo");

define("_MI_PUB_ADMINHITS", "Contar cliques do admin?");
define("_MI_PUB_ADMINHITSDSC", "Permitir cliques de admin para estat√≠sticas?");
define("_MI_PUB_ALLOWSUBMIT", "Submiss√µes do usu√°rio:");
define("_MI_PUB_ALLOWSUBMITDSC", "Permitir a usu√°rios submeter artigos em seu site?");
define("_MI_PUB_ANONPOST", "Permitir posts de visitantes");
define("_MI_PUB_ANONPOSTDSC", "Permitir a visitantes a submiss√£o de artigos.");
define("_MI_PUB_AUTHOR_INFO", "Desenvolvedores");
define("_MI_PUB_AUTHOR_WORD", "A Palavra do Autor");
define("_MI_PUB_AUTOAPP", "Auto aprovar artigos submetidos?");
define("_MI_PUB_AUTOAPPDSC", "Auto aprovar os artigos submetidos sem interven√ß√£o do admin?");
define("_MI_PUB_BCRUMB","Mostrar o nome do m√≥dulo no breadcrumb?");
define("_MI_PUB_BCRUMBDSC","Se voc√™ selecionar sim, o breadcrumb ir√° mostrar \"Publisher > nome da categoria > nome do artigo\". <br>Se n√£o, somente \"nome da categoria > nome do artigo\" ser√° exibido.");
define("_MI_PUB_BOTH_FOOTERS","Ambos os rodap√©s");
define("_MI_PUB_BY", "por");
define("_MI_PUB_CATEGORY_ITEM_NOTIFY", "Itens da Categoria");
define("_MI_PUB_CATEGORY_ITEM_NOTIFY_DSC", "Op√ß√µes de notifica√ß√£o que se aplicam a categoria atual.");
define("_MI_PUB_CATEGORY_ITEM_PUBLISHED_NOTIFY", "Novo artigo publicado");
define("_MI_PUB_CATEGORY_ITEM_PUBLISHED_NOTIFY_CAP", "Avise-me quando um novo artigo for publicado na categoria atual.");   
define("_MI_PUB_CATEGORY_ITEM_PUBLISHED_NOTIFY_DSC", "Receber notifica√ß√£o quando um novo artigo for publicado na categoria atual.");      
define("_MI_PUB_CATEGORY_ITEM_PUBLISHED_NOTIFY_SBJ", "[{X_SITENAME}] {X_MODULE} auto-notifica√ß√£o : Novo artigo publicado em categoria"); 
define("_MI_PUB_CATEGORY_ITEM_SUBMITTED_NOTIFY", "'Artigo submetido");
define("_MI_PUB_CATEGORY_ITEM_SUBMITTED_NOTIFY_CAP", "Avise-me quando um novo artigo for submetido na categoria atual.");   
define("_MI_PUB_CATEGORY_ITEM_SUBMITTED_NOTIFY_DSC", "Receber notifica√ß√£o quando um novo artigo for submetido na categoria atual.");      
define("_MI_PUB_CATEGORY_ITEM_SUBMITTED_NOTIFY_SBJ", "[{X_SITENAME}] {X_MODULE} auto-notifica√ß√£o : Novo artigo submetido em categoria"); 
define("_MI_PUB_CATLIST_IMG_W", "Lista de Imagens da Categoria width");
define("_MI_PUB_CATLIST_IMG_WDSC", "Specify the witdh of category images when listing the categories.");
define("_MI_PUB_CATMAINIMG_W", "Category main image width");
define("_MI_PUB_CATMAINIMG_WDSC", "Specify the width of the category main image.");
define("_MI_PUB_CATPERPAGE", "N√∫mero m√°ximo de categorias por p√°gina (Lado de usu√°rio):");
define("_MI_PUB_CATPERPAGEDSC", "N√∫mero m√°ximo de categorias principais a serem exibidas, por p√°gina, pelo lado do usu√°rio.");
define("_MI_PUB_CLONE", "Permitir duplica√ß√£o de artigo?");
define("_MI_PUB_CLONEDSC", "Selecione 'Sim' para permitir que os usu√°rios apropriados dupliquem um artigo.");
define("_MI_PUB_COLLHEAD", "Mostrar a barra colaps√°vel?");
define("_MI_PUB_COLLHEADDSC", "Se voc√™ marcar a op√ß√£o como 'Sim', os resumos das Categorias v√£o ser exibidos na barra colaps√°vel, bem como os Artigos. Se voc√™ marcar 'N√£o', a barra colaps√°vel n√£o ser√° exibida.");
define("_MI_PUB_COMMENTS", "Controlar coment√°rios √† n√≠vel de artigo?");
define("_MI_PUB_COMMENTSDSC", "Se voc√™ marcar a op√ß√£o 'Sim', voc√™ ver√° coment√°rios apenas nos itens em que seus coment√°rios estiverem devidamente marcados.<br><br/> Selecionando 'N√£o' voc√™ ter√° os coment√°rios gerenciados de forma global. Olhe abaixo em 'Regras de Coment√°rios'.");
define("_MI_PUB_DATEFORMAT", "Formato de Data:");
define("_MI_PUB_DATEFORMATDSC", "Use a parte final de language/english/global.php para selecionar um estilo de exibi√ß√£o. Exemplo: ");
define("_MI_PUB_DEMO_SITE", "Site de demonstra√ß√£o da SmartFactory");
define("_MI_PUB_DEVELOPER_CONTRIBUTOR", "Colaborador(es)");
define("_MI_PUB_DEVELOPER_CREDITS", "Cr√©ditos");
define("_MI_PUB_DEVELOPER_EMAIL", "E-mail");
define("_MI_PUB_DEVELOPER_LEAD", "Desenvolvedor principal(is)");
define("_MI_PUB_DEVELOPER_WEBSITE", "Site da web");
define("_MI_PUB_DISCOM", "Mostrar contador de coment√°rios?");
define("_MI_PUB_DISCOMDSC", "Marque 'Sim' para mostrar o contador de coment√°rios em cada artigo");
define("_MI_PUB_DISDATECOL", "Mostar a coluna 'Publicado em'?");
define("_MI_PUB_DISDATECOLDSC", "Quando a op√ß√£o mostrar 'Resumo' estiver selecionada, selecione 'Sim' para mostrar a data do 'Publicado em' na tabela de itens do √≠ndice e na p√°gina da categoria.");
define("_MI_PUB_DCS", "Mostrar o resumo da categoria?");
define("_MI_PUB_DCS_DSC", "Escolha 'N√£o' para n√£o mostrar o sum√°rio da Categoria na p√°gina de sub-categorias.");
define("_MI_PUB_DISPLAY_CATEGORY", "Mostrar o nome da Categoria?");
define("_MI_PUB_DISPLAY_CATEGORY_DSC", "Escolha para 'Sim' para mostrar dentro da Categoria o Link para um artigo individual");
define("_MI_PUB_DISPLAYTYPE_FULL", "Visualiza√ß√£o Completa");
define("_MI_PUB_DISPLAYTYPE_LIST", "Lista de itens");
define("_MI_PUB_DISPLAYTYPE_WFSECTION", "Estilo WFSection");
define("_MI_PUB_DISPLAYTYPE_SUMMARY", "Visualizar Resumo");
define("_MI_PUB_DISSBCATDSC", "Mostar descri√ß√£o das sub-categorias?");
define("_MI_PUB_DISSBCATDSCDSC", "Selecionar 'Sim' para mostrar a descri√ß√£o das sub-categorias no √≠ndice e na p√°gina da categoria.");
define("_MI_PUB_DISTYPE", "Forma de exibi√ß√£o do artigo:");
define("_MI_PUB_DISTYPEDSC", "Se a op√ß√£o 'Resumo' estiver selecionada, apenas o t√≠tulo, a data e os cliques de cada item ser√£o mostrados na categoria selecionada. Se a op√ß√£o 'Vis√£o Completa' estiver selecionada, cada artigo ser√° mostrado integralmente na categoria selecionada.");
define("_MI_PUB_FILEUPLOADDIR", "Arquivos enviados para a pasta de upload:");
define("_MI_PUB_FILEUPLOADDIRDSC", "Pasta de destino para os arquivos anexados aos artigos. artigos. N√£o inclua qualquer tag ou barra.");
define("_MI_PUB_FOOTERPRINT","Imprimir rodap√© da p√°gina");
define("_MI_PUB_FOOTERPRINTDSC","Selecionar o rodap√© que estar√° impresso em cada artigo entre aquelas criadas nas op√ß√µes de prefer√™ncia/conte√∫do");
define("_MI_PUB_GLOBAL_ITEM_CATEGORY_CREATED_NOTIFY", "Nova categoria");
define("_MI_PUB_GLOBAL_ITEM_CATEGORY_CREATED_NOTIFY_CAP", "Avise-me quando uma nova categoria for criada.");
define("_MI_PUB_GLOBAL_ITEM_CATEGORY_CREATED_NOTIFY_DSC", "Receba notifica√ß√£o quando uma nova categoria for criada.");
define("_MI_PUB_GLOBAL_ITEM_CATEGORY_CREATED_NOTIFY_SBJ", "[{X_SITENAME}] {X_MODULE} auto-notifica√ß√£o : Nova categoria");
define("_MI_PUB_GLOBAL_ITEM_NOTIFY", "Artigos em Geral");
define("_MI_PUB_GLOBAL_ITEM_NOTIFY_DSC", "Op√ß√µes de notifica√ß√£o que se aplicam a todos os artigos.");
define("_MI_PUB_GLOBAL_ITEM_PUBLISHED_NOTIFY", "Novo artigo publicado");
define("_MI_PUB_GLOBAL_ITEM_PUBLISHED_NOTIFY_CAP", "Avise-me quando qualquer novo artigo for publicado.");
define("_MI_PUB_GLOBAL_ITEM_PUBLISHED_NOTIFY_DSC", "Receber notifica√ß√£o quando qualquer novo artigo for publicado.");
define("_MI_PUB_GLOBAL_ITEM_PUBLISHED_NOTIFY_SBJ", "[{X_SITENAME}] {X_MODULE} auto-notifica√ß√£o : Novo artigo publicado");
define("_MI_PUB_GLOBAL_ITEM_SUBMITTED_NOTIFY", "Artigo submetido");
define("_MI_PUB_GLOBAL_ITEM_SUBMITTED_NOTIFY_CAP", "Avise-me quando qualquer artigo for submetido e estiver aguardando aprova√ß√£o.");
define("_MI_PUB_GLOBAL_ITEM_SUBMITTED_NOTIFY_DSC", "Receber notifica√ß√£o quando qualquer artigo for submetido e estiver esperando aprova√ß√£o.");
define("_MI_PUB_GLOBAL_ITEM_SUBMITTED_NOTIFY_SBJ", "[{X_SITENAME}] {X_MODULE} auto-notifica√ß√£o : Novo artigo submetido");
define("_MI_PUB_HEADERPRINT","Imprimir o cabe√ßalho da p√°gina");
define("_MI_PUB_HEADERPRINTDSC","Cabe√ßalho que estar√° impresso em cada artigo");
define("_MI_PUB_HELP_CUSTOM", "Caminho Personalizado");
define("_MI_PUB_HELP_INSIDE", "Dentro do m√≥dulo");
define("_MI_PUB_HELP_PATH_CUSTOM", "Caminho personalizado dos arquivos de ajuda do Publisher");
define("_MI_PUB_HELP_PATH_CUSTOM_DSC", "Se voc√™ selecionar caminho personalizado  na op√ß√£o pr√©via de caminho dos arquivos de ajuda do Publisher, por favor especifique a URL dos arquivos de ajuda do Publisher, no formato : http://www.yoursite.com/doc");
define("_MI_PUB_HELP_PATH_SELECT", "Caminho de arquivos de ajuda do Publisher");
define("_MI_PUB_HELP_PATH_SELECT_DSC", "Selecione de onde voc√™ gostaria de acessar arquivos de ajuda do Publisher. Se voc√™ fez o download do'Pacote de Ajuda do Publisher' e fez upload dele em'modules/publisher/doc/', voc√™ pode selecionar'dentro do m√≥dulo'. Alternativamente, voc√™ pode acessar a ajuda do m√≥dulo diretamente de docs.xoops.org escolhendo esta via no seletor. Voc√™ tamb√©m pode selecionar'Caminho de Costume' e especificar voc√™ mesmo o caminho dos arquivos de ajuda na pr√≥xima op√ß√£o de configura√ß√£o'Caminho de Costume para op√ß√£o de arquivos de ajuda do Publisher'");
define("_MI_PUB_HITSCOL", "Mostrar a coluna de 'Cliques'?");
define("_MI_PUB_HITSCOLDSC", "Quando a op√ß√£o 'Resumo' estiver selecionada, selecione 'Sim' para mostrar a coluna de 'Cliques' na tabela de itens do √≠ndice e na p√°gina da categoria.");
define("_MI_PUB_HLCOLOR", "Cor de destaque para palavras-chave");
define("_MI_PUB_HLCOLORDSC", "Mostrar as palavras-chave com cor de destaque quando pesquisar");
define("_MI_PUB_IMAGENAV", "Usar a imagem Navega√ß√£o na P√°gina:");
define("_MI_PUB_IMAGENAVDSC", "Se voc√™ marcou esta op√ß√£o como \"Sim\", a Navega√ß√£o na P√°gina ser√° exibida com imagens, se n√£o, a Navega√ß√£o na P√°gina original ser√° exibida.");
define("_MI_PUB_INDEXFOOTER","Indexar rodap√©");
define("_MI_PUB_INDEXFOOTER_SEL","Indexar rodap√©");
define("_MI_PUB_INDEXFOOTERDSC","Rodap√© que ser√° exibido na p√°gina de √≠ndice do m√≥dulo");
define("_MI_PUB_INDEXMSG", "Mensagem de boas-vindas do √çndice");
define("_MI_PUB_INDEXMSGDEF", ""); 
define("_MI_PUB_INDEXMSGDSC", "Mensagem de boas-vindas ser√° exibida na p√°gina-√≠ndice do m√≥dulo.");
define("_MI_PUB_ITEM_APPROVED_NOTIFY", "Artigo aprovado");
define("_MI_PUB_ITEM_APPROVED_NOTIFY_CAP", "Avise-me quando este artigo for aprovado.");   
define("_MI_PUB_ITEM_APPROVED_NOTIFY_DSC", "Receber notifica√ß√£o quando este artigo for aprovado.");      
define("_MI_PUB_ITEM_APPROVED_NOTIFY_SBJ", "[{X_SITENAME}] {X_MODULE} auto-notifica√ß√£o : artigo aprovado"); 
define("_MI_PUB_ITEM_NOTIFY", "Artigo");
define("_MI_PUB_ITEM_NOTIFY_DSC", "Op√ß√µes de notifica√ß√£o que se aplicam ao artigo atual.");
define("_MI_PUB_ITEM_REJECTED_NOTIFY", "Artigo rejeitado");
define("_MI_PUB_ITEM_REJECTED_NOTIFY_CAP", "Avise-me se este artigo for rejeitado.");   
define("_MI_PUB_ITEM_REJECTED_NOTIFY_DSC", "Receba notifica√ß√£o se este artigo for rejeitado.");      
define("_MI_PUB_ITEM_REJECTED_NOTIFY_SBJ", "[{X_SITENAME}] {X_MODULE} auto-notifica√ß√£o : artigo rejeitado"); 
define("_MI_PUB_ITEM_TYPE", "Tipo de artigo:");
define("_MI_PUB_ITEM_TYPEDSC", "Selecione o tipo de artigos este m√≥dulo vai administrar.");
define("_MI_PUB_ITEMFOOTER", "Rodap√© de artigo");
define("_MI_PUB_ITEMFOOTER_SEL", "Rodap√© de artigo");
define("_MI_PUB_ITEMFOOTERDSC","Rodap√© que ser√° exibido em cada artigo");
define("_MI_PUB_ITEMSMENU", "Menu de navega√ß√£o");
//bd tree block hack
define("_MI_PUB_ITEMSTREE", "Bloco em √Årvore");
//--/bd
define("_MI_PUB_ITEMSNEW", "Lista de artigos recentes");
define("_MI_PUB_ITEMSPOT", "Em destaque!");
define("_MI_PUB_ITEMSRANDOM_ITEM", "Artigo aleat√≥rio !");
define("_MI_PUB_LASTITEM", "Mostrar coluna '√∫ltimo item'?");
define("_MI_PUB_LASTITEMDSC", "Marcar 'Sim' para mostrar o √∫ltimo item em cada categoria no √≠ndice e na p√°gina da categoria.");
define("_MI_PUB_LASTITEMS", "Mostrar a lista dos artigos publicados mais recentes?");
define("_MI_PUB_LASTITEMSDSC", "Marque 'Sim' para ter a lista embaixo, na primeira p√°gina do m√≥dulo");
define("_MI_PUB_LASTITSIZE", "Tamanho do √∫ltimo item :");
define("_MI_PUB_LASTITSIZEDSC", "Defina o tamanho m√°ximo do t√≠tulo na coluna √öltimos Itens");
define("_MI_PUB_LINKPATH", "Permitir links no caminho atual:");
define("_MI_PUB_LINKPATHDSC", "Esta op√ß√£o permitir√° ao usu√°rio retornar, com um clique, ao caminho exibido no topo da p√°gina");
define("_MI_PUB_MAX_HEIGHT", "Altura m√°xima da imagem");
define("_MI_PUB_MAX_HEIGHTDSC", "Altura m√°xima do arquivo de imagem que pode ser carregado");
define("_MI_PUB_MAX_SIZE", "Tamanho m√°ximo de arquivo");
define("_MI_PUB_MAX_SIZEDSC", "Tamanho m√°ximo [em bytes] de um arquivo para ser carregado.");
define("_MI_PUB_MAX_WIDTH", "Largura m√°xima da imagem a ser carregada");
define("_MI_PUB_MAX_WIDTHDSC", "Largura m√°xima permitida para um arquivo ser carregado.");
define("_MI_PUB_MD_DESC", "Sistema de Gerenciamento de Se√ß√µes para seu Portal em XOOPS");
define("_MI_PUB_MD_NAME", "Publisher");
define("_MI_PUB_MODULE_BUG", "Reportar um erro neste m√≥dulo");
define("_MI_PUB_MODULE_DEMO", "Site de demonstra√ß√£o");
define("_MI_PUB_MODULE_DISCLAIMER", "Carta de ren√∫ncia");
define("_MI_PUB_MODULE_FEATURE", "Sugerir uma nova caracter√≠stica para este m√≥dulo");
define("_MI_PUB_MODULE_INFO", "Informa√ß√µes do desenvolvimento do M√≥dulo");
define("_MI_PUB_MODULE_RELEASE_DATE", "Data do release");
define("_MI_PUB_MODULE_STATUS", "Status");
define("_MI_PUB_MODULE_SUBMIT_BUG", "Submeter um erro");
define("_MI_PUB_MODULE_SUBMIT_FEATURE", "Submeter um pedido de altera√ß√£o");
define("_MI_PUB_MODULE_SUPPORT", "Site de suporte oficial");
define("_MI_PUB_NO_FOOTERS","Nenhum");
define("_MI_PUB_ORDERBY", "Ordem de classifica√ß√£o");
define("_MI_PUB_ORDERBY_DATE", "Date DESC");
define("_MI_PUB_ORDERBY_TITLE", "T√≠tulo ASC");
define("_MI_PUB_ORDERBY_WEIGHT", "Peso ASC");
define("_MI_PUB_ORDERBYDSC", "Selecione a ordem de classifica√ß√£o dos itens para todo o m√≥dulo.");
define("_MI_PUB_OTHER_ITEMS_TYPE_ALL", "Todos os artigos");
define("_MI_PUB_OTHER_ITEMS_TYPE_NONE", "Nenhum");
define("_MI_PUB_OTHER_ITEMS_TYPE_PREVIOUS_NEXT", "Pr√©vio e pr√≥ximo artigo");
define("_MI_PUB_OTHERITEMS", "Tipo de exibi√ß√£o de outros artigos");
define("_MI_PUB_OTHERITEMSDSC", "Selecione como voc√™ gostaria de exibir os outros artigos da categoria na p√°gina de um artigo.");
define("_MI_PUB_PERPAGE", "M√°ximo de artigos por p√°gina (Lado do Admin):");
define("_MI_PUB_PERPAGEDSC", "N√∫mero de m√°ximo de artigos por p√°gina a ser exibido de uma vez no lado do admin.");
define("_MI_PUB_PERPAGEINDEX", "Artigos de m√°ximo pela p√°gina (Lado de usu√°rio):");
define("_MI_PUB_PERPAGEINDEXDSC", "N√∫mero de m√°ximo de artigos por p√°gina a ser exibido de uma vez no lado de usu√°rio.");
define("_MI_PUB_PRINTLOGOURL","Logotipo imprimir URL");
define("_MI_PUB_PRINTLOGOURLDSC","URL do logotipo que estar√° impresso no topo da p√°gina");
define("_MI_PUB_RECENTITEMS", "Artigos recentes (Detalhe)");
define("_MI_PUB_SHOW_RSS","Mostrar link para RSS feed");
define("_MI_PUB_SHOW_RSSDSC","");
define("_MI_PUB_SHOW_SUBCATS", "Exibir sub-categorias na p√°gina de √≠ndice");
define("_MI_PUB_SHOW_SUBCATS_ALL", "Mostrar todas as sub-categorias");
define("_MI_PUB_SHOW_SUBCATS_DSC", "Selecione sim para exibir as sub-categorias na lista de categorias da p√°gina de √≠ndice do m√≥dulo");
define("_MI_PUB_SHOW_SUBCATS_NO", "N√£o mostrar sub-categorias");
define("_MI_PUB_SHOW_SUBCATS_NOTEMPTY", "Mostrar sub-categorias que n√£o est√£o vazias");
define("_MI_PUB_SUB_SMNAME1", "Submeter um artigo");
define("_MI_PUB_SUB_SMNAME2", "Artigos populares");
define("_MI_PUB_SUBMITMSG", "Apresentar p√°gina de introdu√ß√£o:");
define("_MI_PUB_SUBMITMSGDEF", "");
define("_MI_PUB_SUBMITMSGDSC", "Mensagem de introdu√ß√£o que ser√° exibida quando um artigo for submetido √† aprova√ß√£o.");
define("_MI_PUB_TITLE_SIZE", "Tamanho de t√≠tulo :");
define("_MI_PUB_TITLE_SIZEDSC", "Determinar o tamanho m√°ximo do t√≠tulo na p√°gina de exibi√ß√£o de um √∫nico artigo.");
define("_MI_PUB_UPLOAD", "Usu√°rio pode fazer upload?");
define("_MI_PUB_UPLOADDSC", "Permitir que usu√°rios fa√ßam uploads de arquivos vinculados a artigos em seu site?");
define("_MI_PUB_USEREALNAME", "Usar o Nome Real dos usu√°rios");
define("_MI_PUB_USEREALNAMEDSC", "Quando exibir um nickname, use o nome real do usu√°rio se ele tiver escolhido usar seu nome real.");
define("_MI_PUB_VERSION_HISTORY", "Hist√≥rico da Vers√£o");
define("_MI_PUB_WARNING_BETA", "Este m√≥dulo est√° neste est√°gio, sem qualquer garantia.");
define("_MI_PUB_WARNING_FINAL", "Este m√≥dulo est√° neste est√°gio, sem qualquer garantia.");
define("_MI_PUB_WARNING_RC", "Este m√≥dulo est√° neste est√°gio, sem qualquer garantia.");
define("_MI_PUB_WELCOME", "Mostrar o t√≠tulo e a mensagem de boas-vindas:");
define("_MI_PUB_WELCOMEDSC", "Se voc√™ marcar 'Sim', a p√°gina-√≠ndice do m√≥dulo ir√° mostrar o t√≠tulo 'Bem-vindo ao Publisher de...', seguida da mensagem de boas-vindas definida abaixo. Se voc√™ marcar 'N√£o', nenhuma dessas linhas ser√° exibida.");
define("_MI_PUB_WHOWHEN", "Mostrar o an√∫ncio e a data?");
define("_MI_PUB_WHOWHENDSC", "Marque 'Sim' para mostrar o an√∫ncio e a informa√ß√£o da data de cada artigo, individualmente.");
define("_MI_PUB_WYSIWYG", "Tipo de editor");
define("_MI_PUB_WYSIWYGDSC", "Para escolher que tipo de editor voc√™ quer usar. Note, no entanto, que se voc√™ escolher qualquer editor que n√£o o XoopsEditor, ele dever√° estar instalado em seu site.");

define("_MI_PUB_PV_TEXT", "Visualiza√ß√£o parcial de Mensagem");
define("_MI_PUB_PV_TEXTDSC", "Mensagem para artigos de visualiza√ß√£o parcial apenas.");
define("_MI_PUB_PV_TEXT_DEF", "Para ver o artigo completo, voc√™ deve estar registrado no site.");

define("_MI_PUB_SEOMODNAME", "URL - Reescrevendo o nome do m√≥dulo");
define("_MI_PUB_SEOMODNAMEDSC", "Se URL para reescrevendo estiver habilitada para este m√≥dulo, este √© o nome do m√≥dulo que ser√° usado. Por exemplo : http://yoursite.com/smartection/...");

define("_MI_PUB_ARTCOUNT", "Mostrar quantidade de artigos");
define("_MI_PUB_ARTCOUNTDSC", "Escolher 'Sim' para mostrar a quantidade de artigos na categoria ou dentro do sum√°rio. Aten√ß√£o, o m√≥dulo atualmente conta somente artigos dentro de cada categoria e n√£o o conta dentro dos subcategoies.");

define("_MI_PUB_LATESTFILES", "√öltimos arquivos enviados");

define("_MI_PUB_PATHSEARCH", "Exposi√ß√£o do trajeto da categoria em resultados da busca");
define("_MI_PUB_PATHSEARCHDSC", "");
define("_MI_PUB_SHOW_SUBCATS_NOMAIN", "Mostrar sub-categorias no in√≠cio da p√°gina somente");
define("_MI_PUB_RATING_ENABLED", "Habilitar sistema de vota√ß√£o");
define("_MI_PUB_RATING_ENABLEDDSC", "Isso exige recursos do FrameWork SmartObject");

define("_MI_PUB_DISPBREAD", "Mostrar um breadcrumb");
define("_MI_PUB_DISPBREADDSC", "");

define('_MI_PUB_DATE_TO_DATE', 'Artigos da data at√© √† data')

?>