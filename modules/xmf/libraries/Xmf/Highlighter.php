<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright       The XUUPS Project http://sourceforge.net/projects/xuups/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Xmf
 * @since           0.1
 * @author          trabis <lusopoemas@gmail.com>
 * @author          The SmartFactory <www.smartfactory.ca>
 * @version         $Id: somefile.php 0 2010-05-03 18:47:04Z trabis $
 */

defined('XMF_EXEC') or die('Xmf was not detected');

class Xmf_Highlighter
{
    /**
     * @access private
     */
    var $preg_keywords = '';
    /**
     * @access private
     */
    var $keywords = '';
    /**
     * @access private
     */
    var $singlewords = false;
    /**
     * @access private
     */
    var $replace_callback = null;

    var $content;

    /**
     * Main constructor
     *
     * This is the main constructor of keyhighlighter class. <br />
     * It's the only public method of the class.
     * @param string $keywords the keywords you want to highlight
     * @param boolean $singlewords specify if it has to highlight also the single words.
     * @param callback $replace_callback a custom callback for keyword highlight.
     */
    function __construct($keywords, $singlewords = false, $replace_callback = null )
    {
        $this->keywords = $keywords;
        $this->singlewords = $singlewords;
        $this->replace_callback = $replace_callback;
    }

    /**
     * @access private
     */
    function replace ($replace_matches)
    {
        $patterns = array ();
        if ($this->singlewords) {
            $keywords = explode (' ', $this->preg_keywords);
            foreach ($keywords as $keyword) {
                $patterns[] = '/(?' . '>' . $keyword . '+)/si';
            }
        } else {
            $patterns[] = '/(?' . '>' . $this->preg_keywords . '+)/si';
        }

        $result = $replace_matches[0];

        foreach ($patterns as $pattern) {
            if (!is_null ($this->replace_callback)) {
                $result = preg_replace_callback ($pattern, $this->replace_callback, $result);
            } else {
                $result = preg_replace ($pattern, '<span class="highlightedkey">\\0</span>', $result);
            }
        }

        return $result;
    }

    /**
     * @access private
     */
    function highlight($buffer)
    {
        $buffer = '>' . $buffer . '<';
        $this->preg_keywords = preg_replace ('/[^\w ]/si', '', $this->keywords);
        $buffer = preg_replace_callback ("/(\>(((?" . ">[^><]+)|(?R))*)\<)/is", array (&$this, 'replace'), $buffer);
        $buffer = substr ($buffer, 1, -1);
        return $buffer;
    }
}