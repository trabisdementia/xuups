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
define('_MI_MYSEARCH_DESC',"With this module you can know what people are searching on your website.");

define('_MI_MYSEARCH_ADMMENU1',"Statistics");
define('_MI_MYSEARCH_ADMMENU2',"Prune");
define('_MI_MYSEARCH_ADMMENU3',"Export");
define('_MI_MYSEARCH_ADMMENU4',"Blacklist");
define('_MI_MYSEARCH_ADMMENU5',"About");

define('_MI_MYSEARCH_OPT0',"Count of searches to show on the module's index page");
define('_MI_MYSEARCH_OPT0_DSC',"Select the number of searches users can see on the module's index page (0=show nothing)");

define('_MI_MYSEARCH_OPT1',"Groups you don't want to record");
define('_MI_MYSEARCH_OPT1_DSC',"All the searches made by people who are in those groups will not be recorded");

define('_MI_MYSEARCH_OPT2',"Count of keywords visible in the administration");
define('_MI_MYSEARCH_OPT2_DSC',"");

define('_MI_MYSEARCH_BNAME1',"Last searchs");
define('_MI_MYSEARCH_BNAME2',"Biggest users of the search");
define('_MI_MYSEARCH_BNAME3',"Statistics");
define('_MI_MYSEARCH_BNAME4',"Ajax Search");

// Added by Lankford on 2007/8/15
define('_MI_MYSEARCH_DO_DEEP_SEARCH', "Enable 'deep' searching?");
define('_MI_MYSEARCH_DO_DEEP_SEARCH_DSC', "Would you like your initial search results page to indicate how many hits were found in each module?  Note: turning this on can slow down the search process!");
define('_MI_MYSEARCH_INIT_SRCH_RSLTS', "Number of initial search results: (for 'shallow' searching)");
define('_MI_MYSEARCH_INIT_SRCH_RSLTS_DSC', "'Shallow' searches are made quicker by limiting the results that are returned for each module on the initial search page.");
define('_MI_MYSEARCH_MDL_SRCH_RESULTS', "Number of search results per page:");
define('_MI_MYSEARCH_MDL_SRCH_RESULTS_DSC', "This determines how many hits per page are shown after drilling down into a particular module's search results.");

define('_MI_MYSEARCH_MIN_SEARCH', 'Minimum keyword length');
define('_MI_MYSEARCH_MIN_SEARCH_DSC', 'Enter the minimum keyword length that users are required to enter to perform search');

?>
