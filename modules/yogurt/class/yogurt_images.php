<?php
// $Id: yogurt_images.php,v 1.13 2008/04/19 16:39:12 marcellobrandao Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
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



/**
* Protection against inclusion outside the site 
*/
if (!defined("XOOPS_ROOT_PATH")) {
die("XOOPS root path not defined");
}

/**
* Includes of form objects and uploader 
*/
include_once XOOPS_ROOT_PATH."/class/uploader.php";
include_once XOOPS_ROOT_PATH."/class/xoopsobject.php";
include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";



/**
* yogurt_images class.  
* $this class is responsible for providing data access mechanisms to the data source 
* of XOOPS user class objects.
*/


class yogurt_images extends XoopsObject
{ 
	var $db;

// constructor
	function yogurt_images ($id=null)
	{
		$this->db =& Database::getInstance();
		$this->initVar("cod_img",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("title",XOBJ_DTYPE_TXTBOX, null, false);
		$this->initVar("data_creation",XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar("data_update",XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar("uid_owner",XOBJ_DTYPE_TXTBOX, null, false);
		$this->initVar("url",XOBJ_DTYPE_TXTBOX, null, false);
		$this->initVar("private",XOBJ_DTYPE_TXTBOX, null, false);
		if ( !empty($id) ) {
			if ( is_array($id) ) {
				$this->assignVars($id);
			} else {
					$this->load(intval($id));
			}
		} else {
			$this->setNew();
		}
		
	}

	function load($id)
	{
		$sql = 'SELECT * FROM '.$this->db->prefix("yogurt_images").' WHERE cod_img='.$id;
		$myrow = $this->db->fetchArray($this->db->query($sql));
		$this->assignVars($myrow);
		if (!$myrow) {
			$this->setNew();
		}
	}

	function getAllyogurt_imagess($criteria=array(), $asobject=false, $sort="cod_img", $order="ASC", $limit=0, $start=0)
	{
		$db =& Database::getInstance();
		$ret = array();
		$where_query = "";
		if ( is_array($criteria) && count($criteria) > 0 ) {
			$where_query = " WHERE";
			foreach ( $criteria as $c ) {
				$where_query .= " $c AND";
			}
			$where_query = substr($where_query, 0, -4);
		} elseif ( !is_array($criteria) && $criteria) {
			$where_query = " WHERE ".$criteria;
		}
		if ( !$asobject ) {
			$sql = "SELECT cod_img FROM ".$db->prefix("yogurt_images")."$where_query ORDER BY $sort $order";
			$result = $db->query($sql,$limit,$start);
			while ( $myrow = $db->fetchArray($result) ) {
				$ret[] = $myrow['yogurt_images_id'];
			}
		} else {
			$sql = "SELECT * FROM ".$db->prefix("yogurt_images")."$where_query ORDER BY $sort $order";
			$result = $db->query($sql,$limit,$start);
			while ( $myrow = $db->fetchArray($result) ) {
				$ret[] = new yogurt_images ($myrow);
			}
		}
		return $ret;
	}
}
// -------------------------------------------------------------------------
// ------------------yogurt_images user handler class -------------------
// -------------------------------------------------------------------------
/**
* yogurt_imageshandler class.  
* This class provides simple mecanisme for yogurt_images object and generate forms for inclusion etc
*/

class Xoopsyogurt_imagesHandler extends XoopsObjectHandler
{

	/**
	* create a new yogurt_images
	* 
	* @param bool $isNew flag the new objects as "new"?
	* @return object yogurt_images
	*/
	function &create($isNew = true)	{
		$yogurt_images = new yogurt_images();
		if ($isNew) {
			$yogurt_images->setNew();
		}
		else{
		$yogurt_images->unsetNew();
		}

		
		return $yogurt_images;
	}

	/**
	* retrieve a yogurt_images
	* 
	* @param int $id of the yogurt_images
	* @return mixed reference to the {@link yogurt_images} object, FALSE if failed
	*/
	function &get($id)	{
			$sql = 'SELECT * FROM '.$this->db->prefix('yogurt_images').' WHERE cod_img='.$id;
			if (!$result = $this->db->query($sql)) {
				return false;
			}
			$numrows = $this->db->getRowsNum($result);
			if ($numrows == 1) {
				$yogurt_images = new yogurt_images();
				$yogurt_images->assignVars($this->db->fetchArray($result));
				return $yogurt_images;
			}
				return false;
	}

/**
* insert a new yogurt_images in the database
* 
* @param object $yogurt_images reference to the {@link yogurt_images} object
* @param bool $force
* @return bool FALSE if failed, TRUE if already present and unchanged or successful
*/
	function insert(&$yogurt_images, $force = false) {
		Global $xoopsConfig;
		if (get_class($yogurt_images) != 'yogurt_images') {
				return false;
		}
		if (!$yogurt_images->isDirty()) {
				return true;
		}
		if (!$yogurt_images->cleanVars()) {
				return false;
		}
		foreach ($yogurt_images->cleanVars as $k => $v) {
				${$k} = $v;
		}
		$now = "date_add(now(), interval ".$xoopsConfig['server_TZ']." hour)";
		if ($yogurt_images->isNew()) {
			// ajout/modification d'un yogurt_images
			$yogurt_images = new yogurt_images();
			$format = "INSERT INTO %s (cod_img, title, data_creation, data_update, uid_owner, url, private)";
			$format .= "VALUES (%u, %s, %s, %s, %s, %s, 0)";
			$sql = sprintf($format , 
			$this->db->prefix('yogurt_images'), 
			$cod_img
			,$this->db->quoteString($title)
			,$now
			,$now
			,$this->db->quoteString($uid_owner)
			,$this->db->quoteString($url)
			
			);
			$force = true;
		} else {
			$format = "UPDATE %s SET ";
			$format .="cod_img=%u, title=%s, data_creation=%s, data_update=%s, uid_owner=%s, url=%s, private=%s";
			$format .=" WHERE cod_img = %u";
			$sql = sprintf($format, $this->db->prefix('yogurt_images'),
			$cod_img
			,$this->db->quoteString($title)
			,$now
			,$now
			,$this->db->quoteString($uid_owner)
			,$this->db->quoteString($url)
			,$this->db->quoteString($private)
			, $cod_img);
		}
		if (false != $force) {
			$result = $this->db->queryF($sql);
		} else {
			$result = $this->db->query($sql);
		}
		if (!$result) {
			return false;
		}
		if (empty($cod_img)) {
			$cod_img = $this->db->getInsertId();
		}
		$yogurt_images->assignVar('cod_img', $cod_img);
		return true;
	}

	/**
	 * delete a yogurt_images from the database
	 * 
	 * @param object $yogurt_images reference to the yogurt_images to delete
	 * @param bool $force
	 * @return bool FALSE if failed.
	 */
	function delete(&$yogurt_images, $force = false)
	{
		if (get_class($yogurt_images) != 'yogurt_images') {
			return false;
		}
		$sql = sprintf("DELETE FROM %s WHERE cod_img = %u", $this->db->prefix("yogurt_images"), $yogurt_images->getVar('cod_img'));
		if (false != $force) {
			$result = $this->db->queryF($sql);
		} else {
			$result = $this->db->query($sql);
		}
		if (!$result) {
			return false;
		}
		return true;
	}

	/**
	* retrieve yogurt_imagess from the database
	* 
	* @param object $criteria {@link CriteriaElement} conditions to be met
	* @param bool $id_as_key use the UID as key for the array?
	* @return array array of {@link yogurt_images} objects
	*/
	function &getObjects($criteria = null, $id_as_key = false)
	{
		$ret = array();
		$limit = $start = 0;
		$sql = 'SELECT * FROM '.$this->db->prefix('yogurt_images');
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere();
		if ($criteria->getSort() != '') {
			$sql .= ' ORDER BY '.$criteria->getSort().' '.$criteria->getOrder();
		}
		$limit = $criteria->getLimit();
		$start = $criteria->getStart();
		}
		$result = $this->db->query($sql, $limit, $start);
		if (!$result) {
			return $ret;
		}
		while ($myrow = $this->db->fetchArray($result)) {
			$yogurt_images = new yogurt_images();
			$yogurt_images->assignVars($myrow);
			if (!$id_as_key) {
				$ret[] =& $yogurt_images;
			} else {
				$ret[$myrow['cod_img']] =& $yogurt_images;
			}
			unset($yogurt_images);
		}
		return $ret;
	}

	/**
	* count yogurt_imagess matching a condition
	* 
	* @param object $criteria {@link CriteriaElement} to match
	* @return int count of yogurt_imagess
	*/
	function getCount($criteria = null)
	{
		$sql = 'SELECT COUNT(*) FROM '.$this->db->prefix('yogurt_images');
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere();
		}
		$result = $this->db->query($sql);
		if (!$result) {
			return 0;
		}
		list($count) = $this->db->fetchRow($result);
		return $count;
	} 

	/**
	* delete yogurt_imagess matching a set of conditions
	* 
	* @param object $criteria {@link CriteriaElement} 
	* @return bool FALSE if deletion failed
	*/
	function deleteAll($criteria = null)
	{
		$sql = 'DELETE FROM '.$this->db->prefix('yogurt_images');
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere();
		}
		if (!$result = $this->db->query($sql)) {
			return false;
		}
		return true;
	}
	
	/**
	* Render a form to send pictures
	* 
	* @param int $maxbytes the maximum size of a picture
	* @param object $xoopsTpl the one in which the form will be rendered
	* @return bool TRUE
	*
	* obs: Some functions wont work on php 4 so edit lines down under acording to your version
	*/
	function renderFormSubmit($maxbytes,$xoopsTpl)
	{
				
		$form 				= new XoopsThemeForm(_MD_YOGURT_SUBMIT_PIC_TITLE, "form_picture", "submit.php", "post", true);
		$field_url 			= new XoopsFormFile(_MD_YOGURT_SELECT_PHOTO, "sel_photo", 2000000);
		$field_desc 			= new XoopsFormText(_MD_YOGURT_CAPTION, "caption", 35, 55);
		$form->setExtra('enctype="multipart/form-data"');
		$button_send 	= new XoopsFormButton("", "submit_button", _MD_YOGURT_UPLOADPICTURE, "submit");
		$field_warning = new XoopsFormLabel(sprintf(_MD_YOGURT_YOUCANUPLOAD,$maxbytes/1024));
		$form->addElement($field_warning);
		$form->addElement($field_url,true);
		$form->addElement($field_desc);
		
		$form->addElement($button_send);
		if ( (str_replace('.', '', PHP_VERSION)) > 499 )

		{
			$form->assign($xoopsTpl);//If your server is php 5 
		} else {
		 
		$form->display(); //If your server is php 4.4 
		}
		
		return true;
	}

	/**
	* Render a form to edit the description of the pictures
	* 
	* @param string $caption The description of the picture
	* @param int $cod_img the id of the image in database
	* @param text $filename the url to the thumb of the image so it can be displayed
	* @return bool TRUE
	*/
	function renderFormEdit($caption,$cod_img,$filename)
	{
				
		$form 		= new XoopsThemeForm(_MD_YOGURT_EDITDESC, "form_picture", "editdesc.php", "post", true);
		$field_desc 	= new XoopsFormText($caption, "caption", 35, 55);
		$form->setExtra('enctype="multipart/form-data"');
		$button_send 	= new XoopsFormButton("", "submit_button", _MD_YOGURT_SUBMIT, "submit");
		$field_warning = new XoopsFormLabel("<img src='".$filename."' alt='sssss'>");
		$field_cod_img = new XoopsFormHidden("cod_img",$cod_img);
		$field_marker = new XoopsFormHidden("marker",1);
		$form->addElement($field_warning);
		$form->addElement($field_desc);
		$form->addElement($field_cod_img);
		$form->addElement($field_marker);
		$form->addElement($button_send);
		$form->display();
		
		
		return true;
	}
	
	
	/**
	* Upload the file and Save into database
	* 
	* @param text $title A litle description of the file
	* @param text $path_upload The path to where the file should be uploaded
	* @param int $thumbwidth the width in pixels that the thumbnail will have
	* @param int $thumbheight the height in pixels that the thumbnail will have
	* @param int $pictwidth the width in pixels that the pic will have
	* @param int $pictheight the height in pixels that the pic will have
	* @param int $maxfilebytes the maximum size a file can have to be uploaded in bytes
	* @param int $maxfilewidth the maximum width in pixels that a pic can have
	* @param int $maxfileheight the maximum height in pixels that a pic can have
	* @return bool FALSE if upload fails or database fails
	*/
	function receivePicture($title,$path_upload, $thumbwidth, $thumbheight, $pictwidth, $pictheight, $maxfilebytes,$maxfilewidth,$maxfileheight)
	{
		
		global $xoopsUser, $xoopsDB, $_POST, $_FILES;
		//busca id do user logado
		$uid = $xoopsUser->getVar('uid');
		//create a hash so it does not erase another file
		//$hash1 = date();
		//$hash = substr($hash1,0,4);
		
		// mimetypes and settings put this in admin part later
		$allowed_mimetypes = array( 'image/jpeg', 'image/pjpeg');
		$maxfilesize = $maxfilebytes;
		
		// create the object to upload
		$uploader = new XoopsMediaUploader($path_upload, $allowed_mimetypes, $maxfilesize, $maxfilewidth, $maxfileheight);
		// fetch the media
		if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
			//lets create a name for it
			$uploader->setPrefix('pic_'.$uid.'_');
			//now let s upload the file
			if (!$uploader->upload()) {
			// if there are errors lets return them
			
			echo "<div style=\"color:#FF0000; background-color:#FFEAF4; border-color:#FF0000; border-width:thick; border-style:solid; text-align:center\"><p>".$uploader->getErrors()."</p></div>";
			return false;
			} else {
			// now let s create a new object picture and set its variables
			$picture = $this->create();
			$url = $uploader->getSavedFileName();
			$picture->setVar("url",$url);
			$picture->setVar("title",$title);
			$picture->setVar("private",0);
			$uid = $xoopsUser->getVar('uid');
			$picture->setVar("uid_owner",$uid);
			$this->insert($picture);
			$saved_destination = $uploader->getSavedDestination();
			//print_r($_FILES);
			//$this->resizeImage($saved_destination,false, $thumbwidth, $thumbheight, $pictwidth, $pictheight,$path_upload);
			//$this->resizeImage($saved_destination,true, $thumbwidth, $thumbheight, $pictwidth, $pictheight,$path_upload);
			$this->resizeImage($saved_destination, $thumbwidth, $thumbheight, $pictwidth, $pictheight,$path_upload);
			
			}
		} else {
		echo "<div style=\"color:#FF0000; background-color:#FFEAF4; border-color:#FF0000; border-width:thick; border-style:solid; text-align:center\"><p>".$uploader->getErrors()."</p></div>";
		return false;
		}
		return true;
		
		
	}
	

	
	/**
	* Resize a picture and save it to $path_upload
	* 
	* @param text $img the path to the file
	* @param text $path_upload The path to where the files should be saved after resizing
	* @param int $thumbwidth the width in pixels that the thumbnail will have
	* @param int $thumbheight the height in pixels that the thumbnail will have
	* @param int $pictwidth the width in pixels that the pic will have
	* @param int $pictheight the height in pixels that the pic will have
	* @return nothing
	*/	
	function resizeImage($img, $thumbwidth, $thumbheight, $pictwidth, $pictheight,$path_upload) {
		
		
		$img2 = $img;
		$path = pathinfo($img);
		$img=imagecreatefromjpeg($img);
		$xratio = $thumbwidth/(imagesx($img));
		$yratio = $thumbheight/(imagesy($img));

		if($xratio < 1 || $yratio < 1) {
			if($xratio < $yratio)
				$resized = imagecreatetruecolor($thumbwidth,floor(imagesy($img)*$xratio));
			else
				$resized = imagecreatetruecolor(floor(imagesx($img)*$yratio), $thumbheight);
				imagecopyresampled($resized, $img, 0, 0, 0, 0, imagesx($resized)+1,imagesy($resized)+1,imagesx($img),imagesy($img));
				imagejpeg($resized,$path_upload."/thumb_".$path["basename"]);
				imagedestroy($resized);
			}               
		else{
			imagejpeg($img,$path_upload."/thumb_".$path["basename"]);
		}
		
		imagedestroy($img);
		$path2 = pathinfo($img2);
		$img2=imagecreatefromjpeg($img2);
		$xratio2 = $pictwidth/(imagesx($img2));
		$yratio2 = $pictheight/(imagesy($img2));
		if($xratio2 < 1 || $yratio2 < 1) {

			if($xratio2 < $yratio2)
				$resized2 = imagecreatetruecolor($pictwidth,floor(imagesy($img2)*$xratio2));
			else
				$resized2 = imagecreatetruecolor(floor(imagesx($img2)*$yratio2), $pictheight);
		
			imagecopyresampled($resized2, $img2, 0, 0, 0, 0, imagesx($resized2)+1,imagesy($resized2)+1,imagesx($img2),imagesy($img2));
			imagejpeg($resized2,$path_upload."/resized_".$path2["basename"]);
			imagedestroy($resized2);
		}              
		else
		{
		imagejpeg($img2,$path_upload."/resized_".$path2["basename"]);
		}
		imagedestroy($img2);/* 	*/	
	}
	
	
	
	function getLastPictures($limit)
	{
		$ret = array();
		
		$sql = 'SELECT uname, t.uid_owner, t.url FROM '.$this->db->prefix('yogurt_images').' AS t, '.$this->db->prefix('users');
		
		$sql .= " WHERE uid_owner = uid AND private=0 ORDER BY cod_img DESC" ;
		$result = $this->db->query($sql, $limit, 0);
		$vetor = array();
		$i=0;
		while ($myrow = $this->db->fetchArray($result)) {
			
			$vetor[$i]['uid_voted']= $myrow['uid_owner'];
			$vetor[$i]['uname']= $myrow['uname'];
			$vetor[$i]['user_avatar']= $myrow['url'];
			$i++;
		}
				
		return $vetor;

	}
	
		function getLastPicturesForBlock($limit)
	{
		$ret = array();
		
		$sql = 'SELECT uname, t.uid_owner, t.url, t.title FROM '.$this->db->prefix('yogurt_images').' AS t, '.$this->db->prefix('users');
		
		$sql .= " WHERE uid_owner = uid AND private=0 ORDER BY cod_img DESC" ;
		$result = $this->db->query($sql, $limit, 0);
		$vetor = array();
		$i=0;
		while ($myrow = $this->db->fetchArray($result)) {
			
			$vetor[$i]['uid_voted']= $myrow['uid_owner'];
			$vetor[$i]['uname']= $myrow['uname'];
			$vetor[$i]['img_filename']= $myrow['url'];
			$vetor[$i]['caption']= $myrow['title'];
			
			$i++;
		}
				
		return $vetor;

	}
	
	
	/**
	* Resize a picture and save it to $path_upload
	* 
	* @param text $img the path to the file
	* @param text $path_upload The path to where the files should be saved after resizing
	* @param int $thumbwidth the width in pixels that the thumbnail will have
	* @param int $thumbheight the height in pixels that the thumbnail will have
	* @param int $pictwidth the width in pixels that the pic will have
	* @param int $pictheight the height in pixels that the pic will have
	* @return nothing
	*/	
	function makeAvatar($img, $width, $height,$path_upload) {
	
		$img2 = $img;
		$path = pathinfo($img);
		$img=imagecreatefromjpeg($img);
		$xratio = $thumbwidth/(imagesx($img));
		$yratio = $thumbheight/(imagesy($img));

		if($xratio < 1 || $yratio < 1) {
			if($xratio < $yratio)
				$resized = imagecreatetruecolor($thumbwidth,floor(imagesy($img)*$xratio));
			else
				$resized = imagecreatetruecolor(floor(imagesx($img)*$yratio), $thumbheight);
				imagecopyresampled($resized, $img, 0, 0, 0, 0, imagesx($resized)+1,imagesy($resized)+1,imagesx($img),imagesy($img));
				imagejpeg($resized,$path_upload."/thumb_".$path["basename"]);
				imagedestroy($resized);
			}               
		else{
			imagejpeg($img,$path_upload."/thumb_".$path["basename"]);
		}
		
		imagedestroy($img);
		$path2 = pathinfo($img2);
		$img2=imagecreatefromjpeg($img2);
		$xratio2 = $pictwidth/(imagesx($img2));
		$yratio2 = $pictheight/(imagesy($img2));
		if($xratio2 < 1 || $yratio2 < 1) {

			if($xratio2 < $yratio2)
				$resized2 = imagecreatetruecolor($pictwidth,floor(imagesy($img2)*$xratio2));
			else
				$resized2 = imagecreatetruecolor(floor(imagesx($img2)*$yratio2), $pictheight);
		
			imagecopyresampled($resized2, $img2, 0, 0, 0, 0, imagesx($resized2)+1,imagesy($resized2)+1,imagesx($img2),imagesy($img2));
			imagejpeg($resized2,$path_upload."/resized_".$path2["basename"]);
			imagedestroy($resized2);
		}              
		else
		{
		imagejpeg($img2,$path_upload."/resized_".$path2["basename"]);
		}
		imagedestroy($img2);/* 	*/	
	}
	
	
}
?>