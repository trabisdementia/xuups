
xlanguage, eXtensible Xoops Multilingual Content and Encoding Management
===========================================================================================================

xlanguage ��XOOPSϵͳ�Ķ��������ݺͱ������������������XOOPS 2.3+ ������
��Ҫ���ܺ����˶����������л���ͳһ���ֲ�ͬ�����ת��

 
��Ӧ�汾
---------
����������XOOPS�汾������ģ�顢���з��


�������
-----------
1 ����Ҫ����ֻ���� common.php �����һ�д��벢��װ "xlanguage"
2 ����Ҫ�޸�XOOPS���Ĵ����ģ��


Powerful enough to meet your requirements
-----------------------------------------
1 Could handle as many languages of content as you want
2 Could handle different charset of a selected language
3 Could handle multilingual content anywhere on your site, in a module, a php file, an html page or a theme's hardcoded content
4 Compatible with content cache
5 Automatic detection of user browser's language preference


ʹ��ָ��
----------
1 ��������ʽ�Ͳ��谲װ "xlanguage"

2 ��XOOPS/include/common.php�в���һ��
		include_once XOOPS_ROOT_PATH.'/modules/xlanguage/api.php';
	λ������������֮ǰ 
	    // #################### Include site-wide lang file ##################
	    if ( file_exists(XOOPS_ROOT_PATH."/language/".$xoopsConfig['language']."/global.php") ) {
	        include_once XOOPS_ROOT_PATH."/language/".$xoopsConfig['language']."/global.php";
	    } else {
	        include_once XOOPS_ROOT_PATH."/language/english/global.php";
	    }
 
3 �޸� language/schinese/global.php (����Ƿ������ģ����Ӧ�޸�language/tchinese/global.php)
	//%%%%%		LANGUAGE SPECIFIC SETTINGS   %%%%%
	//define('_CHARSET', 'GB2312');
	//define('_LANGCODE', 'zh-CN');
	define('_CHARSET', empty($xlanguage["charset"])?'GB2312':$xlanguage["charset"]);
	define('_LANGCODE', empty($xlanguage["code"])?'zh-CN':$xlanguage["code"]);
	$xlanguage['charset_base'] = "gb2312";
     
4 ѡ���������� (�ӿ�ѡ�б���ѡ��)�������չ���� (�����������Ϊ�������ģ��뽫���������еļ���/���塢schinese/tchinese��gb2312/big5��zh-CN/zh-TW�Ե�)
	���磬���Ҫ�����¼�������(�����)֮���л�: Ӣ��, ��������(gb2312), ��������(big5) �� UTF-8 ����
	����Ҫѡ����������(��Ҫȷ�����XOOPS�Ѿ���english��schinese�������԰�):
	1: 	����: english; 		����(��ѡ): Ӣ��; 			����: iso-8859-1; 	���Դ���: en (�������κ���ĸ���� "xen", ���������������Դ���, ֻ�������Ӣ�Ĳ��ֵ�����)
	2: 	����: schinese; 	����(��ѡ): ��������; 		����: gb2312; 		���Դ���: zh (�������κ���ĸ���� "sc", ���������������Դ���, ֻ����������Ĳ��ֵ�����)
	Ȼ����ӻ��ڼ������ĵ���չ����(�������к����ݻ��Զ��Ӽ�������ת��):
	1: 	����: tchinese; 	����(��ѡ): ��������; 		����: big5; 		���Դ���: zh-TW (�������ĵ����������Դ���)
	2: 	����: utf8; 		����(��ѡ): UTF8����; 		����: utf-8 ; 		���Դ���: zh-CN (�������ĵ����������Դ���)

5 ����������ڽ�"����ѡ��"��������Ϊ�ɼ�

6 �����ģ�������л���ģ��/�������Ӷ��������ݣ�ʹ�ò���4�ж�������Դ��뽫��Ӧ���ݰ����� [����㲻ʹ�ö����������л�������ֻ���ڷ�������Զ�ת������������һ��]: 
	[langcode1]Content of the language1[/langcode1] [langcode2]Content of the language2[/langcode2] [langcode3]Content of the language3[/langcode3] ...
	���ĳЩ����Ϊ�����������Թ���, �����ʹ�÷ָ���"|"�����干�������:	
	[langcode1|langcode2]Content shared by language1&2[/langcode1|langcode2] [langcode3]Content of the language3[/langcode3] ...
	
	ʵ������ (�ٶ�����4���趨�����Դ���ֱ���: Ӣ��-en; ����-fr; ��������-sc):
	[en]My XOOPS[/en][fr]Moi XOOPS[/fr][sc]�ҵ�XOOPS[/sc]
	��:
	[english|french]This is my content in English and French[/english|french][schinese]��������[/schinese]

7 xlanguage���Զ��������ڸ���չ����֮��ת�� [ʵ��������һ���㲻��Ҫ�κβ���]

8 ��ȥ����ѡ��ģ��֮�⣬��������ڷ�����ģ������������л���ָ��:
	1) �޸� /modules/xlanguage/api.php "$xlanguage_theme_enable = true;"
	2) �趨���� "$options = array("images", " ", 5); // ��ʾģʽ, �ָ���, ÿһ����Ŀ";
	3) �� "<{$smarty.const.XLANGUAGE_SWITCH_CODE}>" ���뵽��ķ�����ģ������Ҫ��ʾ�ĵط���

	
	
xlangauge description
-------------------------
An eXtensible Multi-language content and character encoding Management plugin
Multilanguage management handles displaying contents of different languages, like English, French and Chinese
Character encoding management handles contents of different encoding sets for one language, like GB2312 (Chinese Simplified) and BIG5 (Chinese Traditional) for Chinese. 


What xlanguage CAN do
---------------------
1 displaying content of specified language based on user's dynamic choice
2 converting content from one character encoding set to another


What xlanguage canNOT do
------------------------
1 xlanguage does NOT have the ability of translating content from one language to another one. You have to input contents of various languages by yourself
2 xlanguage does NOT work without adding one line to XOOPS/include/common.php (see guide below)
3 xlanguage does NOT have the ability of converting content from one character encoding to another if none of "iconv", "mb_string" or "xconv" is available. 


Features
--------
1 auto-detection of visitor's language on his first visitor
2 memorizing users' langauge preferences
3 switching contents of different languges/encoding sets on-fly
4 supporting M-S-M mode for character encoding handler

Note:
M-S-M: Multiple encoding input, Single encoding storage, Multiple encoding output.
M-S-M allows one site to fit various users with different language character encoding usages. For example, a site having xlanguage implemented porperly allows users to input content either with GB2312, with BIG5 or UTF-8 encoding and to store the content into DB with specified encoding, for say GB2312, and to display the content either with GB2312, with BIG5 or with UTF-8 encoding.


Changelog
---------

xlanguage 3.0 changelog:
1 compatable for all Xoops active versions
2 added smarty template for block
3 added inline scripts for displaying language switch manner anywhere prefered

xlanguage 2.04 changelog:
capable for different language cache, reported by suico @ xoops.org

xlanguage 2.03 changelog:
"input" parse improvement, reported by irmtfan @ xoops.org

xlanguage 2.02 bugfix for XSS vulnerability
Thanks domifara @ dev.xoops.org

xlanguage 2.01 bugfix for nonexisting language



Credits
-------
1 Adi Chiributa - webmaster@artistic.ro, language handler
2 wjue - http://www.wjue.org, ziling BIG5-GB2312 conversion
3 GIJOE - http://www.peak.ne.jp, easiest multilanguage hack

Author
------
D.J. (phppp)
http://xoops.org.cn
http://xoopsforge.com