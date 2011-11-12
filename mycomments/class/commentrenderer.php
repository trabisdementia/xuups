<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

class MycommentsCommentRenderer {

    /**#@+
     * @access	private
     */
    var $_tpl;
    var $_comments = null;
    var $_useIcons = true;
    var $_doIconCheck = false;
    var $_memberHandler;
    var $_statusText;
    /**#@-*/

    /**
     * Constructor
     *
     * @param   object  &$tpl
     * @param   boolean $use_icons
     * @param   boolean $do_iconcheck
     **/
    function MycommentsCommentRenderer(&$tpl, $use_icons = true, $do_iconcheck = false)
    {
        $this->_tpl =& $tpl;
        $this->_useIcons = $use_icons;
        $this->_doIconCheck = $do_iconcheck;
        $this->_memberHandler =& xoops_gethandler('member');
        $this->_statusText = array(MYCOM_PENDING => '<span style="text-decoration: none; font-weight: bold; color: #00ff00;">'._MA_MYCOM_PENDING.'</span>', MYCOM_ACTIVE => '<span style="text-decoration: none; font-weight: bold; color: #ff0000;">'._MA_MYCOM_ACTIVE.'</span>', MYCOM_HIDDEN => '<span style="text-decoration: none; font-weight: bold; color: #0000ff;">'._MA_MYCOM_HIDDEN.'</span>');
    }

    /**
     * Access the only instance of this class
     *
     * @param   object  $tpl        reference to a {@link Smarty} object
     * @param   boolean $use_icons
     * @param   boolean $do_iconcheck
     * @return
     **/
    function &instance(&$tpl, $use_icons = true, $do_iconcheck = false)
    {
        static $instance;
        if (!isset($instance)) {
            $instance = new MycommentsCommentRenderer($tpl, $use_icons, $do_iconcheck);
        }
        return $instance;
    }

    /**
     * Accessor
     *
     * @param   object  &$comments_arr  array of {@link XoopsComment} objects
     **/
    function setComments(&$comments_arr)
    {
        if (isset($this->_comments)) {
            unset($this->_comments);
        }
        $this->_comments =& $comments_arr;
    }

    /**
     * Render the comments in flat view
     *
     * @param boolean $admin_view
     **/
    function renderFlatView($admin_view = false, $modlink = '', $itemlink = '')
    {
        $count = count($this->_comments);
        for ($i = 0; $i < $count; $i++) {
            if (false != $this->_useIcons) {
                $title = $this->_getTitleIcon($this->_comments[$i]->getVar('com_icon')).'&nbsp;'.$this->_comments[$i]->getVar('com_title');
            } else {
                $title = $this->_comments[$i]->getVar('com_title');
            }
            $poster = $this->_getPosterArray($this->_comments[$i]->getVar('com_uid'));
            if (false != $admin_view) {
                $text = $this->_getText($this->_comments[$i]->getVar('com_text'),$this->_comments[$i]->getVar('com_pid')).'<div style="text-align:right; margin-top: 2px; margin-bottom: 0px; margin-right: 2px;">'._MA_MYCOM_STATUS.': '.$this->_statusText[$this->_comments[$i]->getVar('com_status')].'<br />IP: <span style="font-weight: bold;">'.$this->_comments[$i]->getVar('com_ip').'</span></div>';
            } else {
                // hide comments that are not active
                if (MYCOM_ACTIVE != $this->_comments[$i]->getVar('com_status')) {
                    continue;
                } else {
                    $text = $this->_getText($this->_comments[$i]->getVar('com_text'),$this->_comments[$i]->getVar('com_pid'));
                }
            }
            $array[0] = $this->_comments[$i]->getVar('com_itemid');
            $item = mycomments_plugin_execute( $this->_comments[$i]->getVar('dirname') , $array/*$this->_comments[$i]->getVar('com_itemid')*/, 'iteminfo');
            $this->_tpl->append('comments', array(
            'id' => $this->_comments[$i]->getVar('com_id'),
            'title' => $title,
            'text' => $text,
            'date_posted' => formatTimestamp($this->_comments[$i]->getVar('com_created'), 'm'),
            'date_modified' => formatTimestamp($this->_comments[$i]->getVar('com_modified'), 'm'),
            'item_link' => $item[0]['link'],
            'item_title' => $item[0]['title'],
            'module_link' => XOOPS_URL.'/modules/'.$this->_comments[$i]->getVar('dirname'),
            'module_name' => $this->_comments[$i]->getVar('name'),
            'editcomment_link' => XOOPS_URL.'/modules/'.$this->_comments[$i]->getVar('dirname').'/comment_edit.php?com_itemid='.$this->_comments[$i]->getVar('com_itemid'),
            'deletecomment_link' => XOOPS_URL.'/modules/'.$this->_comments[$i]->getVar('dirname').'/comment_delete.php?com_itemid='.$this->_comments[$i]->getVar('com_itemid'),
            'replycomment_link' => XOOPS_URL.'/modules/'.$this->_comments[$i]->getVar('dirname').'/comment_reply.php?com_itemid='.$this->_comments[$i]->getVar('com_itemid'),
            'poster' => $poster));
        }
    }

    /**
     * Get the name of the poster
     *
     * @param   int $poster_id
     * @return  string
     *
     * @access	private
     **/
    function _getPosterName($poster_id)
    {
        $poster['id'] = intval($poster_id);
        if ($poster['id'] > 0) {
            $com_poster =& $this->_memberHandler->getUser($poster_id);
            if (is_object($com_poster)) {
                $poster['uname'] = '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$poster['id'].'">'.$com_poster->getVar('uname').'</a>';
                return $poster;
            }
        }
        $poster['id'] = 0; // to cope with deleted user accounts
        $poster['uname'] = $GLOBALS['xoopsConfig']['anonymous'];
        return $poster;
    }

    /**
     * Get an array with info about the poster
     *
     * @param   int $poster_id
     * @return  array
     *
     * @access	private
     **/
    function _getPosterArray($poster_id)
    {
        $poster['id'] = intval($poster_id);
        if ($poster['id'] > 0) {
            $com_poster =& $this->_memberHandler->getUser($poster['id']);
            if (is_object($com_poster)) {
                $poster['uname'] = '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$poster['id'].'">'.$com_poster->getVar('uname').'</a>';
                $poster_rank = $com_poster->rank();
                $poster['rank_image'] = ($poster_rank['image'] != '') ? $poster_rank['image'] : 'blank.gif';
                $poster['rank_title'] = $poster_rank['title'];
                $poster['avatar'] = $com_poster->getVar('user_avatar');
                $poster['regdate'] = formatTimestamp($com_poster->getVar('user_regdate'), 's');
                $poster['from'] = $com_poster->getVar('user_from');
                $poster['postnum'] = $com_poster->getVar('posts');
                $poster['status'] = $com_poster->isOnline() ? _MA_MYCOM_ONLINE : '';
                return $poster;
            }
        }
        $poster['id'] = 0; // to cope with deleted user accounts
        $poster['uname'] = $GLOBALS['xoopsConfig']['anonymous'];
        $poster['rank_title'] = '';
        $poster['avatar'] = 'blank.gif';
        $poster['regdate'] = '';
        $poster['from'] = '';
        $poster['postnum'] = 0;
        $poster['status'] = '';
        return $poster;
    }

    /**
     * Get the IMG tag for the title icon
     *
     * @param   string  $icon_image
     * @return  string  HTML IMG tag
     *
     * @access	private
     **/
    function _getTitleIcon($icon_image)
    {
        $icon_image = htmlspecialchars( trim( $icon_image ) );
        if ($icon_image != '') {
            if (false != $this->_doIconCheck) {
                if (!file_exists(XOOPS_URL.'/images/subject/'.$icon_image)) {
                    return '<img src="'.XOOPS_URL.'/images/icons/no_posticon.gif" alt="" />';
                } else {
                    return '<img src="'.XOOPS_URL.'/images/subject/'.$icon_image.'" alt="" />';
                }
            } else {
                return '<img src="'.XOOPS_URL.'/images/subject/'.$icon_image.'" alt="" />';
            }
        }
        return '<img src="'.XOOPS_URL.'/images/icons/no_posticon.gif" alt="" />';
    }

    /**
     * Get Text with Signature
     *
     * @param   string  $text
     * @param   int  $uid
     * @return  string
     *
     * @access	private
     **/
    function _getText($text='', $uid=0)
    {
        global $xoopsConfig, $xoopsUser;
        if ( $uid != 0 ) {
            $poster = new XoopsUser($uid);
            if ( !$poster->isActive() ) {
                $poster = 0;
            }
        } else {
            $poster = 0;
        }

        if ( $poster ) {
            if ( $poster->getVar("attachsig") ) {
                $text .= "<p><br />_________________<br />". $poster->user_sig()."</p>";
            }
        }
        return $text;
    }

}
?>
