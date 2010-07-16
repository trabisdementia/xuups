<?php
$skinversion['template'] = 'templates/template.html';

$skinversion['css'] = 'css/superfish.css';

$skinversion['js'] = array('../../js/jquery-1.3.2.min.js',
                             '../../js/hoverIntent.js',
                             '../../js/superfish.js'
                             );

$header  = "\n" . '<script type="text/javascript">';
$header .= "\n" . '  var $sf = jQuery.noConflict()';
$header .= "\n" . '  $sf(function(){';
$header .= "\n" . '    $sf(\'ul.sf-menu\').superfish({';
$header .= "\n" . '       delay:       1000,';
$header .= "\n" . '       animation:   {opacity:\'show\',height:\'show\'},';
$header .= "\n" . '       speed:       \'fast\'';
$header .= "\n" . '    });';
$header .= "\n" . '  });';
$header .= "\n" . '</script>';

$skinversion['header'] = $header;
