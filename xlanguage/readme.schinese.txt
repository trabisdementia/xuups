
xlanguage, eXtensible Xoops Multilingual Content and Encoding Management
===========================================================================================================

xlanguage 是XOOPS系统的多语言内容和编码管理插件，将集成在XOOPS 2.3+ 核心中
主要功能涵盖了多语种内容切换和统一语种不同编码的转换

 
适应版本
---------
适用于所有XOOPS版本、所有模块、所有风格


简便易用
-----------
1 所需要做的只是在 common.php 中添加一行代码并安装 "xlanguage"
2 不需要修改XOOPS核心代码和模块


Powerful enough to meet your requirements
-----------------------------------------
1 Could handle as many languages of content as you want
2 Could handle different charset of a selected language
3 Could handle multilingual content anywhere on your site, in a module, a php file, an html page or a theme's hardcoded content
4 Compatible with content cache
5 Automatic detection of user browser's language preference


使用指南
----------
1 按正常方式和步骤安装 "xlanguage"

2 在XOOPS/include/common.php中插入一行
		include_once XOOPS_ROOT_PATH.'/modules/xlanguage/api.php';
	位置在下列内容之前 
	    // #################### Include site-wide lang file ##################
	    if ( file_exists(XOOPS_ROOT_PATH."/language/".$xoopsConfig['language']."/global.php") ) {
	        include_once XOOPS_ROOT_PATH."/language/".$xoopsConfig['language']."/global.php";
	    } else {
	        include_once XOOPS_ROOT_PATH."/language/english/global.php";
	    }
 
3 修改 language/schinese/global.php (如果是繁体中文，请对应修改language/tchinese/global.php)
	//%%%%%		LANGUAGE SPECIFIC SETTINGS   %%%%%
	//define('_CHARSET', 'GB2312');
	//define('_LANGCODE', 'zh-CN');
	define('_CHARSET', empty($xlanguage["charset"])?'GB2312':$xlanguage["charset"]);
	define('_LANGCODE', empty($xlanguage["code"])?'zh-CN':$xlanguage["code"]);
	$xlanguage['charset_base'] = "gb2312";
     
4 选定基本语言 (从可选列表中选择)并添加扩展语言 (如果基本语言为繁体中文，请将下列内容中的简体/繁体、schinese/tchinese、gb2312/big5、zh-CN/zh-TW对调)
	比如，如果要在以下几种语言(或编码)之间切换: 英语, 简体中文(gb2312), 繁体中文(big5) 和 UTF-8 中文
	则需要选定基本语言(需要确定你的XOOPS已经有english和schinese两个语言包):
	1: 	名称: english; 		描述(可选): 英语; 			编码: iso-8859-1; 	语言代码: en (或其他任何字母比如 "xen", 并不是真正的语言代码, 只用来标记英文部分的内容)
	2: 	名称: schinese; 	描述(可选): 简体中文; 		编码: gb2312; 		语言代码: zh (或其他任何字母比如 "sc", 并不是真正的语言代码, 只用来标记中文部分的内容)
	然后添加基于简体中文的扩展语言(将会运行后内容会自动从简体中文转换):
	1: 	名称: tchinese; 	描述(可选): 繁体中文; 		编码: big5; 		语言代码: zh-TW (繁体中文的真正的语言代码)
	2: 	名称: utf8; 		描述(可选): UTF8中文; 		编码: utf-8 ; 		语言代码: zh-CN (简体中文的真正的语言代码)

5 在区块管理内将"语言选择"区块设置为可见

6 在你的模块内容中或是模板/风格中添加多语言内容，使用步骤4中定义的语言代码将相应内容包起来 [如果你不使用多语言内容切换，而是只用于繁体简体自动转换，则跳过这一步]: 
	[langcode1]Content of the language1[/langcode1] [langcode2]Content of the language2[/langcode2] [langcode3]Content of the language3[/langcode3] ...
	如果某些内容为两种以上语言共有, 你可以使用分隔符"|"来定义共享的内容:	
	[langcode1|langcode2]Content shared by language1&2[/langcode1|langcode2] [langcode3]Content of the language3[/langcode3] ...
	
	实际例子 (假定步骤4中设定的语言代码分别是: 英语-en; 法语-fr; 简体中文-sc):
	[en]My XOOPS[/en][fr]Moi XOOPS[/fr][sc]我的XOOPS[/sc]
	或:
	[english|french]This is my content in English and French[/english|french][schinese]中文内容[/schinese]

7 xlanguage将自动将内容在各扩展语言之间转换 [实际上在这一步你不需要任何操作]

8 除去语言选择模块之外，如果你想在风格或是模板中添加语言切换的指令:
	1) 修改 /modules/xlanguage/api.php "$xlanguage_theme_enable = true;"
	2) 设定参数 "$options = array("images", " ", 5); // 显示模式, 分隔符, 每一行数目";
	3) 将 "<{$smarty.const.XLANGUAGE_SWITCH_CODE}>" 插入到你的风格或是模板中需要显示的地方。

	
	
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