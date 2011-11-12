
<?php

/**
 *    $Id: admin.php,v 1.4 2005/04/08 15:47:29 eric_juden Exp $
 *
 *    Japanese Translation by : Seibu Tsushin KK www.seibu-tsushin.co.jp
 *
 *    Valentin  Nils  <opensource@seibu-tsushin.co.jp>
 *    Mizukoshi Norio <opensource@seibu-tsushin.co.jp>
 *
 */

//Menu choices
define('_AM_XHELP_ADMIN_TITLE', '管理者ﾒﾆｭｰ');
define('_AM_XHELP_BLOCK_TEXT', 'ブロック管理');
define('_AM_XHELP_MENU_MANAGE_DEPARTMENTS', 'カテゴリー管理');
define('_AM_XHELP_MENU_MANAGE_STAFF', 'スタッフ管理');
define('_AM_XHELP_MENU_MODIFY_EMLTPL', 'メール/ﾃﾝﾌﾟﾚｰﾄ修正');
define('_AM_XHELP_MENU_MODIFY_TICKET_FIELDS', ' 質問の修正');
define('_AM_XHELP_MENU_GROUP_PERM', 'ｸﾞﾙｰﾌﾟ許可');
define('_AM_XHELP_MENU_MIMETYPES', 'mimeﾀｲﾌﾟ管理');
define('_AM_XHELP_MENU_PREFERENCES', '優先権');
define('_AM_XHELP_MENU_ADD_STAFF', 'ｽﾀｯﾌ追加');
define('_AM_XHELP_UPDATE_MODULE', '最新ﾓｼﾞｭｰﾙへ');

//Permissions
define('_AM_XHELP_GROUP_PERM', 'ｸﾞﾙｰﾌﾟ許可');
define('_AM_XHELP_GROUP_PERM_TITLE', 'ｸﾞﾙｰﾌﾟ許可を修正');
define('_AM_XHELP_GROUP_PERM_NAME', '許可');
define('_AM_XHELP_GROUP_PERM_DESC', 'ユーザーグループで可能なサービス選んで下さい。');

// Messages
define('_AM_XHELP_MESSAGE_STAFF_UPDATE_ERROR', 'ｴﾗｰ : スタッフの変更できませんでした');
define('_AM_XHELP_MESSAGE_FILE_READONLY', 'このファイルは読み込み専用のため、 modules/xhelp/language/english/mail_templates フォルダーに書きこみ権限を設定して下さい。');
define('_AM_XHELP_MESSAGE_FILE_UPDATED', 'ファイル更新されました');
define('_AM_XHELP_MESSAGE_FILE_UPDATED_ERROR', 'ｴﾗｰ : ファイル更新されませんでした');

// Buttons
define('_AM_XHELP_BUTTON_DELETE', '削除');
define('_AM_XHELP_BUTTON_EDIT', '変更');
define('_AM_XHELP_BUTTON_SUBMIT', '更新');
define('_AM_XHELP_BUTTON_RESET', 'ﾘｾｯﾄ');
define('_AM_XHELP_BUTTON_ADDSTAFF', 'ｽﾀｯﾌ追加');
define('_AM_XHELP_BUTTON_UPDATESTAFF', 'ｽﾀｯﾌの変更');
define('_AM_XHELP_BUTTON_CANCEL', '取り消し');
define('_AM_XHELP_BUTTON_UPDATE', 'ﾓｼﾞｭｰﾙ最新版へ');
//define('_AM_XHELP_BUTTON_ADD_DEPT', 'カテゴリー/追加');

define('_AM_XHELP_EDIT_DEPARTMENT', 'カテゴリーの変更');
define('_AM_XHELP_EXISTING_DEPARTMENTS', '存在カテゴリー:');
define('_AM_XHELP_MANAGE_DEPARTMENTS', 'カテゴリー管理');
define('_AM_XHELP_MANAGE_STAFF', 'ｽﾀｯﾌ管理');
define('_AM_XHELP_EXISTING_STAFF', 'スタッフ既に存在します:');
define('_AM_XHELP_ADD_STAFF', 'スタッフ追加');
define('_AM_XHELP_EDIT_STAFF', 'スタッフの変更');
define('_AM_XHELP_INDEX', 'インデックス');
define('_AM_XHELP_ADMIN_GOTOMODULE', 'ﾓｼﾞｭｰﾙへ行く');

define('_AM_XHELP_TEXT_ADD_DEPT', 'カテゴリー追加:');
define('_AM_XHELP_TEXT_EDIT_DEPT', 'カテゴリー目の変更:');
define('_AM_XHELP_TEXT_EDIT', '編集');
define('_AM_XHELP_TEXT_DELETE', '削除');
define('_AM_XHELP_TEXT_SELECTUSER', 'ﾕｰｻﾞｰ選択:');
define('_AM_XHELP_TEXT_DEPARTMENTS', 'カテゴリー:');
define('_AM_XHELP_TEXT_USER', 'ﾕｰｻﾞｰ:');
define('_AM_XHELP_TEXT_ALL_DEPTS', '全て');
define('_AM_XHELP_TEXT_NO_DEPTS', '無し');
define('_AM_XHELP_TEXT_MAKE_DEPTS', 'スタッフを追加する前にカテゴリーを追加して下さい。');
define('_AM_XHELP_LINK_ADD_DEPT', 'カテゴリー追加');

// Mimetypes
define("_AM_XHELP_MIME_ID", "ID");
define("_AM_XHELP_MIME_EXT", "EXT");
define("_AM_XHELP_MIME_NAME", "適用ﾀｲﾌﾟ");
define("_AM_XHELP_MIME_ADMIN", "管理者");
define("_AM_XHELP_MIME_USER", "ﾕｰｻﾞｰ");
// Mimetype Form
define("_AM_XHELP_MIME_CREATEF", "mimeタイプを作成");
define("_AM_XHELP_MIME_MODIFYF", "mimeタイプを修正");
define("_AM_XHELP_MIME_EXTF", "ファイル拡張 :");
define("_AM_XHELP_MIME_NAMEF", "適用ﾀｲﾌﾟ/名前:<div style='padding-top: 8px;'><span style='font-weight: normal;'>拡張子の適用ﾀｲﾌﾟを選んで下さい。</span></div>");
define("_AM_XHELP_MIME_TYPEF", "拡張子:<div style='padding-top: 8px;'><span style='font-weight: normal;'>拡張子のファイル拡張子を選んで下さい。 Each mimetype must be seperated with a space.</span></div>");
define("_AM_XHELP_MIME_ADMINF", "管理者の許可されたmimeタイプ");
define("_AM_XHELP_MIME_ADMINFINFO", "<b>管理者のアプロードで利用できるmimeタイプ:</b>");
define("_AM_XHELP_MIME_USERF", "ユーザーの許可されたmimeタイプ");
define("_AM_XHELP_MIME_USERFINFO", "<b>ユーザーのアプロードで利用できるmimeタイプ:</b>");
define("_AM_XHELP_MIME_NOMIMEINFO", "mimeタイプは選択されませんでした.");
define("_AM_XHELP_MIME_FINDMIMETYPE", "新mimeタイプの検索:");
define("_AM_XHELP_MIME_EXTFIND", "ファイル拡張の検索:<div style='padding-top: 8px;'><span style='font-weight: normal;'>検索したいファイル拡張を入力して下さい。</span></div>");
define("_AM_XHELP_MIME_INFOTEXT", "<ul><li>このフォームでは新mimeタイプの追加・編集・削除ができます。</li>
    <li>エキスターナルホームページで新mimeタイプを検索する。</li>
    <li>管理者やユーザーアプロードできるのmimeタイプ一覧表。</li>
    <li>mimeタイプのアプロードステータスの変換。</li></ul>
    ");

// Mimetype Buttons
define("_AM_XHELP_MIME_CREATE", "作成");
define("_AM_XHELP_MIME_CLEAR", "ﾘｾｯﾄ");
define("_AM_XHELP_MIME_CANCEL", "取り消し");
define("_AM_XHELP_MIME_MODIFY", "修正");
define("_AM_XHELP_MIME_DELETE", "削除");
define("_AM_XHELP_MIME_FINDIT", "ファイル拡張の検索");
// Mimetype Database
define("_AM_XHELP_MIME_DELETETHIS", "選択されたmimeタイプの削除");
define("_AM_XHELP_MIME_MIMEDELETED", "mimeタイプ %s が削除されました。");
define("_AM_XHELP_MIME_CREATED", "mimeタイプの情報が作成されました");
define("_AM_XHELP_MIME_MODIFIED", "mimeタイプの情報が変更されました");

define("_AM_XHELP_MINDEX_ACTION", "ｱｸｼｮﾝ");
define("_AM_XHELP_MINDEX_PAGE", "<b>ページ:<b> ");

//image admin icon
define("_AM_XHELP_ICO_EDIT","このアイテムを編集します");
define("_AM_XHELP_ICO_DELETE","このアイテムを削除します");
define("_AM_XHELP_ICO_ONLINE","ｵﾌﾗｲﾝ");
define("_AM_XHELP_ICO_OFFLINE","ｵﾌﾗｲﾝ");
define("_AM_XHELP_ICO_APPROVED","承認");
define("_AM_XHELP_ICO_NOTAPPROVED","承認しません");

define("_AM_XHELP_ICO_LINK","関連するﾘﾝｸ");
define("_AM_XHELP_ICO_URL","関連するURLを追加");
define("_AM_XHELP_ICO_ADD","追加");
define("_AM_XHELP_ICO_APPROVE","承認");
define("_AM_XHELP_ICO_STATS","統計");

define("_AM_XHELP_ICO_IGNORE","無視");
define("_AM_XHELP_ICO_ACK","壊れた報告書が認められました");
define("_AM_XHELP_ICO_REPORT","壊れた報告書を認めますか？");
define("_AM_XHELP_ICO_CONFIRM","壊れた報告書が確認されました");
define("_AM_XHELP_ICO_CONBROKEN","壊れた報告書を確認します");

define("_AM_XHELP_UPLOADFILE", "ファイルのアプロードが作成されました");
define('_AM_XHELP_TEXT_TICKET_INFO', ' 質問情報');
define('_AM_XHELP_TEXT_OPEN_TICKETS', 'ｵｰﾌﾟﾝ 質問');
define('_AM_XHELP_TEXT_HOLD_TICKETS', 'ペンティング中の 質問');
define('_AM_XHELP_TEXT_CLOSED_TICKETS', ' 質問の終了');
define('_AM_XHELP_TEXT_TOTAL_TICKETS', ' 質問の合計');

define('_AM_XHELP_TEXT_TEMPLATE_NAME', 'ﾃﾝﾌﾟﾚｰﾄ名:');
define('_AM_XHELP_TEXT_DESCRIPTION', '記述:');
define('_AM_XHELP_TEXT_GENERAL_TAGS', '一般的なタグ');
define('_AM_XHELP_TEXT_GENERAL_TAGS1', 'X_SITEURL - ホームページのURL');
define('_AM_XHELP_TEXT_GENERAL_TAGS2', 'X_SITENAME - ホームページの名前');
define('_AM_XHELP_TEXT_GENERAL_TAGS3', 'X_ADMINMAIL - 管理者のメール');
//define('_AM_XHELP_TEXT_USER_TAGS', 'ユーザはタグを関連づけました:');
//define('_AM_XHELP_TEXT_USER_TAGS1', 'X_UNAME - ユーザー名');
//define('_AM_XHELP_TEXT_USER_TAGS2', 'X_UID - ユーザー id');
//define('_AM_XHELP_TEXT_NOTIFICATION_TAGS', '通知関連のたぐ:');
//define('_AM_XHELP_TEXT_NOTIFICATION_TAGS1', 'X_MODULE - ﾓｼﾞｭｰﾙの名前');
//define('_AM_XHELP_TEXT_NOTIFICATION_TAGS2', 'X_MODULE_URL - ﾓｼﾞｭｰﾙのインテグスぺーじへのリンク');
//define('_AM_XHELP_TEXT_NOTIFICATION_TAGS3', 'X_NOTIFY_EVENT - トリガーされたエベント');
//define('_AM_XHELP_TEXT_NOTIFICATION_TAGS4', 'X_NOTIFY_CATEGORY - エベントのカテゴリ');
//define('_AM_XHELP_TEXT_NOTIFICATION_TAGS5', 'X_UNSUBSCRIBE_URL - ユーザーの通知セットアップページへのリンク');
define('_AM_XHELP_TEXT_TAGS_NO_MODIFY', 'リスト以外のタグを修正しません');

define('_AM_XHELP_TEXT_TOP_CLOSERS', '回答の一番早いオペレーター');
define('_AM_XHELP_TEXT_WORST_CLOSERS', '回答の一番遅いオペレーター');
define('_AM_XHELP_TEXT_HIGH_PRIORITY', '優先度の高い質問を評価する');
define('_AM_XHELP_TEXT_NO_OWNER', '担当者が決まっていません');
define('_AM_XHELP_TEXT_NO_DEPT', 'カテゴリーがありません');
define('_AM_XHELP_TEXT_RESPONSE_TIME', '最短の回答時間');
define('_AM_XHELP_TEXT_RESPONSE_TIME_SLOW', '最長の回答時間');
define('_AM_XHELP_TEXT_GENERAL_TAGS4', 'X_MODULE - モジュールの名前');
define('_AM_XHELP_TEXT_GENERAL_TAGS5', 'X_MODULE_URL - モジュールのインデックス・ページへのリンク');

define('_AM_XHELP_TEXT_PRIORITY', '優先度 ');
define('_AM_XHELP_TEXT_ELAPSED', '経過 :');
define('_AM_XHELP_TEXT_STATUS', 'ステータス :');
define('_AM_XHELP_TEXT_SUBJECT', '題名 :');
define('_AM_XHELP_TEXT_DEPARTMENT', 'カテゴリー :');
define('_AM_XHELP_TEXT_OWNER', '担当者： ');
define('_AM_XHELP_TEXT_LAST_UPDATED', '最終更新日 :');
define('_AM_XHELP_TEXT_LOGGED_BY', 'ユーザー: ');
define('_MI_XHELP_MENU_CHECK_TABLES', 'デーベーステーブルのチェック');
define('_AM_XHELP_CURRENTVER', 'カレントバージョン 0.6');
define('_AM_XHELP_DBVER', 'ﾃﾞｰﾀﾍﾞｰｽバージョン0.6');
define('_AM_XHELP_DB_UPDATE', '最新のモジュールバージョンです');
define('_AM_XHELP_DB_NOUPDATE', '最新のモジュールバージョンに更新してください');

define('_AM_XHELP_MENU_MANAGE_ROLES', 'Manage Roles');

define('_AM_XHELP_TEXT_EXISTING_ROLES', 'Existing Roles');
define('_AM_XHELP_TEXT_NO_ROLES', 'No Roles Found');
define('_AM_XHELP_TEXT_CREATE_ROLE', 'Create New Role');
define('_AM_XHELP_TEXT_NAME', 'Name:');
define('_AM_XHELP_TEXT_PERMISSIONS', 'Permissions:');
define('_AM_XHELP_TEXT_SELECT_ALL', 'Select All');
define('_AM_XHELP_TEXT_EDIT_ROLE', 'Edit Role');
define('_AM_XHELP_TEXT_ROLES', 'Roles:');
define('_AM_XHELP_TEXT_DEPT_PERMS', 'Customize Department Permissions');
define('_AM_XHELP_TEXT_CUSTOMIZE', 'Customize');
define('_AM_XHELP_TEXT_ACTIONS', 'Actions:');
define('_AM_XHELP_TEXT_ID', 'ID:');
define('_AM_XHELP_TEXT_LOOKUP_USER', 'Lookup User');

define('_AM_XHELP_MESSAGE_ROLE_INSERT', 'Role inserted successfully.');
define('_AM_XHELP_MESSAGE_ROLE_INSERT_ERROR', 'Error: role was not created.');
define('_AM_XHELP_MESSAGE_ROLE_DELETE', 'Role deleted successfully.');
define('_AM_XHELP_MESSAGE_ROLE_DELETE_ERROR', 'Error: role was not removed.');
define('_AM_XHELP_MESSAGE_ROLE_UPDATE', 'Role updated successfully.');
define('_AM_XHELP_MESSAGE_ROLE_UPDATE_ERROR', 'Error: role was not updated.');
define('_AM_XHELP_MESSAGE_DEPT_STORE', 'Department permissions stored successfully.');
define('_AM_XHELP_MESSAGE_DEPT_STORE_ERROR', 'Error: department permissions were not stored.');

define('_AM_XHELP_BUTTON_CLEAR_PERMS', 'Clear Permissions');
define('_AM_XHELP_BUTTON_CREATE_ROLE', 'Create New Role');

define('_AM_XHELP_SEC_TICKET_ADD', 0);
define('_AM_XHELP_SEC_TICKET_EDIT', 1);
define('_AM_XHELP_SEC_TICKET_DELETE', 2);
define('_AM_XHELP_SEC_TICKET_OWNERSHIP', 3);
define('_AM_XHELP_SEC_TICKET_STATUS', 4);
define('_AM_XHELP_SEC_TICKET_PRIORITY', 5);
define('_AM_XHELP_SEC_TICKET_LOGUSER', 6);
define('_AM_XHELP_SEC_RESPONSE_ADD', 7);
define('_AM_XHELP_SEC_RESPONSE_EDIT', 8);

define('_AM_XHELP_SEC_TEXT_TICKET_ADD', '質問の追加');
define('_AM_XHELP_SEC_TEXT_TICKET_EDIT', '質問の編集');
define('_AM_XHELP_SEC_TEXT_TICKET_DELETE', '質問の削除');
define('_AM_XHELP_SEC_TEXT_TICKET_OWNERSHIP', '質問の担当者の変更');
define('_AM_XHELP_SEC_TEXT_TICKET_STATUS', '質問の状態の編集');
define('_AM_XHELP_SEC_TEXT_TICKET_PRIORITY', '質問の優先度の編集');
define('_AM_XHELP_SEC_TEXT_TICKET_LOGUSER', '質問するユーザー名');
define('_AM_XHELP_SEC_TEXT_RESPONSE_ADD', '回答の追加');
define('_AM_XHELP_SEC_TEXT_RESPONSE_EDIT', '回答の編集');

define('_AM_XHELP_MSG_UPD_PERMS', 'Staff #%s permissions added for department #%s.');
define('_AM_XHELP_MSG_REMOVE_TABLE', 'Table %s was removed from your database.');
define('_AM_XHELP_MSG_NOT_REMOVE_TABLE', 'Error: table %s was NOT removed from your database.');
define('_AM_XHELP_DEPARTMENT_SERVERS', 'Department Mailbox');
define('_AM_XHELP_DEPARTMENT_SERVERS_EMAIL', 'Email Address');
define('_AM_XHELP_DEPARTMENT_SERVERS_TYPE', 'Mailbox Type');
define('_AM_XHELP_DEPARTMENT_SERVERS_PRIORITY', 'Default Ticket Priority');
define('_AM_XHELP_DEPARTMENT_SERVERS_SERVERNAME', 'Server');
define('_AM_XHELP_DEPARTMENT_SERVERS_PORT', 'Port');
define('_AM_XHELP_DEPARTMENT_SERVERS_ACTION', 'Actions');
define('_AM_XHELP_DEPARTMENT_ADD_SERVER', 'Add Mailbox to monitor');
define('_AM_XHELP_DEPARTMENT_SERVER_USERNAME', 'Username');
define('_AM_XHELP_DEPARTMENT_SERVER_PASSWORD', 'Password');
define('_AM_XHELP_DEPARTMENT_SERVER_EMAILADDRESS', 'Reply-To Email Address');
define('_AM_XHELP_DEPARTMENT_NO_ID', 'Could not find Department ID. Aborting.');
define('_AM_XHELP_DEPARTMENT_SERVER_SAVED', 'Added Mailbox to Department.');
define('_AM_XHELP_DEPARTMENT_SERVER_ERROR', 'Error saving Mailbox to Department.');
define('_AM_XHELP_DEPARTMENT_SERVER_NO_ID', 'Department mailbox was not specified.');
define('_AM_XHELP_DEPARTMENT_SERVER_DELETED', 'Deleted mailbox from Department.');
define('_AM_XHELP_DEPARTMENT_SERVER_DELETE_ERROR', 'Error removing Mailbox from Department.');
define('_AM_XHELP_STAFF_ERROR_DEPTARTMENTS', 'You must assign a user to 1 or more departments before saving');
define('_AM_XHELP_STAFF_ERROR_ROLES', 'You must assign a user to 1 or more roles before saving');
define('_AM_XHELP_MBOX_POP3', 'POP3');
define('_AM_XHELP_MBOX_IMAP', 'IMAP');
define('_AM_XHELP_UPDATE_OK', 'Successfully updated to version %s');
define('_AM_XHELP_UPDATE_ERR', 'Errors updating to version %s');
define('_AM_XHELP_MSG_UPD_PERMS', 'Staff #%s permissions added for department %s.');
define('_AM_XHELP_MSG_REMOVE_TABLE', 'Table %s was removed from your database.');
define('_AM_XHELP_MSG_GLOBAL_PERMS', 'Staff #%s has global permissions.');
define('_AM_XHELP_MSG_NOT_REMOVE_TABLE', 'Error: table %s was NOT removed from your database.');
define('_AM_XHELP_MSG_RENAME_TABLE', 'Table %s was renamed %s.');
define('_AM_XHELP_MSG_RENAME_TABLE_ERR', 'Error: table %s was not renamed.');

define('_AM_XHELP_DB_NEEDUPDATE', '最新のバージョンがあります');
define('_AM_XHELP_UPDATE_NOW', '更新する!');
define('_AM_XHELP_UPDATE_DB', 'データベースを更新中');
define('_AM_XHELP_UPDATE_TO', 'Updating to version %s:');
define('_AM_XHELP_MSG_MODIFYTABLE', 'Modified table %s');
define('_AM_XHELP_MSG_MODIFYTABLE_ERR', 'Error modifying table %s');
define('_AM_XHELP_MSG_ADDTABLE', 'Added table %s');
define('_AM_XHELP_MSG_ADDTABLE_ERR', 'Error adding table %s');
define('_AM_XHELP_MESSAGE_DEF_ROLES', 'Default permission roles were added successfully.');
define('_AM_XHELP_MESSAGE_DEF_ROLES_ERROR', 'Default permission roles were not added.');
define('_AM_XHELP_MSG_UPDATESTAFF', 'Updated staff #%s');
define('_AM_XHELP_MSG_UPDATESTAFF_ERR', 'Error updating staff #%s');

define('_AM_XHELP_TEXT_MAIL_EVENTS', 'Mail Events');
define('_AM_XHELP_TEXT_MAILBOX', 'Mailbox:');
define('_AM_XHELP_TEXT_EVENT_CLASS', 'Event Class:');
define('_AM_XHELP_TEXT_TIME', 'Time:');
define('_AM_XHELP_MAIL_CLASS0', 'Connection');
define('_AM_XHELP_MAIL_CLASS1', 'Parsing');
define('_AM_XHELP_MAIL_CLASS2', 'Storage');
define('_AM_XHELP_MAIL_CLASS3', 'General');
define('_AM_XHELP_NO_EVENTS', 'No Events Found');
define('_AM_XHELP_SEARCH_EVENTS', 'Search Mail Events');
define('_AM_XHELP_BUTTON_SEARCH', 'Search');

define('_AM_XHELP_ADMIN_ABOUT', 'xhelpについて');
define('_AM_XHELP_TEXT_CONTRIB_INFO', '協力者情報');
define('_AM_XHELP_TEXT_DEVELOPERS', '開発者:');
define('_AM_XHELP_TEXT_TRANSLATORS', '翻訳者:');
define('_AM_XHELP_TEXT_TESTERS', 'テスター:');
define('_AM_XHELP_TEXT_DOCUMENTER', '著者:');
define('_AM_XHELP_TEXT_MODULE_DEVELOPMENT', 'モジュール開発情報');
define('_AM_XHELP_TEXT_DEMO_SITE', 'デモサイト:');
define('_AM_XHELP_DEMO_SITE', '3Devのデモサイト');
define('_AM_XHELP_TEXT_OFFICIAL_SITE', '公式サポートサイト:');
define('_AM_XHELP_OFFICIAL_SITE', '3Dev.org');
define('_AM_XHELP_TEXT_REPORT_BUG', 'モジュールのバグレポート:');
define('_AM_XHELP_REPORT_BUG', 'バグ・リポート');
define('_AM_XHELP_TEXT_NEW_FEATURE', 'モジュールの新機能提案');
define('_AM_XHELP_NEW_FEATURE', '新しい機能');
define('_AM_XHELP_TEXT_QUESTIONS', '問い合わせ');
define('_AM_XHELP_QUESTIONS', '開発者に、直接質問をします。（英語でお願い致します)');
define('_AM_XHELP_TEXT_RELEASE_DATE', 'リリース日付:');
define('_AM_XHELP_TEXT_DISCLAIMER', '免責事項');
define('_AM_XHELP_DISCLAIMER', '注意 : このモジュールはまだ開発版ですから、安定版サイトでは使用しないで下さい。開発者は、責任を持ちません。');
define('_AM_XHELP_TEXT_CHANGELOG', '作者のメッセージ');
define('_AM_XHELP_TEXT_EDIT_DEPT_PERMS', 'Department Visibility:');

define('_AM_XHELP_MESSAGE_NO_DEPT', 'Error: no department specified');
define('_AM_XHELP_MSG_DEPT_DEL_CFRM', 'Are you sure you want to delete department #%u?');
define('_AM_XHELP_MSG_STAFF_DEL_CFRM', 'Are you sure you want to remove staff #%u?');

define('_AM_XHELP_SEC_TICKET_MERGE', 9);
define('_AM_XHELP_SEC_TEXT_TICKET_MERGE', 'Merge Tickets');
define('_AM_XHELP_MSG_UPDATE_ROLE', '%s role permissions have been updated.');
define('_AM_XHELP_MSG_UPDATE_ROLE_ERR', 'Error: %s role permissions were not updated.');
define('_AM_XHELP_MSG_DEPT_MBOX_DEL_CFRM', 'Are you sure you want to delete the mailbox %s?');

define('_AM_XHELP_TEXT_ADD_STATUS', 'Add Status');
define('_AM_XHELP_TEXT_STATE', 'State:');
define('_AM_XHELP_MESSAGE_NO_DESC', 'Error: you did not specify a description.');
define('_AM_MESSAGE_ADD_STATUS_ERR', 'Error: status was not added.');
define('_AM_XHELP_TEXT_MANAGE_STATUSES', 'Manage Statuses');
define('_AM_XHELP_TEXT_EDIT_STATUS', 'Edit Status');
define('_AM_MESSAGE_EDIT_STATUS_ERR', 'Error: status was not updated.');
define('_AM_XHELP_DEL_STATUS_ERR', 'Error: status was not deleted.');
define('_AM_XHELP_MSG_ADD_STATUS_ERR', 'Error: status \'%s\' was not added.');
define('_AM_XHELP_MSG_ADD_STATUS', 'Status \'%s\' was added.');
define('_AM_XHELP_MSG_CHANGED_STATUS', 'Tickets updated with new status.');
define('_AM_XHELP_MSG_CHANGED_STATUS_ERR', 'Error: ticket statuses not updated.');

define('_AM_XHELP_TEXT_PATH', 'Path:');
define('_AM_XHELP_PATH_CONFIG', "Module Directory Configuration");
define('_AM_XHELP_PATH_TICKETATTACH', 'Ticket Attachments');
define('_AM_XHELP_PATH_EMAILTPL', 'Email Templates');
define('_AM_XHELP_TEXT_CREATETHEDIR', 'Create the folder');
define('_AM_XHELP_TEXT_SETPERM', 'Set Permissions');
define('_AM_XHELP_PATH_AVAILABLE', "<span style='font-weight: bold; color: green;'>Available</span>");
define('_AM_XHELP_PATH_NOTAVAILABLE', "<span style='font-weight: bold; color: red;'>Not available</span>");
define('_AM_XHELP_PATH_NOTWRITABLE', "<span style='font-weight: bold; color: red;'>Not writable</span>");
define('_AM_XHELP_PATH_CREATED', "Folder successfully created");
define('_AM_XHELP_PATH_NOTCREATED', "The folder could not be created");

define('_AM_XHELP_TEXT_CODE', 'Patches:');
define('_AM_XHELP_POSITION', 'Position');
define('_AM_XHELP_SEARCH_BEGINEGINDATE', 'Begin Date:');
define('_AM_XHELP_SEARCH_ENDDATE', 'End Date:');

define('_AM_XHELP_SEC_FILE_DELETE', 10);
define('_AM_XHELP_SEC_TEXT_FILE_DELETE', 'Delete File Attachments');
define('_AM_XHELP_TEXT_MANAGE_FILES', 'Manage Files');
define('_AM_XHELP_TEXT_TICKETID', 'Ticket ID:');
define('_AM_XHELP_TEXT_FILENAME', 'Filename:');
define('_AM_XHELP_TEXT_MIMETYPE', 'Mimetype:');

define('_AM_XHELP_TEXT_TOTAL_USED_SPACE', 'Total Used Space');
define('_AM_XHELP_TEXT_SIZE', 'Size:');
define('_AM_XHELP_MSG_DELETE_RESOLVED', 'Are you sure you want to remove resolved ticket attachments?');
define('_AM_XHELP_TEXT_DELETE_RESOLVED', 'Delete attachments from resolved tickets?');
define('_AM_XHELP_TEXT_NO_FILES', 'No Files Found');
define('_AM_XHELP_TEXT_RESOLVED_ATTACH', 'Resolved Attachments:');
define('_AM_XHELP_TEXT_ALL_ATTACH', 'All Attachments:');

define('_AM_XHELP_MESSAGE_ACTIVATE', 'Make Active');
define('_AM_XHELP_MESSAGE_DEACTIVATE', 'Make In-Active');
define('_AM_XHELP_BUTTON_TEST', 'Test');

define('_AM_XHELP_MSG_DELETE_FILE', 'Are you sure you want to remove this attachment?');
define('_AM_XHELP_TEXT_BY', 'By');

define('_AM_XHELP_TEXT_ACTIVE', 'Active');
define('_AM_XHELP_TEXT_INACTIVE', 'In-Active');
define('_AM_XHELP_TEXT_ACTIVITY', 'Activity');
define('_AM_XHELP_DEPARTMENT_EDIT_SERVER', 'Update Department Mailbox');

define('_AM_XHELP_MSG_ADD_CONFIG_ERR', 'Error: configuration value for department was not saved');
define('_AM_XHELP_MSG_UPDATE_CONFIG_ERR', 'Error: configuration value for department was not updated');

define('_AM_XHELP_TEXT_CONTROLTYPE', 'Control Type');
define('_AM_XHELP_TEXT_REQUIRED', 'Required');
define('_AM_XHELP_TEXT_MANAGE_FIELDS', 'Manage Custom Fields');

define('_AM_XHELP_TEXT_MAINTENANCE', 'Maintenance Tasks');
define('_AM_XHELP_TEXT_ORPHANED', 'Remove orphaned staff records from xhelp_staff table?');
define('_AM_XHELP_MSG_CLEAR_ORPHANED_ERR', 'Your staff records are up to date.');

define('_AM_XHELP_TEXT_DELETE_STAFF_DEPT', 'Remove staff from department');
define('_AM_XHELP_MSG_NO_DEPTID', 'Error: no department id was specified.');
define('_AM_XHELP_MSG_NO_UID', 'Error: no user was specified.');
define('_AM_XHELP_MSG_REMOVE_STAFF_DEPT_ERR', 'Error: staff was not removed from department.');

define('_AM_XHELP_MESSAGE_ACTIVATE', 'Toggle Active');
define('_AM_XHELP_MESSAGE_DEACTIVATE', 'Toggle Inactive');

define('_AM_XHELP_ADD_FIELD', 'Add Custom Field');
define('_AM_XHELP_TEXT_FIELDNAME', 'Field Name:');
define('_AM_XHELP_TEXT_CONTROLTYPE', 'Control Type:');
define('_AM_XHELP_TEXT_REQUIRED', 'Required:');
define('_AM_XHELP_TEXT_REQUIRED_DESC', 'Should this field be required during ticket addition?');
define('_AM_XHELP_TEXT_DATATYPE', 'Data type:');
define('_AM_XHELP_TEXT_WEIGHT', 'Weight:');
define('_AM_XHELP_TEXT_FIELDVALUES', 'Field Value List:');
define('_AM_XHELP_TEXT_FIELDVALUES_DESC', '*** Placeholder: need description text');
define('_AM_XHELP_TEXT_DEFAULTVALUE', 'Default Value:');
define('_AM_XHELP_TEXT_LENGTH', 'Length:');

define('_AM_XHELP_MSG_FIELD_DEL_CFRM', 'Are you sure you want to remove field #%u?');
define('_XHELP_MESSAGE_DELETE_SEARCH_ERR', 'Error: search was not deleted.');

define('_AM_XHELP_MESSAGE_NO_ID', 'Error: id was not specified.');
define('_AM_XHELP_MESSAGE_NO_VALUE', 'Error: the mimetype value was not specified.');
define('_AM_XHELP_MESSAGE_EDIT_MIME_ERROR', 'Error: the mimetype was not updated.');
define('_AM_XHELP_MESSAGE_DELETE_MIME_ERROR', 'Error: the mimetype was not deleted.');
define('_AM_XHELP_MESSAGE_ADD_MIME_ERROR', 'Error: the mimetype was not added.');
define('_AM_XHELP_TEXT_ASCENDING', 'Ascending');
define('_AM_XHELP_TEXT_DESCENDING', 'Descending');
define('_AM_XHELP_TEXT_SORT_BY', 'Sort By:');
define('_AM_XHELP_TEXT_ORDER_BY', 'Order By:');
define('_AM_XHELP_TEXT_NUMBER_PER_PAGE', 'Number Per Page:');
define('_AM_XHELP_TEXT_SEARCH_MIME', 'Search Mimetypes');
define('_AM_XHELP_TEXT_SEARCH_BY', 'Search By:');
define('_AM_XHELP_TEXT_NO_RECORDS', 'No Records Found');
define('_AM_XHELP_TEXT_GO_BACK_SEARCH', 'Back to Search');
define('_AM_XHELP_TEXT_SEARCH_TEXT', 'Search Text:');

define('_AM_XHELP_EDIT_FIELD', 'Modify Custom Field');
define('_AM_XHELP_TEXT_VALIDATION', 'Validation:');
define('_AM_XHELP_TEXT_REGEX_CUSTOM', 'Custom');
define('_AM_XHELP_TEXT_REGEX_USPHONE', 'Phone Number');
define('_AM_XHELP_TEXT_REGEX_USZIP', 'US Zip + 4');
define('_AM_XHELP_TEXT_REGEX_EMAIL', 'Email Address');

define('_AM_XHELP_VALID_ERR_CONTROLTYPE', 'Invalid Control Type Selected.');
define('_AM_XHELP_TEXT_SESSION_RESET', 'Clear errors');
define('_AM_XHELP_VALID_ERR_NAME', 'Name not set');
define('_AM_XHELP_VALID_ERR_FIELDNAME', 'Fieldname not set');
define('_AM_XHELP_VALID_ERR_FIELDNAME_UNIQUE', 'Fieldname must be unique');
define('_AM_XHELP_VALID_ERR_LENGTH', 'Length should be a number value between %u and %u');
define('_AM_XHELP_VALID_ERR_DEFAULTVALUE', 'Default value must be in option list');
define('_AM_XHELP_VALID_ERR_VALUE_LENGTH', 'Value "%s" is greater than the field length, %u characters');
define('_AM_XHELP_VALID_ERR_VALUE', 'You must supply a value set for this field');
define('_AM_XHELP_MSG_FIELD_ADD_OK', 'Field added successfully');
define('_AM_XHELP_MSG_FIELD_ADD_ERR', 'Errors occurred while adding the field');
define('_AM_XHELP_MSG_FIELD_UPD_OK', 'Field updated successfully');
define('_AM_XHELP_MSG_FIELD_UPD_ERR', 'Errors occurred while updating the field');
define('_AM_XHELP_MSG_SUBMISSION_ERR', 'Your submission has errors. Please fix and submit again');

define('_AM_XHELP_TEXT_DEFAULT_STATUS', 'Default Status');
define('_AM_XHELP_VALID_ERR_MIME_EXT', 'File extension not set');
define('_AM_XHELP_VALID_ERR_MIME_NAME', 'Application Type/Name not set');
define('_AM_XHELP_VALID_ERR_MIME_TYPES', 'Mime types not set');

define('_AM_XHELP_TEXT_MANAGE_NOTIFICATIONS', 'Manage Notifications');
define('_AM_XHELP_TEXT_NOTIF_NAME', 'Notification Name');
define('_AM_XHELP_TEXT_SUBSCRIBED_MEMBERS', 'Subscribed Members');
define('_AM_XHELP_STAFF_SETTING1', 'All Staff');
define('_AM_XHELP_STAFF_SETTING2', 'Department Staff');
define('_AM_XHELP_STAFF_SETTING3', 'Ticket Owner');
define('_AM_XHELP_STAFF_SETTING4', 'Notification Off');
define('_AM_XHELP_USER_SETTING1', 'Notification On');
define('_AM_XHELP_USER_SETTING2', 'Notification Off');
define('_AM_XHELP_TEXT_SUBMITTER', 'Submitter');
define('_AM_XHELP_TEXT_NOTIF_STAFF', 'Staff Notification');
define('_AM_XHELP_TEXT_NOTIF_USER', 'User Notification');
define('_AM_XHELP_TEXT_ASSOC_TPL', 'Associated Templates');
?>