<?php
$skinversion['template'] = 'templates/template.html';

$skinversion['css'] = array('css/superfish.css',
                              'css/superfish-navbar.css'
                              );
                              
$skinversion['js'] = array('../../js/jquery-1.3.2.min.js',
                             '../../js/hoverIntent.js',
                             '../../js/superfish.js'
                             );
                             
$header  = "\n" . '<script type="text/javascript">';
$header .= "\n" . '  var $sfnav = jQuery.noConflict()';
$header .= "\n" . '  $sfnav(function(){';
$header .= "\n" . '    $sfnav(\'ul.sf-menu\').superfish({';
$header .= "\n" . '       pathClass:  \'current\'';
$header .= "\n" . '    });';
$header .= "\n" . '  });';
$header .= "\n" . '</script>';

$skinversion['header'] = $header;
