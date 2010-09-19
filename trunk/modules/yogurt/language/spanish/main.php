<?php
// $Id: main.php,v 1.46 2008/04/19 16:39:13 marcellobrandao Exp $
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
//Present in many files (videos pictures etc...)
define("_MD_YOGURT_DELETE", "Borrar");
define("_MD_YOGURT_EDITDESC", "Editar Descripción");
define("_MD_YOGURT_TOKENEXPIRED", "Su Sesión ha Expirado<br />Por favor inténtelo de nuevo");
define("_MD_YOGURT_DESC_EDITED","La descripcion se ha editado correctamente");
define("_MD_YOGURT_CAPTION","Subtítulo");
define("_MD_YOGURT_YOUCANUPLOAD","Solo puede subir fotos en .jpg y con un límite de %s KBytes ");
define("_MD_YOGURT_UPLOADPICTURE","Subir Foto");
define("_MD_YOGURT_NOCACHACA","Alaaaa! se fue al garete<br />
Desafortunadamente este modulo ha tenido un error. Ayudaría mucho que lo volviera a intentar. ");//Funny general error message
define("_MD_YOGURT_PAGETITLE","%s - %s's Red Social");
define("_MD_YOGURT_SUBMIT","Enviar");
define("_MD_YOGURT_VIDEOS","Videos");
define("_MD_YOGURT_SCRAPBOOK","Pizarra");
define("_MD_YOGURT_PHOTOS","Fotos");
define("_MD_YOGURT_FRIENDS","Amigos");
define("_MD_YOGURT_TRIBES","Tribus");
define("_MD_YOGURT_NOTRIBESYET","No hay Tribus ahora");
define("_MD_YOGURT_MYTRIBES","Mi Tribu");
define("_MD_YOGURT_ALLTRIBES","Todas las Tribus");
define("_MD_YOGURT_PROFILE","Perfil");
define("_MD_YOGURT_HOME","Inicio");
define("_MD_YOGURT_CONFIGSTITLE","Mis propiedaes");

##################################################### PICTURES #######################################################
//submit.php (for pictures submission
define("_MD_YOGURT_UPLOADED","Subido correctamente");

//delpicture.php
define("_MD_YOGURT_ASKCONFIRMDELETION","Esta seguro que quiere borrar esta foto?");
define("_MD_YOGURT_CONFIRMDELETION","Si por favor bórrela!");

//album.php
define("_MD_YOGURT_YOUHAVE", "Tienes %s Foto(s) en tu álbum.");
define("_MD_YOGURT_YOUCANHAVE", "Puedes tener hasta %s Foto(s).");
define("_MD_YOGURT_DELETED","Imagen borrada correctamente");
define("_MD_YOGURT_SUBMIT_PIC_TITLE","Subir Foto");
define("_MD_YOGURT_SELECT_PHOTO","Seleccionar Foto");
define("_MD_YOGURT_NOTHINGYET","Todavía no hay fotos en este álbum");
define("_MD_YOGURT_AVATARCHANGE","Haz de esta foto tu avatar");
define("_MD_YOGURT_PRIVATIZE","Solo tu podras ver esta foto en tu álbum");
define("_MD_YOGURT_UNPRIVATIZE","Todos podran ver esta foto en tu  álbum");
define("_MD_YOGURT_MYPHOTOS","Mis Fotos");

//avatar.php
define("_MD_YOGURT_AVATAR_EDITED","Has cambiado tu avatar!");

//private.php
define("_MD_YOGURT_PRIVATIZED","A partir de ahora solo tu podras ver esta foto de tu álbum");
define("_MD_YOGURT_UNPRIVATIZED","A partir de ahora todos podran ver esta foto de tu álbum");

########################################################## FRIENDS ###################################################
//friends.php
define("_MD_YOGURT_FRIENDSTITLE","%s's amigos");
define("_MD_YOGURT_NOFRIENDSYET","Sin amigos de momento");//also present in index.php
define("_MD_YOGURT_MYFRIENDS","Mis amigos");
define("_MD_YOGURT_FRIENDSHIPCONFIGS","Defina las configuraciones de sus amigos. Evalue a sus amigos.");

//class/yogurtfriendship.php
define("_MD_YOGURT_EDITFRIENDSHIP","Su amistad con este miembro:");
define("_MD_YOGURT_FRIENDNAME","Usuario");
define("_MD_YOGURT_LEVEL","Grado de amistad:");
define("_MD_YOGURT_UNKNOWNACCEPTED","Desconocido");
define("_MD_YOGURT_AQUAITANCE","Conocido");//also present in index.php
define("_MD_YOGURT_FRIEND","Amigo");//also present in index.php
define("_MD_YOGURT_BESTFRIEND","Mi mejor amigo");//also present in index.php
define("_MD_YOGURT_FAN","Fan");//also present in index.php
define("_MD_YOGURT_SEXY","Sexy");//also present in index.php
define("_MD_YOGURT_SEXYNO","No");
define("_MD_YOGURT_SEXYYES","Si");
define("_MD_YOGURT_SEXYALOT","Muchísimo!");
define("_MD_YOGURT_TRUSTY","Honesto");
define("_MD_YOGURT_TRUSTYNO","No");
define("_MD_YOGURT_TRUSTYYES","Si");
define("_MD_YOGURT_TRUSTYALOT","Muchísimo");
define("_MD_YOGURT_COOL","Cool");
define("_MD_YOGURT_COOLNO","No");
define("_MD_YOGURT_COOLYES","Si");
define("_MD_YOGURT_COOLALOT","Muchísimo");
define("_MD_YOGURT_PHOTO","Fotos de mis amigos");
define("_MD_YOGURT_UPDATEFRIEND","Actualizar Miembros");

//editfriendship.php
define("_MD_YOGURT_FRIENDSHIPUPDATED","Miebro Actualizado");

//submitfriendpetition.php
define("_MD_YOGURT_PETITIONED","Una solicitud de amistad ha sido enviada a este usuario, Espere a que acepte para tenerlo en su lista de amigos.");
define("_MD_YOGURT_ALREADY_PETITIONED","Ya has enviado una solicitud de amistad a este usuario o vice-versa<br />, Espere hasta que la acepte, recházela o compruebe si te ha enviado una solicitu en tu pagina de perfil.");

//makefriends.php
define("_MD_YOGURT_FRIENDMADE","Añadido como amigo!");

//delfriendship.php
define("_MD_YOGURT_FRIENDSHIPTERMINATED","Has roto tu amistad con este usuario!");

############################################ VIDEOS ############################################################
//mainvideo.php
define("_MD_YOGURT_SETMAINVIDEO","Has selecionado este video para que aparezca en tu pagina principal");

//seutubo.php
define("_MD_YOGURT_YOUTUBECODE","Codigo de Youtube o URL");
define("_MD_YOGURT_ADDVIDEO","Añadir Video");
define("_MD_YOGURT_ADDFAVORITEVIDEOS","Añadir como video Favorito");
define("_MD_YOGURT_ADDVIDEOSHELP","Si quieres compartir un video con nosotros, Sube el video a 
<a href=http://www.youtube.com>YouTube</a> y despues añade la URL aquí "); //The name of the site will show after this
define("_MD_YOGURT_MYVIDEOS","Mis Videos");
define("_MD_YOGURT_MAKEMAIN","Haz este video como tu principal");
define("_MD_YOGURT_NOVIDEOSYET","No hay videos aún!");

//delvideo.php
define("_MD_YOGURT_ASKCONFIRMVIDEODELETION","Estas seguro que quieres eliminar este video?");
define("_MD_YOGURT_CONFIRMVIDEODELETION","Si lo estoy!");
define("_MD_YOGURT_VIDEODELETED","Tu video fue borrado");

//video_submited.php
define("_MD_YOGURT_VIDEOSAVED","Tu video se ha guardado");

############################## TRIBES ########################################################
//class/yogurt_tribes.php
define("_MD_YOGURT_SUBMIT_TRIBE","Crear una nueva Tribu");
define("_MD_YOGURT_UPLOADTRIBE","Guardar Tribu");//also present in many ther tribes related
define("_MD_YOGURT_TRIBE_IMAGE","Imgen de la Tribu");//also present in many ther tribes related
define("_MD_YOGURT_TRIBE_TITLE","Título");//also present in many ther tribes related
define("_MD_YOGURT_TRIBE_DESC","Descripción");//also present in many ther tribes related
define("_MD_YOGURTCREATEYOURTRIBE","Crea tu propia Tribu!");//also present in many ther tribes related

//abandontribe.php
define("_MD_YOGURT_ASKCONFIRMABANDONTRIBE","Esta seguro que quiere abandonar esta Tribu?");
define("_MD_YOGURT_CONFIRMABANDON","Si sacame de esta Tribu!");
define("_MD_YOGURT_TRIBEABANDONED","No perteneceras mas a esta Tribu.");

//becomemembertribe.php
define("_MD_YOGURT_YOUAREMEMBERNOW","Ahora eres miembro de esta Tribu");
define("_MD_YOGURT_YOUAREMEMBERALREADY","Ya eras miembro de esta Tribu");

//delete_tribe.php
define("_MD_YOGURT_ASKCONFIRMTRIBEDELETION","Estas seguro que quieres borrar esta Tribu permanentemente?");
define("_MD_YOGURT_CONFIRMTRIBEDELETION","Si, borra la Tribu!");
define("_MD_YOGURT_TRIBEDELETED","Tribu borrada!");

//edit_tribe.php
define("_MD_YOGURT_MAINTAINOLDIMAGE","Manten esta imagen");//also present in other tribes related
define("_MD_YOGURT_TRIBEEDITED","Tribu editada");
define("_MD_YOGURT_EDIT_TRIBE","Edita tu Tribu");//also present in other tribes related
define("_MD_YOGURT_TRIBEOWNER","Eres el creador de esta Tribu!");//also present in other tribes related
define("_MD_YOGURT_MEMBERSDOFTRIBE","Miembros de la Tribu");//also present in other tribes related

//submit_tribe.php
define("_MD_YOGURT_TRIBE_CREATED","Tu Tribu fue creada");

//kickfromtribe.php
define("_MD_YOGURT_CONFIRMKICK","Si, echalo de la Tribu!");
define("_MD_YOGURT_ASKCONFIRMKICKFROMTRIBE","Estas seguro de querer echar de la Tribu a este usuario?");
define("_MD_YOGURT_TRIBEKICKED","Has desterrado a este usuario de la Tribu, pero quien sabe intentara volver!");

//Tribes.php
define("_MD_YOGURT_TRIBE_ABANDON","Abandonar esta Tribu");
define("_MD_YOGURT_TRIBE_JOIN","Unete al esta Tribu y presentate a los demas!");
define("_MD_YOGURT_TRIBE_SEARCH","Buscar una Tribu");
define("_MD_YOGURT_TRIBE_SEARCHKEYWORD","Palabra Clave");

######################################### SCRAPS #####################################################
//scrapbook.php
define('_MD_YOGURT_ENTERTEXTSCRAP',"Introduzca el texto o xoops code");
define("_MD_YOGURT_SENDSCRAP","Enviar nota");
define("_MD_YOGURT_ANSWERSCRAP","Contesta");//also present in configs.php
define("_MD_YOGURT_MYSCRAPBOOK","Mi Pizarra");
define("_MD_YOGURT_CANCEL","Cancelar");//also present in configs.php
define("_MD_YOGURT_SCRAPTIPS","Trucos para anotar");
define("_MD_YOGURT_BOLD","Negrita");
define("_MD_YOGURT_ITALIC","Italica");
define("_MD_YOGURT_UNDERLINE","subrrayado");
define("_MD_YOGURT_NOSCRAPSYET","No hay anotaciones creadas en esta Pizarra");

//submit_scrap.php
define("_MD_YOGURT_SCRAP_SENT","Gracias por participar, nota enviada");

//delete_scrap.php
define("_MD_YOGURT_ASKCONFIRMSCRAPDELETION","Estas seguro de querer borrar esta anotación?");
define("_MD_YOGURT_CONFIRMSCRAPDELETION","Si por favor borra esta anotación.");
define("_MD_YOGURT_SCRAPDELETED","Esta anotación ha sido borrado");

############################ CONFIGS ##############################################
//configs.php
define("_MD_YOGURT_CONFIGSEVERYONE","Todos");
define("_MD_YOGURT_CONFIGSONLYEUSERS","Solo usuarios registrados");
define("_MD_YOGURT_CONFIGSONLYEFRIENDS","Mis amigos.");
define("_MD_YOGURT_CONFIGSONLYME","Solo yo");
define("_MD_YOGURT_CONFIGSPICTURES","Ver tus Fotos");      
define("_MD_YOGURT_CONFIGSVIDEOS","Ver tus Videos"); 
define("_MD_YOGURT_CONFIGSTRIBES","Ver tus Tribus"); 
define("_MD_YOGURT_CONFIGSSCRAPS","Ver tus Notas"); 
define("_MD_YOGURT_CONFIGSSCRAPSSEND","Enviar tu Notas");
define("_MD_YOGURT_CONFIGSFRIENDS","Ver tus amigos");
define("_MD_YOGURT_CONFIGSPROFILECONTACT","Ver tu información de contacto"); 
define("_MD_YOGURT_CONFIGSPROFILEGENERAL","Ver tu información"); 
define("_MD_YOGURT_CONFIGSPROFILESTATS","Ver tu estado");
define("_MD_YOGURT_WHOCAN","Quién puede:");

//submit_configs.php
define("_MD_YOGURT_CONFIGSSAVE","Configuración Guardada!");

//class/yogurt_controler.php
define("_MD_YOGURT_NOPRIVILEGE","El propietario de este perfil a restringido la posibilidad de verlo, <br /> por eso no puede acceder. <br />Conectese para ser su amigo <br />If they haven't set it, so only they can see, <br />If they haven't set it, so only they can see.");

###################################### OTHERS ##############################

//index.php
define("_MD_YOGURT_VISITORS","Visitantes (Los que han visitado tu perfil recientemente)");
define("_MD_YOGURT_USERDETAILS","Detalles del usuario");
define("_MD_YOGURT_USERCONTRIBUTIONS","Contribuciones del usuario");
define("_MD_YOGURT_FANS","Fans");
define("_MD_YOGURT_UNKNOWNREJECTING","No conozco a este usuario, No lo añadas a mi lista de amigos");
define("_MD_YOGURT_UNKNOWNACCEPTING","No conozco a este usuario, pero añadelo a mi lista de amigos");
define("_MD_YOGURT_ASKINGFRIEND","ES %s tu amigo?");
define("_MD_YOGURT_ASKBEFRIEND","Pregunta a este usuario si quiere ser tu amigo?");
define("_MD_YOGURT_EDITPROFILE","Edita tu perfil");
define("_MD_YOGURT_SELECTAVATAR","Sube fotos a tu álbum y selecciona una como tu avatar.");
define("_MD_YOGURT_SELECTMAINVIDEO","Añade videos a tu álbum y selecciona uno para poner en tu pagina principal");
define("_MD_YOGURT_NOAVATARYET","Sin avatar aún");
define("_MD_YOGURT_NOMAINVIDEOYET","Sin video aún");
define("_MD_YOGURT_MYPROFILE","Mi Perfil");
define("_MD_YOGURT_YOUHAVEXPETITIONS","Tiene %u solicidtud/es de amistad.");
define("_MD_YOGURT_CONTACTINFO","Inforamción de contacto");
define("_MD_YOGURT_SUSPENDUSER","Suspender usuario");
define("_MD_YOGURT_SUSPENDTIME","Tiempo de la suspensión(en segundos)");
define("_MD_YOGURT_UNSUSPEND","Readmitir usuario");
define("_MD_YOGURT_SUSPENSIONADMIN","Herramienta para administrar suspensiones");

//suspend.php
define("_MD_YOGURT_SUSPENDED","Usuario bajo suspension hasta %s");
define("_MD_YOGURT_USERSUSPENDED","Usuario suspendido!");//als0 present in index.php

//unsuspend.php
define("_MD_YOGURT_USERUNSUSPENDED","Usuario readmitido");

//searchmembers.php
define("_MD_YOGURT_SEARCH","Buscar miebros");
define("_MD_YOGURT_AVATAR","Avatar");
define("_MD_YOGURT_REALNAME","Nombre Real");
define("_MD_YOGURT_REGDATE","Fecha de registro");
define("_MD_YOGURT_EMAIL","Email");
define("_MD_YOGURT_PM","PM");
define("_MD_YOGURT_URL","URL");
define("_MD_YOGURT_ADMIN","ADMIN");
define("_MD_YOGURT_PREVIOUS","Anterior");
define("_MD_YOGURT_NEXT","Siguente");
define("_MD_YOGURT_USERSFOUND","%s miembro(s) encontrado(s)");
define("_MD_YOGURT_TOTALUSERS", "Total: %s miembros");
define("_MD_YOGURT_NOFOUND","Miembros no encontrados");
define("_MD_YOGURT_UNAME","Nombre de usuario");
define("_MD_YOGURT_ICQ","Numero ICQ");
define("_MD_YOGURT_AIM","Identidad AIM");
define("_MD_YOGURT_YIM","Identidad YIM");
define("_MD_YOGURT_MSNM","Identidad MSNM");
define("_MD_YOGURT_LOCATION","Ubicación");
define("_MD_YOGURT_OCCUPATION","Empleo");
define("_MD_YOGURT_INTEREST","Intereses");
define("_MD_YOGURT_URLC","Pagina Web");
define("_MD_YOGURT_LASTLOGMORE","Última visita posterior a <span style='color:#ff0000;'>X</span> días atrás");
define("_MD_YOGURT_LASTLOGLESS","Última visita anterior a <span style='color:#ff0000;'>X</span> días atrás");
define("_MD_YOGURT_REGMORE","Fecha de registro posterior a <span style='color:#ff0000;'>X</span> días atrás");
define("_MD_YOGURT_REGLESS","Fecha de ingreso anterior a <span style='color:#ff0000;'>X</span> días atrás");
define("_MD_YOGURT_POSTSMORE","Número de envíos superior a <span style='color:#ff0000;'>X</span>");
define("_MD_YOGURT_POSTSLESS","Número de envíos inferior a <span style='color:#ff0000;'>X</span>");
define("_MD_YOGURT_SORT","Encontrar por");
define("_MD_YOGURT_ORDER","Ordenar");
define("_MD_YOGURT_LASTLOGIN","Último acceso");
define("_MD_YOGURT_POSTS","Numero de envíos");
define("_MD_YOGURT_ASC","Orden ascendente");
define("_MD_YOGURT_DESC","Orden descendente");
define("_MD_YOGURT_LIMIT","Numero de usuarios por página");
define("_MD_YOGURT_RESULTS", "Resultado de busqueda");

//26/10/2007
define("_MD_YOGURT_VIDEOSNOTENABLED", "El administrador de la web ha desabilitado el modulo Video ");
define("_MD_YOGURT_FRIENDSNOTENABLED", "El administrador de la web ha desabilitado el modulo Amigos");
define("_MD_YOGURT_TRIBESNOTENABLED", "El administrador de la web ha desabilitado el modulo Tribus");
define("_MD_YOGURT_PICTURESNOTENABLED", "El administrador de la web ha desabilitado el modulo fotos");
define("_MD_YOGURT_SCRAPSNOTENABLED", "El administrador de la web ha desabilitado el modulo Pizarra");

//26/01/2008
define("_MD_YOG_ALLFRIENDS" , "Ver todos los amigos");
define("_MD_YOG_ALLTRIBES" , "Ver todas las tribus");

//31/01/2008
define("_MD_YOGURT_FRIENDSHIPNOTACCEPTED" , "Amistad rechazada");

//07/04/2008
define("_MD_YOGURT_USERDOESNTEXIST","Este usuario no existe o fue borrado");
define("_MD_YOGURT_FANSTITLE","%s's Fans");
define("_MD_YOGURT_NOFANSYET","Sin Fans aún");

//17/04/2008
define("_MD_YOGURT_AUDIONOTENABLED","El administrador de la web ha desabilitado el modulo Audio");
define("_MD_YOGURT_NOAUDIOYET","Este usario no ha subido archivos de audio aún");
define("_MD_YOGURT_AUDIOS","Audio");
define("_MD_YOGURT_CONFIGSAUDIOS","Ver tus archivos de audio");
define("_MD_YOGURT_UPLOADEDAUDIO","Archivo de audio subido");

define("_MD_YOGURT_SELECTAUDIO","Navega por tus archivos mp3");
define("_MD_YOGURT_AUTHORAUDIO","Autor/Cantante");
define("_MD_YOGURT_TITLEAUDIO","Título del archivo o canción");
define("_MD_YOGURT_ADDAUDIO","Añadir archivo mp3");
define("_MD_YOGURT_SUBMITAUDIO","Subir archivo");
define("_MD_YOGURT_ADDAUDIOHELP","Elige un archivo mp3 de tu ordenador, tamaño maximo %s ,<br /> Deja en blanco los campos de título y autor si su archivo dispone de metainfo");

//19/04/2008
define("_MD_YOGURT_AUDIODELETED","Tu archivo mp3 fué borrado!");
define("_MD_YOGURT_ASKCONFIRMAUDIODELETION","Desea realmente borrar el archivo de audio?");
define("_MD_YOGURT_CONFIRMAUDIODELETION","Si borralo!");

define("_MD_YOGURT_META","Meta Info");
define("_MD_YOGURT_META_TITLE","Titulo");
define("_MD_YOGURT_META_ALBUM","Álbum");
define("_MD_YOGURT_META_ARTIST","Artista");
define("_MD_YOGURT_META_YEAR","Año");

// v3.3RC2
define("_MD_YOGURT_PLAYER","Tu Reproductor de audio");


//by trabis
define("_MD_YOGURT_MYPAGETITLE_PROFILE","Perfil de %s");
define("_MD_YOGURT_MYMETADSC_PROFILE","Venga a conocer el perfil de %s en Latino-Poemas, su sitio de poemas, cartas y pensamientos");
define("_MD_YOGURT_MYMETAKEY_PROFILE","poemas, versos, %s, poemas de amor, versos de amor");
define("_MD_YOGURT_MYPAGETITLE_SCRAPS","Recados de %s");
define("_MD_YOGURT_MYMETADSC_SCRAPS","Venga ler los recados de %s en Latino-Poemas, su sitio de poemas, cartas y pensamientos");define("_MD_YOGURT_MYMETAKEY_SCRAPS","poemas, versos, %s, poemas de amor, versos de amor, recados, mensagens");define("_MD_YOGURT_MYPAGETITLE_PHOTOS","Fotos de %s");define("_MD_YOGURT_MYMETADSC_PHOTOS","Venga a conocer las fotos de %s en Latino-Poemas, su sitio de poemas, cartas y pensamientos");define("_MD_YOGURT_MYMETAKEY_PHOTOS","poemas, versos, %s, poemas de amor, versos de amor, fotos, fotografias");define("_MD_YOGURT_MYPAGETITLE_VIDEOS","Videos de %s");define("_MD_YOGURT_MYMETADSC_VIDEOS","Venga a conocer los videos de %s en Latino-Poemas, su sitio de poemas, cartas y pensamientos");define("_MD_YOGURT_MYMETAKEY_VIDEOS","poemas, versos, %s, poemas de amor, versos de amor, videos");define("_MD_YOGURT_MYPAGETITLE_AUDIO","Músicas de %s");define("_MD_YOGURT_MYMETADSC_AUDIO","Venga a conocer los músicas de %s en Latino-Poemas, su sitio de poemas, cartas y pensamientos");define("_MD_YOGURT_MYMETAKEY_AUDIO","poemas, versos, %s, poemas de amor, versos de amor, músicas");define("_MD_YOGURT_MYPAGETITLE_FRIENDS","Amigos de %s");define("_MD_YOGURT_MYMETADSC_FRIENDS","Venga a conocer los amigos de %s en Latino-Poemas, su sitio de poemas, cartas y pensamientos");define("_MD_YOGURT_MYMETAKEY_FRIENDS","poemas, versos, %s, poemas de amor, versos de amor, amigos, amizade");define("_MD_YOGURT_MYPAGETITLE_FANS","Fãs de %s");define("_MD_YOGURT_MYMETADSC_FANS","Venga a conocer los fãs de %s en Latino-Poemas, su sitio de poemas, cartas y pensamientos");define("_MD_YOGURT_MYMETAKEY_FANS","poemas, versos, %s, poemas de amor, versos de amor, fãs");
?>