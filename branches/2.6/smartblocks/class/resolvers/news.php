<?php
if (!defined("XOOPS_ROOT_PATH")) {
    die("Cannot access file directly");
}
require_once(XOOPS_ROOT_PATH."/modules/smartblocks/class/resolver.php");
class NewsResolver extends SmartblocksResolver {
    var	$locations;
    var	$pages;

    function __construct() {
        $this->pages=array();
    }

    /**
     * Return location ID (category ID)
     *
     * @return int
     */
    function resolveLocation() {
        if(strstr($_SERVER['SCRIPT_NAME'],"article.php") || strstr($_SERVER['SCRIPT_NAME'],"ratenews.php")) {
            include_once(XOOPS_ROOT_PATH."/modules/news/class/class.newsstory.php");
            $story = NewsStory::getStory($_REQUEST['storyid']);
            return $story->topicid();
        }
        elseif(strstr($_SERVER['SCRIPT_NAME'],"index.php") && isset($_REQUEST['storytopic'])) {
            return intval($_REQUEST['storytopic']);
        }
        return 0;
    }

    /**
     * Get all locations in the module
     *
     * @return array
     */
    function getLocations() {
        if(sizeof($this->pages)==0) {
            $this->getPageHelper(0,0);
        }
        return($this->pages);
    }


    /**
     * Return the name of a location
     *
     * @param int $location
     * @return string
     */
    function getLocationName($location) {
        include_once(XOOPS_ROOT_PATH."/modules/news/class/class.newsstory.php");
        $story = NewsStory::getStory($location);
        return $story->topic->topic_title();
    }

    /**
     * Returns a list of all parent elements of the current location
     * (including the location itself)
     *
     * @param int $location
     * @return array
     */
    function getLocationPath($location) {
        $this->locations = array();
        $this->getLocationHelper($location);
        return $this->locations;
    }

    /**
     * Private helper functions for traversing the category tree
     *
     * @param int $parentid ID to start from
     * @param int $level used in recursions
     * @param int $offset integer added to location
     *
     * @return void
     */
    function getPageHelper($parentid=0,$level=0) {
        include_once XOOPS_ROOT_PATH."/class/xoopstopic.php";

        $topic = new XoopsTopic($GLOBALS['xoopsDB']->prefix("topics"), $parentid);
        $this->traverseTopic($topic, $parentid, $level);
    }

    /**
     * Add pages to $this->pages from a topic tree
     *
     * @param XoopsTopic $topic
     * @param int $parentid key to start from
     * @param int $level
     * @param int $offset integer added to location
     *
     * @return void
     */
    function traverseTopic($topic, $parentid=0, $level = 0) {
        $subtopics =& $topic->getFirstChildTopics();
        $level++;
        foreach (array_keys($subtopics) as $i) {
            $this->pages[] = array(   'location' => ($subtopics[$i]->topic_id()),
                                      'name' => $subtopics[$i]->topic_title(),
                                      'level' => $level);
            $this->traverseTopic($subtopics[$i], $subtopics[$i]->topic_pid(), $level);
        }
    }

    /**
     * Add locations to $this->locations
     *
     * @param int $topic_id
     * @param int $offset integer to add to location
     *
     * @return void
     */
    function getLocationHelper($topic_id) {
        include_once XOOPS_ROOT_PATH."/class/xoopstree.php";

        $tree = new XoopsTree($GLOBALS['xoopsDB']->prefix("topics"), "topic_id", "topic_pid");

        $this->locations = $tree->getAllParentId($topic_id);
        $this->locations[] = $topic_id;
    }
}

$resolver= new NewsResolver();
?>
