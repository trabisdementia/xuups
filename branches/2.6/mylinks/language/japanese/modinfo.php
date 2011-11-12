<?php
// $Id$
// ------------------------------------------------------------------------ //
// XOOPS - PHP Content Management System                                    //
// Copyright (c) 2000 XOOPS.org                                             //
// <http://www.xoops.org/>                                                  //
// ------------------------------------------------------------------------ //
// ------------------------------------------------------------------------ //
// XOOPS Korean (translated by wanikoo[ wani@wanisys.net ])                 //
// <http://www.wanisys.net/>                                                //
// ------------------------------------------------------------------------ //
// This program is free software; you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License, or        //
// (at your option) any later version.                                      //
//                                                                          //
// You may not change or alter any portion of this comment or credits       //
// of supporting developers from this source code or any supporting         //
// source code which is considered copyrighted (c) material of the          //
// original comment or credit authors.                                      //
//                                                                          //
// This program is distributed in the hope that it will be useful,          //
// but WITHOUT ANY WARRANTY; without even the implied warranty of           //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the             //
// GNU General Public License for more details.                             //
//                                                                          //
// You should have received a copy of the GNU General Public License        //
// along with this program; if not, write to the Free Software              //
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA  //
// ------------------------------------------------------------------------ //

// Module Info

// The name of this module
define("_MI_MYLINKS_NAME", "��󥯽�");

// A brief description of this module
define("_MI_MYLINKS_DESC", "�桼������ͳ�˥�󥯾������Ͽ��������ɾ����Ԥ��륻��������������ޤ���");

// Names of blocks for this module (Not all module has blocks)
define("_MI_MYLINKS_BNAME1", "������");
define("_MI_MYLINKS_BNAME2", "��ɾ�����");

// Sub menu titles
define("_MI_MYLINKS_SMNAME1", "��Ͽ����");
define("_MI_MYLINKS_SMNAME2", "�͵����");
define("_MI_MYLINKS_SMNAME3", "��ɾ�����");

define("_MI_MYLINKS_ADMENU2", "��󥯾�����ɲ� / �Խ�");
define("_MI_MYLINKS_ADMENU3", "������ƥ��");
define("_MI_MYLINKS_ADMENU4", "����ڤ����");
define("_MI_MYLINKS_ADMENU5", "������󥯾���");

// Title of config items
define('_MI_MYLINKS_POPULAR','�ֿ͵���󥯡פˤʤ뤿��Υҥåȿ�');
define('_MI_MYLINKS_NEWLINKS','�ȥåץڡ����Ρֿ����󥯡פ�ɽ��������');
define('_MI_MYLINKS_PERPAGE','���ڡ������ɽ�������󥯤η��');
define('_MI_MYLINKS_USESHOTS','�����꡼�󥷥�åȤ���Ѥ���');
define('_MI_MYLINKS_USEFRAMES','�ե졼�����Ѥ���');
define('_MI_MYLINKS_SHOTWIDTH','�����꡼�󥷥�åȤβ�����');
define('_MI_MYLINKS_ANONPOST','ƿ̾�桼���ˤ���󥯤���Ƥ���Ĥ���');
define('_MI_MYLINKS_AUTOAPPROVE','�����Ԥβ�ߤ��ʤ�������󥯤μ�ư��ǧ');

// Description of each config items
define('_MI_MYLINKS_POPULARDSC', '�ֿ͵����ץ�������ɽ������뤿��Υҥåȿ�����ꤷ�Ƥ���������');
define('_MI_MYLINKS_NEWLINKSDSC', '�ȥåץڡ����Ρֿ����󥯡ץ֥�å���ɽ���������������ꤷ�Ƥ���������');
define('_MI_MYLINKS_PERPAGEDSC', '��󥯰���ɽ���ǣ��ڡ����������ɽ���������������ꤷ�Ƥ���������');
define('_MI_MYLINKS_USEFRAMEDSC', '��󥯥ڡ�����ե졼�����ɽ�����뤫�ɤ���');
define('_MI_MYLINKS_USESHOTSDSC', '��󥯾���˥����꡼�󥷥�åȲ�����ɽ��������ϡ֤Ϥ��פ����򤷤Ƥ���������');
define('_MI_MYLINKS_SHOTWIDTHDSC', '�����꡼�󥷥�åȲ����β����κ����ͤ���ꤷ�Ƥ���������');
define('_MI_MYLINKS_AUTOAPPROVEDSC','�����Ԥξ�ǧ���ʤ��˿��������Ͽ�ξ�ǧ��Ԥ����ϡ֤Ϥ��פ����򤷤Ƥ���������');

// Text for notifications

define('_MI_MYLINKS_GLOBAL_NOTIFY', '�⥸�塼������');
define('_MI_MYLINKS_GLOBAL_NOTIFYDSC', '��󥯽��⥸�塼�����Τˤ��������Υ��ץ����');

define('_MI_MYLINKS_CATEGORY_NOTIFY', 'ɽ����Υ��ƥ���');
define('_MI_MYLINKS_CATEGORY_NOTIFYDSC', 'ɽ����Υ��ƥ�����Ф������Υ��ץ����');

define('_MI_MYLINKS_LINK_NOTIFY', 'ɽ����Υ��');
define('_MI_MYLINKS_LINK_NOTIFYDSC', 'ɽ����Υ�󥯤��Ф������Υ��ץ����');

define('_MI_MYLINKS_GLOBAL_NEWCATEGORY_NOTIFY', '�������ƥ���');
define('_MI_MYLINKS_GLOBAL_NEWCATEGORY_NOTIFYCAP', '�������ƥ��꤬�������줿�������Τ���');
define('_MI_MYLINKS_GLOBAL_NEWCATEGORY_NOTIFYDSC', '�������ƥ��꤬�������줿�������Τ���');
define('_MI_MYLINKS_GLOBAL_NEWCATEGORY_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : �������ƥ��꤬��������ޤ����ʥ�󥯽���');

define('_MI_MYLINKS_GLOBAL_LINKMODIFY_NOTIFY', '��󥯽����Υꥯ������');
define('_MI_MYLINKS_GLOBAL_LINKMODIFY_NOTIFYCAP', '��󥯽����Υꥯ�����Ȥ����ä��������Τ���');
define('_MI_MYLINKS_GLOBAL_LINKMODIFY_NOTIFYDSC', '��󥯽����Υꥯ�����Ȥ����ä��������Τ���');
define('_MI_MYLINKS_GLOBAL_LINKMODIFY_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: ��󥯽����Υꥯ�����Ȥ�����ޤ���');

define('_MI_MYLINKS_GLOBAL_LINKBROKEN_NOTIFY', '����ڤ����');
define('_MI_MYLINKS_GLOBAL_LINKBROKEN_NOTIFYCAP', '����ڤ����𤬤��ä��������Τ���');
define('_MI_MYLINKS_GLOBAL_LINKBROKEN_NOTIFYDSC', '����ڤ����𤬤��ä��������Τ���');
define('_MI_MYLINKS_GLOBAL_LINKBROKEN_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: ����ڤ����𤬤���ޤ���');

define('_MI_MYLINKS_GLOBAL_LINKSUBMIT_NOTIFY', '����������');
define('_MI_MYLINKS_GLOBAL_LINKSUBMIT_NOTIFYCAP', '������󥯤���Ƥ����ä��������Τ���');
define('_MI_MYLINKS_GLOBAL_LINKSUBMIT_NOTIFYDSC', '������󥯤���Ƥ����ä��������Τ���');
define('_MI_MYLINKS_GLOBAL_LINKSUBMIT_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: ������󥯤���Ƥ�����ޤ���');

define('_MI_MYLINKS_GLOBAL_NEWLINK_NOTIFY', '������󥯷Ǻ�');
define('_MI_MYLINKS_GLOBAL_NEWLINK_NOTIFYCAP', '������󥯤��Ǻܤ��줿�������Τ���');
define('_MI_MYLINKS_GLOBAL_NEWLINK_NOTIFYDSC', '������󥯤��Ǻܤ��줿�������Τ���');
define('_MI_MYLINKS_GLOBAL_NEWLINK_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: ������󥯤��Ǻܤ���ޤ���');

define('_MI_MYLINKS_CATEGORY_LINKSUBMIT_NOTIFY', '���������ơ����ꥫ�ƥ����');
define('_MI_MYLINKS_CATEGORY_LINKSUBMIT_NOTIFYCAP', '���Υ��ƥ���ˤ����ƿ�����󥯤���Ƥ��줿�������Τ���');
define('_MI_MYLINKS_CATEGORY_LINKSUBMIT_NOTIFYDSC', '���Υ��ƥ���ˤ����ƿ�����󥯤���Ƥ��줿�������Τ���');
define('_MI_MYLINKS_CATEGORY_LINKSUBMIT_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: ������󥯤���Ƥ�����ޤ���');

define('_MI_MYLINKS_CATEGORY_NEWLINK_NOTIFY', '������󥯷Ǻܡ����ꥫ�ƥ����');
define('_MI_MYLINKS_CATEGORY_NEWLINK_NOTIFYCAP', '���Υ��ƥ���ˤ����ƿ�����󥯤��Ǻܤ��줿�������Τ���');
define('_MI_MYLINKS_CATEGORY_NEWLINK_NOTIFYDSC', '���Υ��ƥ���ˤ����ƿ�����󥯤��Ǻܤ��줿�������Τ���');
define('_MI_MYLINKS_CATEGORY_NEWLINK_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: ������󥯤��Ǻܤ���ޤ���');

define('_MI_MYLINKS_LINK_APPROVE_NOTIFY', '��󥯾�ǧ');
define('_MI_MYLINKS_LINK_APPROVE_NOTIFYCAP', '���Υ�󥯤���ǧ���줿�������Τ���');
define('_MI_MYLINKS_LINK_APPROVE_NOTIFYDSC', '���Υ�󥯤���ǧ���줿�������Τ���');
define('_MI_MYLINKS_LINK_APPROVE_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE}: ��󥯤���ǧ����ޤ���');