Xoops Article Module Clone Guide

http://xoops.org.cn

Author: (phppp or D.J.) <php_pp@hotmail.com>

To make a clone:

Step #1: In the file /include/vars.php£¬reset the value for $GLOBALS["ART_DB_PREFIX"]. You can change the original value "art" to something else you prefer, for instance, "artdb" (this step is required).

Step #2: Edit /sql/mysql.sql, change all table prefixes to the value specified above: in our example--"artdb". For instance, change "CREATE TABLE `art_article`" to "CREATE TABLE `artdb_article`" (this step is required).
         
	Please note: You must leave field names in those tables as they are.

Step #3: Change all name prefixes of template files to the new module dirname, including all templates in /templates/ and /templates/blocks/. For example, change article_index.html to newmodule_index.html (this step is required).

Step #4: Now you can install the cloned module as regular.

If you have further questions, please visit our website for more information. 
