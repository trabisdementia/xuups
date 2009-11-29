<?php
//  ------------------------------------------------------------------------ //
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
if (!defined('XOOPS_ROOT_PATH')) {
	die('XOOPS root path not defined');
}

class news_registryfile {
	var $filename;	// filename to manage

	function news_registryfile($fichier = null)
	{
		$this->setfile($fichier);
  	}

	function setfile($fichier = null)
	{
		if($fichier) {
	  		$this->filename = XOOPS_UPLOAD_PATH.'/'.$fichier;
	  	}
	}

	function getfile($fichier = null)
  	{
		$fw = '';
		if(!$fichier) {
			$fw = $this->filename;
		} else {
			$fw = XOOPS_UPLOAD_PATH.'/'.$fichier;
		}
		if(file_exists($fw)) {
			return file_get_contents($fw);
		} else {
			return '';
		}
  	}

  	function savefile($content, $fichier = null)
  	{
		$fw = '';
		if(!$fichier) {
			$fw = $this->filename;
		} else {
			$fw = XOOPS_UPLOAD_PATH.'/'.$fichier;
		}
		if(file_exists($fw)) {
			@unlink($fw);
		}
		$fp = fopen($fw, 'w') or die(_ERRORS);
		fwrite($fp, $content);
		fclose($fp);
		return true;
  	}
}
?>
