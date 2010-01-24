<?php
// $Id: mypics_image.php,v 1.3 2007/08/26 15:53:07 marcellobrandao Exp $
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
defined("XOOPS_ROOT_PATH") or die("XOOPS root path not defined");

/**
 * Includes of form objects and uploader
 */
xoops_load('XoopsMediaUploader');
xoops_load('XoopsFormLoader');


/**
 * MypicsImage class.
 * $this class is responsible for providing data access mechanisms to the data source
 * of XOOPS user class objects.
 */


class MypicsImage extends XoopsObject
{

    function __construct()
    {
        parent::__construct();
        $this->initVar("id",XOBJ_DTYPE_INT,null,false);
        $this->initVar("title",XOBJ_DTYPE_TXTBOX, '');
        $this->initVar("created",XOBJ_DTYPE_INT,time());
        $this->initVar("updated",XOBJ_DTYPE_INT,time());
        $this->initVar("uid",XOBJ_DTYPE_INT, 0);
        $this->initVar("url",XOBJ_DTYPE_TXTBOX, '');
    }
}

/**
 * MypicsImageHandler class.
 * This class provides simple mecanisme for mypics_image object and generate forms for inclusion etc
 */
class MypicsImageHandler extends XoopsPersistableObjectHandler
{
    function __construct(&$db)
    {
        parent::__construct($db, 'mypics_image', 'MypicsImage', 'id', 'title');
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
    function renderFormSubmit($maxbytes, $xoopsTpl)
    {
        $form = new XoopsThemeForm(_MD_MYPICS_SUBMIT_PIC_TITLE, "form_picture", "submit.php", "post", true);
        $field_url = new XoopsFormFile(_MD_MYPICS_SELECT_PHOTO, "sel_photo", 2000000);
        $field_desc = new XoopsFormText(_MD_MYPICS_CAPTION, "caption", 35, 55);
        $form->setExtra('enctype="multipart/form-data"');
        $button_send = new XoopsFormButton("", "submit_button", _MD_MYPICS_UPLOADPICTURE, "submit");
        $field_warning = new XoopsFormLabel(sprintf(_MD_MYPICS_YOUCANUPLOAD,$maxbytes/1024));
        $form->addElement($field_warning);
        $form->addElement($field_url,true);
        $form->addElement($field_desc,true);
        $form->addElement($button_send);
        $form->assign($xoopsTpl);//If your server is php 5 uncomment this line
        //$form->display(); //If your server is php 4.4 uncomment this line
        return true;
    }

    /**
     * Render a form to edit the description of the pictures
     *
     * @param string $caption The description of the picture
     * @param int $id the id of the image in database
     * @param text $filename the url to the thumb of the image so it can be displayed
     * @return bool TRUE
     */
    function renderFormEdit($caption,$id,$filename)
    {
        $form = new XoopsThemeForm("Edit your description", "form_picture", "editdesc2.php", "post", true);
        $field_desc = new XoopsFormText($caption, "caption", 35, 55);
        $form->setExtra('enctype="multipart/form-data"');
        $button_send = new XoopsFormButton("Edit", "submit_button", "Submit", "submit");
        $field_warning = new XoopsFormLabel("<img src='".$filename."' alt='sssss'>");
        $field_id = new XoopsFormHidden("id",$id);
        $form->addElement($field_warning);
        $form->addElement($field_desc);
        $form->addElement($field_id);
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
    function receivePicture($title, $path_upload, $thumbwidth, $thumbheight, $pictwidth, $pictheight, $maxfilebytes, $maxfilewidth, $maxfileheight)
    {
        global $xoopsUser, $xoopsDB;
        //busca id do user logado
        $uid = $xoopsUser->getVar('uid');
        //create a hash so it does not erase another file
        $hash1 = date();
        $hash = substr($hash1,0,4);

        // mimetypes and settings put this in admin part later
        $allowed_mimetypes = array('image/jpeg', 'image/pjpeg');
        $maxfilesize = $maxfilebytes;

        // create the object to upload
        $uploader = new XoopsMediaUploader($path_upload, $allowed_mimetypes, $maxfilesize, $maxfilewidth, $maxfileheight);
        // fetch the media
        if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
            //lets create a name for it
            $uploader->setPrefix('pic_' . $uid .'_');
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
                $uid = $xoopsUser->getVar('uid');
                $picture->setVar("uid",$uid);
                $picture->setVar("created",time());
                $picture->setVar("updated",time());
                if (!$this->insert($picture)) {
                    return false;
                }
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
    function resizeImage($img, $thumbwidth, $thumbheight, $pictwidth, $pictheight,$path_upload)
    {
        $img2 = $img;
        $path = pathinfo($img);
        $img = imagecreatefromjpeg($img);
        $xratio = $thumbwidth / (imagesx($img));
        $yratio = $thumbheight / (imagesy($img));
        if ($xratio < 1 || $yratio < 1) {
            if ($xratio < $yratio) {
                $resized = imagecreatetruecolor($thumbwidth,floor(imagesy($img) * $xratio));
            } else {
                $resized = imagecreatetruecolor(floor(imagesx($img) * $yratio), $thumbheight);
            }
            imagecopyresampled($resized, $img, 0, 0, 0, 0, imagesx($resized) + 1,imagesy($resized) + 1, imagesx($img), imagesy($img));
            imagejpeg($resized,$path_upload . "/thumb_" . $path["basename"]);
            imagedestroy($resized);
        } else {
            imagejpeg($img,$path_upload . "/thumb_" . $path["basename"]);
        }
        imagedestroy($img);
        $path2 = pathinfo($img2);
        $img2 = imagecreatefromjpeg($img2);
        $xratio2 = $pictwidth / (imagesx($img2));
        $yratio2 = $pictheight / (imagesy($img2));
        if ($xratio2 < 1 || $yratio2 < 1) {
            if ($xratio2 < $yratio2) {
                $resized2 = imagecreatetruecolor($pictwidth, floor(imagesy($img2) * $xratio2));
            } else {
                $resized2 = imagecreatetruecolor(floor(imagesx($img2) * $yratio2), $pictheight);
            }
            imagecopyresampled($resized2, $img2, 0, 0, 0, 0, imagesx($resized2) + 1, imagesy($resized2) + 1, imagesx($img2), imagesy($img2));
            imagejpeg($resized2, $path_upload . "/resized_" . $path2["basename"]);
            imagedestroy($resized2);
        } else {
            imagejpeg($img2, $path_upload . "/resized_" . $path2["basename"]);
        }
        imagedestroy($img2);
    }

    function getLastPicturesForBlock($limit)
    {
        $ret = array();

        $sql = 'SELECT uname, t.uid, t.url, t.title FROM '.$this->db->prefix('yogurt_images').' AS t, '.$this->db->prefix('users');
        $sql .= " WHERE t.uid = uid ORDER BY id DESC" ;
        $result = $this->db->query($sql, $limit, 0);
        $i = 0;
        while ($myrow = $this->db->fetchArray($result)) {
            $ret[$i]['uid']= $myrow['uid'];
            $ret[$i]['uname']= $myrow['uname'];
            $ret[$i]['url']= $myrow['url'];
            $ret[$i]['caption']= $myrow['title'];
            $i++;
        }
        return $ret;
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
    function makeAvatar($img, $width, $height,$path_upload)
    {
        $img2 = $img;
        $path = pathinfo($img);
        $img=imagecreatefromjpeg($img);
        $xratio = $thumbwidth / (imagesx($img));
        $yratio = $thumbheight / (imagesy($img));

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
        imagedestroy($img2);/*  */
    }
}
?>