<?php

class MymenusBuilder
{
    var $parents = array();
    var $output = array();

    function __construct($array){
        $this->addMenu($array);
    }

    function addMenu($array)
    {
        foreach ($array as $item) {
            $this->add($item);
        }
    }

    function add($item)
    {
        $this->parents[$item['pid']][] = $item;
    }

    function buildMenus($pid = 0) {
        static $idx = -1;
        static $level = -1;
        $level += 1;
        $first = true;

        foreach ($this->parents[$pid] as $item) {
            $idx += 1;

            $this->output[$idx]['oul'] = false;
            $this->output[$idx]['oli'] = false;
            $this->output[$idx]['close'] = '';
            $this->output[$idx]['cul'] = false;
            $this->output[$idx]['cli'] = false;
            $this->output[$idx]['hassub'] = false;
            $this->output[$idx]['level'] = $level;

            if ($first) {
                $this->output[$idx]['oul'] = true;
                $first = false;
            }

            $this->output[$idx]['oli'] = true;
            $this->output[$idx] = array_merge($item, $this->output[$idx]);

            if (isset($this->parents[$item['id']])) {
                $this->output[$idx]['hassub'] = true;
                $this->buildMenus($item['id']);
            }
            $this->output[$idx]['cli'] = true;
            $this->output[$idx]['close'] .= '</li>';
        }
        $this->output[$idx]['cul'] = true;
        $this->output[$idx]['close'] .= '</ul>';
        $level -= 1;
    }

    function buildUpDown($pid = 0)
    {
        static $idx = -1;
        $prevWeight = null;
        $up = 0;
        $down = 1;
        $counter = 0;
        $count = count($this->parents[$pid]);

        foreach ($this->parents[$pid] as $item) {
            $idx += 1;
            $counter++;
            if ($counter == $count) { $down = 0; } // turn off down link for last entry

            if ($up) {
                $this->output[$idx]['up_weight'] = $prevWeight;
            }
            if ($down) {
                $this->output[$idx]['down_weight'] = $this->output[$idx]['weight'] + 2;
            }

            $prevWeight = $this->output[$idx]['weight'];
            $up = 1; // turn on up link for all entries after first one

            if (isset($this->parents[$item['id']])) {
                $this->buildUpDown($item['id']);
            }
        }
    }

    function buildSelected()
    {
        //get the currentpage
        $sel = array();
        $query_string = $_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '';
        $self = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . $query_string;

        //set a default page in case we don´t get matches
        $default = XOOPS_URL . "/index.php";

        //get all matching links
        foreach ($this->output as $idx => $menu) {
            $selected = eregi($menu['link'], $self) ? 1 : 0;
            $selected = ($menu['link'] == $self) ? 1 : $selected;
            $selected = ($menu['link'] == $default) ? 1 : $selected;
            if ($selected) {
                $sel[$idx] = $menu;
            }
        }

        //From those links get only the longer one
        $longlink = "";
        $longidx = 0;
        foreach ($sel as $idx => $menu) {
            if (strlen($menu['link']) > strlen($longlink)) {
                $longidx = $idx;
                $longlink = $menu['link'];
            }
        }
        $this->output[$longidx]['selected'] = true;

        $this->output[$longidx]['topselected'] = true;

        //Now turn all this menu parents to selected
        $this->addSelectedParents($this->output[$longidx]['pid']);

    }

    function addSelectedParents($pid)
    {
        foreach ($this->output as $idx => $menu) {
            if ($menu['id'] == $pid) {
                $this->output[$idx]['selected'] = true;
                $this->addSelectedParents($menu['pid']);
            }
        }
    }

    function render()
    {
        $this->buildMenus();
        $this->buildUpDown();
        $this->buildSelected();

        return $this->output;
    }

}

?>