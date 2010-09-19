<?php
// $Id: modinfo.php,v 1.35 2008/04/19 16:39:13 marcellobrandao Exp $
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
define("_MI_YOG_NUMBPICT_TITLE","Numero de Fotos");
define("_MI_YOG_NUMBPICT_DESC" ,"Numero de fotos que puede tener un usuario en su pagina");
define("_MI_YOG_ADMENU1","Inicio");
define("_MI_YOG_ADMENU2" ,"Sobre");
define("_MI_YOG_SMNAME1" ,"Aceptar");
define("_MI_YOG_THUMW_TITLE" , "Anchura de la miniatura");
define("_MI_YOG_THUMBW_DESC" , "Anchura de la miniatura en pixels<br />Esto quiere decir que la miniatura de su foto será<br />la mayor parte del tamaño en achura<br />Todas las porporciones se mantendrán");
define("_MI_YOG_THUMBH_TITLE" , "Altura de la miniatura");
define("_MI_YOG_THUMBH_DESC" , "Altura de la miniatura en pixels<br />Esto quiere decir que la miniatura de su foto será<br />la mayor parte del tamaño en altura<br />Todas las porporciones se mantendrán");
define("_MI_YOG_RESIZEDW_TITLE" , "Ajustar anchura de la foto");
define("_MI_YOG_RESIZEDW_DESC" , "Ajustar anchura de la foto en pixels<br />Esto quiere decir que la miniatura de su foto será<br />la mayor parte del tamaño en achura<br />Todas las porporciones se mantendrán<br /> Si la foto original es mayor que este tamaño <br />será ajustada.");
define("_MI_YOG_RESIZEDH_TITLE" , "Ajustar altura de la foto");
define("_MI_YOG_RESIZEDH_DESC" , "Ajustar altura de la foto en pixels<br />Esto quiere decir que la miniatura de su foto será<br />la mayor parte del tamaño en altura<br />Todas las porporciones se mantendrán<br /> Si la foto original es mayor que este tamaño <br />será ajustada.");
define("_MI_YOG_ORIGINALW_TITLE" , "Anchura máxima de la foto original");
define("_MI_YOG_ORIGINALW_DESC" , "Máxima anchura de la foto original en pixels<br />Significa que la foto original del usuario no puede exceder <br />de este tamaño en anchura<br /> de lo contrario no será añadida");
define("_MI_YOG_ORIGINALH_TITLE" , "Altura máxima de la foto original");
define("_MI_YOG_ORIGINALH_DESC" , "Máxima altura de la foto original en pixels<br />Significa que la foto original del usuario no puede exceder <br />de este tamaño en altura<br /> de lo contrario no será añadida");
define("_MI_YOG_PATHUPLOAD_TITLE" , "Ruta de las subidas");
define("_MI_YOG_PATHUPLOAD_DESC" , "Ruta para el directorio de subidas<br />en Linux puede ser algo así /var/www/uploads<br />en Windows así C:/Program Files/www");
define("_MI_YOG_LINKPATHUPLOAD_TITLE","Enlazar a tu directorio de subidas");
define("_MI_YOG_LINKPATHUPLOAD_DESC","esta es la dirección de la ruta principal de subidas <br />like http://www.yoursite.com/uploads");
define("_MI_YOG_MAXFILEBYTES_TITLE","Máximo tamaño en bytes");
define("_MI_YOG_MAXFILEBYTES_DESC","Este es el tamaño maximo que puede tener la foto<br /> Puedes ajustar los bytes así: 512000 bytes para 500 KB<br /> Ten cuidado con el tamaño maximo, tambien esta ajustado en el php.ini . El servidor actualmente lo tiene ajustado a ".ini_get('post_max_size'));

define("_MI_YOG_PICTURE_NOTIFYTIT","Álbum");
define("_MI_YOG_PICTURE_NOTIFYDSC","Noficaciones ralacionadas con el Álbum del usuario");
define("_MI_YOG_PICTURE_NEWPIC_NOTIFY","Nueva Foto");
define("_MI_YOG_PICTURE_NEWPIC_NOTIFYCAP","Avisame cuando este usuario ponga una foto nueva");
define("_MI_YOG_PICTURE_NEWPOST_NOTIFYDSC","Avisame cuando este usuario ponga una foto nueva");
define("_MI_YOG_PICTURE_NEWPIC_NOTIFYSBJ","{X_OWNER_NAME} ha puesto una foto nueva en su álbum");
//define("_MI_YOGURT_HOTTEST","Hottest Albums");
//define("_MI_YOGURT_HOTTEST_DESC","This block will show the hottest albums");
//define("_MI_YOGURT_HOTFRIENDS","Hot Friends");
//define("_MI_YOGURT_HOTFRIENDS_DESC","This block shows the users hot friends that have been added");
define("_MI_YOG_PICTURE_TEMPLATEINDEXDESC","Esta plantilla muestra las fotos del usuario");
define("_MI_YOG_PICTURE_TEMPLATEFRIENDSDESC","ESta plantilla muestra los amigos del usuario");
define("_MI_YOGURT_MYFRIENDS","Mis Amigos");
define("_MI_YOG_FRIENDSPERPAGE_TITLE" , "Amigos por pagina");
define("_MI_YOG_FRIENDSPERPAGE_DESC" , "Ajusta el numero de amigos por página que quieres ver<br />En en la sección Mis Amigos");
define("_MI_YOG_PICTURESPERPAGE_TITLE","Fotos mostradas por página antes de la paginación");

define("_MI_YOGURT_LAST","Último bloque de fotos");
define("_MI_YOGURT_LAST_DESC","Últimas fotos enviadas independientemente del álbum");
define("_MI_YOG_DELETEPHYSICAL_TITLE","Suprimir archivos de la carpeta de subidas");
define("_MI_YOG_DELETEPHYSICAL_DESC","Confirmando Si aquí, permitirá el script que suprimira los archivos subidos ademas de eliminarlos de la base de datos.<br /> Tenga cuidado con esta opción, si usted excluye los archivos de la carpeta y no  de la base de datos, algunos usuarios que hayan enlazado la imagen directamente en alguna otra parte de la web, perderan ese contenido;<br /> asi mismo si no lo excluyera, estaria usando demasiado espacio en disco del servidor.<br />Configúrelo bien para sus necesidades.");

define("_MI_YOGURT_MYVIDEOS","Mis Videos");
define("_MI_YOG_PICTURE_TEMPLATEALBUMDESC","Plantilla para la galería de Fotos");
define("_MI_YOGURT_MYPICTURES","Mis Fotos");
define("_MI_YOGURT_MODULEDESC","Este modulo simula una red social al estilo de MySpace o Orkut.");
define("_MI_YOG_TUBEW_TITLE","Anchura de los videos de YouTube");
define("_MI_YOG_TUBEW_DESC","Anchura en pixels del reproductor de YouTube");
define("_MI_YOG_TUBEH_TITLE","Altura de los videos de Youtube");
define("_MI_YOG_TUBEH_DESC","Altura en pixels del reproductor de YouTube");
define("_MI_YOG_PICTURE_TEMPLATESCRAPBOOKDESC","Plantilla para la Pizzarra");
define("_MI_YOG_PICTURE_TEMPLATESEUTUBODESC","Plantilla para la sección de Videos");
define("_MI_YOG_PICTURE_TEMPLATETRIBESDESC","Plantillas para los Videos");
define("_MI_YOGURT_MYSCRAPS","Mi Pizzarra");
define("_MI_YOGURT_MYTRIBES","Mis Tribus");
define("_MI_YOG_TEMPLATENAVBARDESC","Plantilla superior de navegación usada en todas las páginas");

define("_MI_YOG_VIDEOSPERPAGE_TITLE","Videos por página");
define("_MI_YOG_VIDEO_NOTIFYTIT","Videos");
define("_MI_YOG_VIDEO_NOTIFYDSC","Notificación de Videos");
define("_MI_YOG_VIDEO_NEWVIDEO_NOTIFY","Nuevo Video");
define("_MI_YOG_VIDEO_NEWVIDEO_NOTIFYCAP","Notificame cuando este usuario suba un video");
define("_MI_YOG_VIDEO_NEWVIDEO_NOTIFYDSC","Descripción de notificación de nuevo video");
define("_MI_YOG_VIDEO_NEWVIDEO_NOTIFYSBJ","{X_OWNER_NAME} ha subido un nuevo video a su perfil");

define("_MI_YOG_SCRAP_NOTIFYTIT","Pizarra");
define("_MI_YOG_SCRAP_NOTIFYDSC","Notificación de la Pizarra");
define("_MI_YOG_SCRAP_NEWSCRAP_NOTIFY","Nueva anotación");
define("_MI_YOG_SCRAP_NEWSCRAP_NOTIFYCAP","Notificame cuando haya una nueva notificación en la pizarra");
define("_MI_YOG_SCRAP_NEWSCRAP_NOTIFYDSC","Descripción de notificación de una nueva anotación");
define("_MI_YOG_SCRAP_NEWSCRAP_NOTIFYSBJ","{X_OWNER_NAME} ha recibido una nueva anotación en su Pizarra");

define("_MI_YOG_MAINTUBEW_TITLE","Anchura del video principal");
define("_MI_YOG_MAINTUBEW_DESC","Anchura del video, que se mostrará en la pagina principal del modulo");
define("_MI_YOG_MAINTUBEH_TITLE","Altura del video principal");
define("_MI_YOG_MAINTUBEH_DESC","Altura del video, que se mostrará en la pagina principal del modulo");

//24/09/2007
define("_MI_YOGURT_MYCONFIGS","Mis Ajustes");
define("_MI_YOG_PICTURE_TEMPLATECONFIGSDESC","Ajustes de plantilla para el usuario");
define("_MI_YOG_PICTURE_TEMPLATEFOOTERDESC","Plantille del footer del modulo");
define("_MI_YOG_PICTURE_TEMPLATEEDITTRIBE","Plantillas para los atributos del la tribu");
define("_MI_YOGURT_LICENSE",'Yogurt by Marcello Brandão is licensed under a Attribution-No Derivative Works 2.5 Brazil.');

//19/10/2007
define("_MI_YOG_TRIBESPERPAGE_TITLE","Tribus por página");
define("_MI_YOG_TRIBESPERPAGE_DESC","Tripus por página antes de que se resalte la paginación");
define("_MI_YOG_PICTURE_TEMPLATESEARCHRESULTDESC","Esta plantilla muestra el resultado de busqueda de las comunidades");
define("_MI_YOG_PICTURE_TEMPLATETRIBEDESC","Esta plantilla muestra las tribus y sus miembros");

//22/10/2007
define("_MI_YOGURT_MYPROFILE","Mi Perfil");
define("_MI_YOGURT_SEARCH","Buscar Miembros");
define("_MI_YOG_PICTURE_TEMPLATESEARCHRESULTSDESC","Plantilla para los resultados de la busqueda");
define("_MI_YOG_PICTURE_TEMPLATESEARCHFORMDESC","Plantilla para los resultados de busqueda");

//26/10/2007
define("_MI_YOG_ENABLEPICT_TITLE","Activa la sección de fotos");
define("_MI_YOG_ENABLEPICT_DESC","Activando las sección de fotos para los usuarios, permitirá la galería de fotos");
define("_MI_YOG_ENABLEFRIENDS_TITLE","Activa la sección de amgios");
define("_MI_YOG_ENABLEFRIENDS_DESC","Activando la sección de amigos para los usuarios, permitirá la agenda de amigos");
define("_MI_YOG_ENABLEVIDEOS_TITLE","Activa la sección de videos");
define("_MI_YOG_ENABLEVIDEOS_DESC","Activando la sección de videos para los usuarios , permitirá la galería de videos");
define("_MI_YOG_ENABLESCRAPS_TITLE","Activa la sección de pizarra");
define("_MI_YOG_ENABLESCRAPS_DESC","Activando la seccion de pizarra, permitirá que los miembros dejen un mensaje publico a otros miembros. similar al muro de Facebook");
define("_MI_YOG_ENABLETRIBES_TITLE","Activa la sección de tribus");
define("_MI_YOG_ENABLETRIBES_DESC","Activando la sección de tribus a los usuarios, permitirá que creen tribus, con grupos de usuarios que compartan los mismo intereses");
define("_MI_YOG_SCRAPSPERPAGE_TITLE","Numero de anotaciones por página");
define("_MI_YOG_SCRAPSPERPAGE_DESC","Numero de notas por pagina, antes de que la página de navegación se muestre");

//25/11/2007
define("_MI_YOGURT_FRIENDS","Mis Amigos");
define("_MI_YOGURT_FRIENDS_DESC","Este bloque muestra los amigos del usuario");

//26/01/2008
define("_MI_YOG_IMGORDER_TITLE", "Orden de las fotos");
define("_MI_YOG_IMGORDER_DESC", "Muestra la foto mas reciente primero?");

//08/04/2008
define("_MI_YOG_PICTURE_TEMPLATENOTIFICATIONS","Plantilla para las notificaciones");

//11/04/2008
define("_MI_YOG_FRIENDSHIP_NOTIFYTIT","Amistades");
define("_MI_YOG_FRIENDSHIP_NOTIFYDSC","Petición de amistad");
define("_MI_YOG_FRIEND_NEWPETITION_NOTIFY","Peticion");
define("_MI_YOG_FRIEND_NEWPETITION_NOTIFYCAP","Notifiqueme cuando alguien quiera mi amistad");
define("_MI_YOG_FRIEND_NEWPETITION_NOTIFYDSC","Notifiqueme cuando alguien quiera mi amistad");
define("_MI_YOG_FRIEND_NEWPETITION_NOTIFYSBJ","Alguien te ha preguntado si quieres ser su amigo");

//13/04/2008
define("_MI_YOG_PICTURE_TEMPLATEFANS","Plantilla para la página de fans");

//17/07/2008
define("_MI_YOG_ENABLEAUDIO_TITLE","Activa la sección de audio");
define("_MI_YOG_ENABLEAUDIO_DESC","Activando la sección de audio para los usuarios, permitirá tener listas de audio");
define("_MI_YOG_PICTURE_TEMPLATEAUDIODESC","Plantilla para la página de audio");
define("_MI_YOG_NUMBAUDIO_TITLE","Numero maximo de archivos de audio por usuario");
define("_MI_YOG_AUDIOSPERPAGE_TITLE","Numero de mp3 por página");

//19/04/2008
define("_MI_YOGURT_MYAUDIOS","Mi Audio");
?>