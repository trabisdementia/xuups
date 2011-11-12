Article模块复制指南：

作者：(phppp or D.J.) <php_pp@hotmail.com>
http://xoops.org.cn

复制步骤如下：

第一步： 修改/include/vars.php中, $GLOBALS["ART_DB_PREFIX"] 的值： 比如, 把原来的值"art"改为新的"artdb" (必要步骤)。

第二步： 编辑 /sql/mysql.sql, 将所有的数据表的前缀都改为上面制定的值 "artdb". 例如, 把 "CREATE TABLE `art_article`" 改为 "CREATE TABLE `artdb_article`" (必要步骤)。 请注意： 除数据表名称以外，数据表中的字段名称务必保持不变。

第三步： 把所有template文件名的前缀都改为新的模块名称, 包括 /templates/ 和 /templates/blocks/ 目录下面的所有template文件。例如, 把 article_index.html 改为 newmodule_index.html (必要步骤)。

第四步： 正常上传安装复制后的模块。


