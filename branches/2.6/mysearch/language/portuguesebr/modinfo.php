<?php
//  ------------------------------------------------------------------------ //
//                       mysearch - MODULE FOR XOOPS 2                        //
//                  Copyright (c) 2005-2006 Instant Zero                     //
//                     <http://xoops.instant-zero.com/>                      //
// ------------------------------------------------------------------------- //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

define('_MI_MYSEARCH_NAME',"My search");
define('_MI_MYSEARCH_DESC',"Com este m�dulo voc� poder� saber o que as pessoas est�o procurando em seu site.");

define('_MI_MYSEARCH_ADMMENU1',"Estat�stica");
define('_MI_MYSEARCH_ADMMENU2',"Editar Palavra-chave");
define('_MI_MYSEARCH_ADMMENU3',"Exportar");
define('_MI_MYSEARCH_ADMMENU4',"Lista Negra");
define('_MI_MYSEARCH_ADMMENU5',"Sobre");

define('_MI_MYSEARCH_OPT0',"Contar as Procuras para mostrar na p�gina de �ndice do m�dulo");
define('_MI_MYSEARCH_OPT0_DSC',"Selecione o n�mero de usu�rios que procuram para ver na p�gina de �ndice do m�dulo (0 = exibir nada)");

define('_MI_MYSEARCH_OPT1',"Grupos que voc� n�o quer registrar");
define('_MI_MYSEARCH_OPT1_DSC',"N�o ser�o registradas todas as procuras feitas por pessoas que est�o nesses grupos");

define('_MI_MYSEARCH_OPT2',"Contar as palavras-chaves visiv�is na administra��o");
define('_MI_MYSEARCH_OPT2_DSC',"");

define('_MI_MYSEARCH_BNAME1',"�ltimas procuras");
define('_MI_MYSEARCH_BNAME2',"Usu�rios que fazem mais procuras");
define('_MI_MYSEARCH_BNAME3',"Estat�sticas");
define('_MI_MYSEARCH_BNAME4',"Pesquisa Ajax");

// Added by Lankford on 2007/8/15
define('_MI_MYSEARCH_DO_DEEP_SEARCH', "Ativar Pesquisa <b>'profunda'</b>?");
define('_MI_MYSEARCH_DO_DEEP_SEARCH_DSC', "Deseja que a sua primeira p�gina de resultados de pesquisa possa indicar quantos acessos foram encontrados em cada m�dulo? Nota: Quando voc� modifica para esta modalidade, poder� melhorar o processo pesquisa!");
define('_MI_MYSEARCH_INIT_SRCH_RSLTS', "N�mero de resultados para o in�cio da pesquisa: (para a uma pesquisa <b>superficial</b>)");
define('_MI_MYSEARCH_INIT_SRCH_RSLTS_DSC', "As pesquisas <b>Superficiais</b> s�o feitas para limitar os resultados de forma mais r�pida para devolver o que encontrou em cada m�dulo. Sempre ser� relativo � primeira p�gina de pesquisa.");
define('_MI_MYSEARCH_MDL_SRCH_RESULTS', "N�mero de resultados da pesquisa por p�gina:");
define('_MI_MYSEARCH_MDL_SRCH_RESULTS_DSC', "Isto determina a quantidade de visualiza��o ou (hits) por p�gina que ser�o mostrados ap�s informa��o ser obtida dentro de um m�dulo em particular e seus resultados sobre isto.");

define('_MI_MYSEARCH_MIN_SEARCH', 'Comprimento m�nimo da palavra-chave');
define('_MI_MYSEARCH_MIN_SEARCH_DSC', 'Informe o comprimento m�nimo da palavra-chave que os usu�rios s�o obrigados a digitar para realizar esta pesquisa');

?>