<?php
/**
 * CBB 4.0, or newbb, the forum module for XOOPS project
 *
 * @copyright	The XOOPS Project http://xoops.sf.net
 * @license		http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author		Taiwen Jiang (phppp or D.J.) <phppp@users.sourceforge.net>
 * @since		4.00
 * @version		$Id $
 * @package		module::newbb
 */
 
if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}


/**
 * Set forum image
 *
 * Priority for path per types:
 * 	NEWBB_ROOT 	-	IF EXISTS XOOPS_THEME/modules/newbb/images/, TAKE IT; 
 *					ELSEIF EXISTS  XOOPS_THEME_DEFAULT/modules/newbb/images/, TAKE IT; 
 *					ELSE TAKE  XOOPS_ROOT/modules/newbb/templates/images/. 
 * 	types:
 *		button/misc	- 	language specified; 
 *		//indicator	-	language specified; 
 *		icon		-	universal; 
 *		mime		-	universal; 
 */
 
/**
 * Icon Renderer
 * 
 * @author D.J. (phppp)
 * @copyright copyright &copy; Xoops Project
 * @package module::newbb
 *
 */

class NewbbIconHandler
{
	/**
	 * reference to XOOPS template
	 */
	var $template;
	
	/**
	 * image set
	 */
	var $forumImage = array();
	
	/**
	 * prefix
	 */
	var $prefix = "";
	
	/**
	 * postfix, including extension
	 */
	//var $postfix = ".gif";
    var $postfix = ".png";
	
	/**
	 * images to be assigned to template
	 */
	var $images = array();
	
    /**
     * Constructor
     */
    function NewbbIconHandler()
    {
    }
    

	/**
	 * Access the only instance of this class
	 * 
	 * @return 
	 **/
	function &instance()
	{
		static $instance;
		if (!isset($instance)) {
			$instance = new NewbbIconHandler();
		}
		return $instance;
	}
	
	/**
	 * TODO: get compatible with new theme engine
	 */ 
	 
// SIMPLE-XOOPS edited
	function getPath(/*$set, */$type, $dirname = "newbb", $default = "")
	{
	    global $xoopsConfig;
    	static $paths;
    	if (isset($paths[$type])) {
        	return $paths[$type];
    	}
    	
		//$theme_path = $this->template->currentTheme->path;
		$theme_path = XOOPS_THEME_PATH.'/'.$xoopsConfig['theme_set'];
		$rel_images = "modules/{$dirname}/images";
		
		$path = is_dir($theme_path."/{$rel_images}/{$type}/")
					? $theme_path."/{$rel_images}/{$type}" 
					: ( is_dir(XOOPS_THEME_PATH."/default/{$rel_images}/{$type}/")
						? XOOPS_THEME_PATH."/default/{$rel_images}/{$type}" 
						: ( empty($default) || is_dir(XOOPS_ROOT_PATH."/modules/{$dirname}/templates/images/{$type}/")
							? XOOPS_ROOT_PATH."/modules/{$dirname}/templates/images/{$type}"
							: XOOPS_ROOT_PATH."/modules/{$dirname}/templates/images/{$default}"
						) 
					);
		$paths[$type] = str_replace(XOOPS_ROOT_PATH, "", $path);
		
		return $paths[$type];
	}
	
	function init(/*$set = "default", */$language = "english", $dirname = "newbb")
	{
		$this->forumImage = include XOOPS_ROOT_PATH."/modules/{$dirname}/include/images.php";
		
		$this->forumImage['icon'] = XOOPS_URL.$this->getPath(/*$set, */"icon", $dirname) . "/";
		$this->forumImage['language'] = XOOPS_URL.$this->getPath(/*$set, */"language/{$language}", $dirname, "language/english") . "/";
	}
	
	function setImage($image, $alt = "", $extra = "")
	{
		if (!isset($this->images[$image])) {
			$image_src = $this->getImageSource($image);
		    $this->images[$image] = "<img src=\"{$image_src}\" alt=\"{$alt}\" title=\"{$alt}\" align=\"middle\" {$extra} />";
		}
	}
	
	/**
	 * TODO: How about image not exist?
	 */
	function getImageSource($image)
	{
		return $this->forumImage[$this->forumImage[$image]].$this->prefix.$image.$this->postfix;
	}
	
	function getImage($image, $alt = "", $extra = "")
	{
		$this->setImage($image, $alt, $extra);
		return $this->images[$image];
	}
	
	function assignImage($image, $alt = "", $extra = "")
	{
		$this->setImage($image, $alt, $extra);
		return true;
	}

	function assignImages($images)
	{
		foreach ($images as $_image) {
			list($image, $alt, $extra) = $_image;
			$this->assignImage($image, $alt, $extra);
		}
	}
	
	function render()
	{
		//$this->template->assign_by_ref("image", $this->images);
		$this->template->assign($this->images);
		
		return count($this->images);
	}
	
}

?>