<?php

/**
 *    $Id: modinfo.php,v 1.4 2005/04/08 15:47:29 eric_juden Exp $
 *
 *    Japanese Translation by : Seibu Tsushin KK www.seibu-tsushin.co.jp
 *
 *    Valentin  Nils  <opensource@seibu-tsushin.co.jp>
 *    Mizukoshi Norio <opensource@seibu-tsushin.co.jp>
 *
 */

define('_MI_XHELP_NAME', 'Xhelp');
define('_MI_XHELP_DESC', 'クライアント　質問に対する回答');

//Template variables
define('_MI_XHELP_TEMP_ADDTICKET', 'addTicket.phpのﾃﾝﾌﾟﾚｰﾄ');
define('_MI_XHELP_TEMP_SEARCH', 'search.phpのﾃﾝﾌﾟﾚｰﾄ');
define('_MI_XHELP_TEMP_STAFF_INDEX', 'index.phpのスタッフﾃﾝﾌﾟﾚｰﾄ');
//define('_MI_XHELP_TEMP_REPLIES', 'replies.phpのﾃﾝﾌﾟﾚｰﾄ');
define('_MI_XHELP_TEMP_STAFF_PROFILE', 'profile.phpのﾃﾝﾌﾟﾚｰﾄ');
define('_MI_XHELP_TEMP_STAFF_TICKETDETAILS', 'ticket.phpのスタッフﾃﾝﾌﾟﾚｰﾄ');
define('_MI_XHELP_TEMP_USER_INDEX', 'index.phpのユーザーﾃﾝﾌﾟﾚｰﾄ');
define('_MI_XHELP_TEMP_USER_TICKETDETAILS', 'ticket.phpのユーザーﾃﾝﾌﾟﾚｰﾄ');
define('_MI_XHELP_TEMP_STAFF_RESPONSE', 'response.phpのﾃﾝﾌﾟﾚｰﾄ');
define('_MI_XHELP_TEMP_LOOKUP', 'lookup.phpのﾃﾝﾌﾟﾚｰﾄ');
define('_MI_XHELP_TEMP_STAFFREVIEW', 'ユーザーのスタッフ評価ﾃﾝﾌﾟﾚｰﾄ');
define('_MI_XHELP_TEMP_EDITTICKET', '質問編集のﾃﾝﾌﾟﾚｰﾄ');
define('_MI_XHELP_TEMP_EDITRESPONSE', '答え編集のﾃﾝﾌﾟﾚｰﾄ');
define('_MI_XHELP_TEMP_ANNOUNCEMENT', '発表用ﾃﾝﾌﾟﾚｰﾄ');
define('_MI_XHELP_TEMP_STAFF_HEADER', 'ｽﾀｯﾌ・ﾒﾆｭｰ・ｵﾌﾟｼｮﾝ用ﾃﾝﾌﾟﾚｰﾄ');
define('_MI_XHELP_TEMP_USER_HEADER', 'ﾕｰｻﾞｰ・ﾒﾆｭｰ・ｵﾌﾟｼｮﾝ用ﾃﾝﾌﾟﾚｰﾄ');
define('_MI_XHELP_TEMP_PRINT', 'ﾌﾟﾘﾝﾀにやさしい質問ﾍﾟｰｼﾞのﾃﾝﾌﾟﾚｰﾄ');

// Block variables
define('_MI_XHELP_BNAME1', '私の質問');
define('_MI_XHELP_BNAME1_DESC', 'ユーザー・質問一覧表');
define('_MI_XHELP_BNAME2', 'カテゴリー質問');
define('_MI_XHELP_BNAME2_DESC', 'カテゴリー・質問一覧表。');
define('_MI_XHELP_BNAME3', '最近見られた質問');
define('_MI_XHELP_BNAME3_DESC', 'スタッフのた質問チェック履歴。');

// Config variables
define('_MI_XHELP_TITLE', 'ﾍﾙﾌﾟﾃﾞｽｸ ﾀｲﾄﾙ');
define('_MI_XHELP_TITLE_DSC', 'あなたのﾍﾙﾌﾟﾃﾞｽｸに名前を与えます:');
define('_MI_XHELP_UPLOAD', 'ｱｯﾌﾟﾛｰﾄﾞ・ﾃﾞｨﾚｸﾄﾘｰ');
define('_MI_XHELP_UPLOAD_DSC', '添付ファイルのパスは。。。になります');
define('_MI_XHELP_ALLOW_UPLOAD', 'ｱｯﾌﾟﾛｰﾄﾞを許可します');
define('_MI_XHELP_ALLOW_UPLOAD_DSC', '質問に添付ファイルを許可しますか?');
define('_MI_XHELP_UPLOAD_SIZE', 'ｱｯﾌﾟﾛｰﾄﾞ・ｻｲｽﾞ制限');
define('_MI_XHELP_UPLOAD_SIZE_DSC', 'ｱｯﾌﾟﾛｰﾄﾞのﾏｯｸｽｻｲｽﾞ( ﾊﾞｲﾄ )');
define('_MI_XHELP_UPLOAD_WIDTH', 'ｱｯﾌﾟﾛｰﾄﾞ・幅制限');
define('_MI_XHELP_UPLOAD_WIDTH_DSC', 'ｱｯﾌﾟﾛｰﾄﾞ・幅制限 (ピクセル)');
define('_MI_XHELP_UPLOAD_HEIGHT', 'ｱｯﾌﾟﾛｰﾄﾞ・高さ制限');
define('_MI_XHELP_UPLOAD_HEIGHT_DSC', 'ｱｯﾌﾟﾛｰﾄﾞ・高さ制限 (ピクセル)');
define('_MI_XHELP_ANNOUNCEMENTS', '発表ﾆｭｰｽ・ﾄﾋﾟｯｸ');
define('_MI_XHELP_ANNOUNCEMENTS_DSC', "xhelpのニュース・トピックスを更新するためには、<a href='javascript:openWithSelfMain(\"" . XOOPS_URL . "/modules/xhelp/install.php?op=updateTopics\", \"xoops_module_install_xhelp\",400, 300);'>ここをクリックしてください</a>。");

define('_MI_XHELP_ANNOUNCEMENTS_NONE', '***アナウンスを無効する***');
define('_MI_XHELP_ALLOW_REOPEN', '質問の再開許可');
define('_MI_XHELP_ALLOW_REOPEN_DSC', 'それが閉じられた後、ﾕｰｻﾞが再度質問を開くことを可能にしますか?');
define('_MI_XHELP_STAFF_TC', 'ｽﾀｯﾌ・ｲﾝﾃﾞｯｸｽ 質問計算');
define('_MI_XHELP_STAFF_TC_DSC', '何枚の切符を、スタッフ・インデックス・ページの各セクションのために表示しなければなりませんか。');

// Admin Menu variables
define('_MI_XHELP_MENU_BLOCKS', 'ブロック管理');
define('_MI_XHELP_MENU_MANAGE_DEPARTMENTS', 'カテゴリー管理');
define('_MI_XHELP_MENU_MANAGE_STAFF', 'スタッフ管理');
define('_MI_XHELP_MENU_MODIFY_EMLTPL', '電子ﾒｰﾙﾃﾝﾌﾟﾚｰﾄを修正します');
define('_MI_XHELP_MENU_MODIFY_TICKET_FIELDS', '質問フィールドを修正します');
define('_MI_XHELP_MENU_GROUP_PERM', 'グループ許可');
define('_MI_XHELP_MENU_ADD_STAFF', 'ｽﾀｯﾌ追加');
define('_MI_XHELP_MENU_MIMETYPES', 'Mimetype管理');

//NOTIFICATION vars
define('_MI_XHELP_DEPT_NOTIFY', 'カテゴリー名');
define('_MI_XHELP_DEPT_NOTIFYDSC', 'あるカテゴリーに当てはまる通知オプション');

define('_MI_XHELP_TICKET_NOTIFY', '質問');
define('_MI_XHELP_TICKET_NOTIFYDSC', '現在の質問に当てはまる通知オプション');

define('_MI_XHELP_Y', 'カテゴリー: 新質問');
define('_MI_XHELP_DEPT_NEWTICKET_NOTIFY', 'スタッフ: 質問の追加');
define('_MI_XHELP_DEPT_NEWTICKET_NOTIFYCAP', '新しい質問がいつ作成されるか私に通知します。');
define('_MI_XHELP_DEPT_NEWTICKET_NOTIFYDSC', '新しい質問が作成される場合、通知を受け取ります。');
define('_MI_XHELP_DEPT_NEWTICKET_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} 質問が追加されました');
define('_MI_XHELP_DEPT_NEWTICKET_NOTIFYTPL', 'dept_newticket_notify.tpl');

define('_MI_XHELP_DEPT_REMOVEDTICKET_NOTIFY', 'スタッフ: 質問削除');
define('_MI_XHELP_DEPT_REMOVEDTICKET_NOTIFYCAP', '切符がいつ削除されるか私に通知します。');
define('_MI_XHELP_DEPT_REMOVEDTICKET_NOTIFYDSC', '質問が削除される場合、通知を受け取ります。');
define('_MI_XHELP_DEPT_REMOVEDTICKET_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} 質問が削除されました');
define('_MI_XHELP_DEPT_REMOVEDTICKET_NOTIFYTPL', 'dept_removedticket_notify.tpl');

define('_MI_XHELP_DEPT_MODIFIEDTICKET_NOTIFY', 'スタッフ: 質問の変更');
define('_MI_XHELP_DEPT_MODIFIEDTICKET_NOTIFYCAP', '新しい回答がいつ作成されるか私に通知します。');
define('_MI_XHELP_DEPT_MODIFIEDTICKET_NOTIFYDSC', '回答が作成される場合、通知を受け取ります。');
define('_MI_XHELP_DEPT_MODIFIEDTICKET_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} 質問が変更されました');
define('_MI_XHELP_DEPT_MODIFIEDTICKET_NOTIFYTPL', 'dept_modifiedticket_notify.tpl');

define('_MI_XHELP_DEPT_NEWRESPONSE_NOTIFY', 'スタッフ: 新回答');
define('_MI_XHELP_DEPT_NEWRESPONSE_NOTIFYCAP', '新しい回答がいつ作成されるか私に通知します。');
define('_MI_XHELP_DEPT_NEWRESPONSE_NOTIFYDSC', '回答が作成される場合、通知を受け取ります。');
define('_MI_XHELP_DEPT_NEWRESPONSE_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} 回答が追加されました');
define('_MI_XHELP_DEPT_NEWRESPONSE_NOTIFYTPL', 'dept_newresponse_notify.tpl');

define('_MI_XHELP_DEPT_MODIFIEDRESPONSE_NOTIFY', 'スタッフ: 回答の変更');
define('_MI_XHELP_DEPT_MODIFIEDRESPONSE_NOTIFYCAP', '回答がいつ修正されるか私に通知します。');
define('_MI_XHELP_DEPT_MODIFIEDRESPONSE_NOTIFYDSC', '回答が修正される場合、通知を受け取ります。');
define('_MI_XHELP_DEPT_MODIFIEDRESPONSE_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} 回答が変更されました');
define('_MI_XHELP_DEPT_MODIFIEDRESPONSE_NOTIFYTPL', 'dept_modifiedresponse_notify.tpl');

define('_MI_XHELP_DEPT_CHANGEDSTATUS_NOTIFY', 'スタッフ: 質問のステータスの変更');
define('_MI_XHELP_DEPT_CHANGEDSTATUS_NOTIFYCAP', '質問のステータスがいつ変更されるか私に通知します。');
define('_MI_XHELP_DEPT_CHANGEDSTATUS_NOTIFYDSC', '切符のステータスが変更される場合、通知を受け取ります。');
define('_MI_XHELP_DEPT_CHANGEDSTATUS_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} 質問のステータスが変更されました');
define('_MI_XHELP_DEPT_CHANGEDSTATUS_NOTIFYTPL', 'dept_changedstatus_notify.tpl');

define('_MI_XHELP_DEPT_CHANGEDPRIORITY_NOTIFY', 'スタッフ: 質問優先度のの変更');
define('_MI_XHELP_DEPT_CHANGEDPRIORITY_NOTIFYCAP', '質問のプライオリティがいつ変更されるか私に通知します。');
define('_MI_XHELP_DEPT_CHANGEDPRIORITY_NOTIFYDSC', '質問のプライオリティが変更される場合、通知を受け取ります。');
define('_MI_XHELP_DEPT_CHANGEDPRIORITY_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} 質問優先度が変更されました');
define('_MI_XHELP_DEPT_CHANGEDPRIORITY_NOTIFYTPL', 'dept_changedpriority_notify.tpl');

define('_MI_XHELP_DEPT_NEWOWNER_NOTIFY', 'スタッフ: 新担当者');
define('_MI_XHELP_DEPT_NEWOWNER_NOTIFYCAP', '質問の担当者がいつ変更されるか私に通知します。');
define('_MI_XHELP_DEPT_NEWOWNER_NOTIFYDSC', '質問の担当者が変更される場合、通知を受け取ります。');
define('_MI_XHELP_DEPT_NEWOWNER_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} 担当者が変更されました');
define('_MI_XHELP_DEPT_NEWOWNER_NOTIFYTPL', 'dept_newowner_notify.tpl');

/*
 define('_MI_XHELP_DEPT_CLAIMOWNER_NOTIFY', 'カテゴリー: 新担当者');
 define('_MI_XHELP_DEPT_CLAIMOWNER_NOTIFYCAP', '質問の担当者がいつ要求されるか私に通知します。');
 define('_MI_XHELP_DEPT_CLAIMOWNER_NOTIFYDSC', '質問の担当者が要求される場合、通知を受け取ります。');
 define('_MI_XHELP_DEPT_CLAIMOWNER_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} 担当者が変更されました');
 */

define('_MI_XHELP_TICKET_REMOVEDTICKET_NOTIFY', 'ユーザー: 質問を削除されました');
define('_MI_XHELP_TICKET_REMOVEDTICKET_NOTIFYCAP', 'この質問がいつ削除されるか私に通知します。');
define('_MI_XHELP_TICKET_REMOVEDTICKET_NOTIFYDSC', 'この質問が削除される場合、通知を受け取ります。');
define('_MI_XHELP_TICKET_REMOVEDTICKET_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} 質問が削除されました');
define('_MI_XHELP_TICKET_REMOVEDTICKET_NOTIFYTPL', 'ticket_removedticket_notify.tpl');

define('_MI_XHELP_TICKET_MODIFIEDTICKET_NOTIFY', 'ユーザー: 質問を修正されました');
define('_MI_XHELP_TICKET_MODIFIEDTICKET_NOTIFYCAP', 'この質問がいつ修正されるか私に通知します。');
define('_MI_XHELP_TICKET_MODIFIEDTICKET_NOTIFYDSC', 'この質問が修正される場合、通知を受け取ります。');
define('_MI_XHELP_TICKET_MODIFIEDTICKET_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} 質問が修正されました');
define('_MI_XHELP_TICKET_MODIFIEDTICKET_NOTIFYTPL', 'ticket_modifiedticket_notify.tpl');

define('_MI_XHELP_TICKET_NEWRESPONSE_NOTIFY', 'ユーザー: 新回答');
define('_MI_XHELP_TICKET_NEWRESPONSE_NOTIFYCAP', '回答がこの質問用にいつ作成されるか私に通知します。');
define('_MI_XHELP_TICKET_NEWRESPONSE_NOTIFYDSC', '回答がこの質問用にいつ作成されるか私に通知します。');
define('_MI_XHELP_TICKET_NEWRESPONSE_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} 新回答が追加されました');
define('_MI_XHELP_TICKET_NEWRESPONSE_NOTIFYTPL', 'ticket_newresponse_notify.tpl');

define('_MI_XHELP_TICKET_MODIFIEDRESPONSE_NOTIFY', 'ユーザー: 回答の変更');
define('_MI_XHELP_TICKET_MODIFIEDRESPONSE_NOTIFYCAP', '回答がこの質問用にいつ修正されるか私に通知します');
define('_MI_XHELP_TICKET_MODIFIEDRESPONSE_NOTIFYDSC', '回答がこの質問用に修正される場合、通知を受け取ります。');
define('_MI_XHELP_TICKET_MODIFIEDRESPONSE_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} 回答が変更されました');
define('_MI_XHELP_TICKET_MODIFIEDRESPONSE_NOTIFYTPL', 'ticket_modifiedresponse_notify.tpl');

define('_MI_XHELP_TICKET_CHANGEDSTATUS_NOTIFY', 'ユーザー: 質問ｽﾃｰﾀｽの変更');
define('_MI_XHELP_TICKET_CHANGEDSTATUS_NOTIFYCAP', 'この質問のステータスがいつ変更されるか私に通知します。');
define('_MI_XHELP_TICKET_CHANGEDSTATUS_NOTIFYDSC', 'この質問のステータスが変更される場合、通知を受け取ります。');
define('_MI_XHELP_TICKET_CHANGEDSTATUS_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} 質問ｽﾃｰﾀｽが変更されました');
define('_MI_XHELP_TICKET_CHANGEDSTATUS_NOTIFYTPL', 'ticket_changedstatus_notify.tpl');

define('_MI_XHELP_TICKET_CHANGEDPRIORITY_NOTIFY', 'ユーザー: 優先度の変更');
define('_MI_XHELP_TICKET_CHANGEDPRIORITY_NOTIFYCAP', 'この質問のプライオリティがいつ変更されるか私に通知します。');
define('_MI_XHELP_TICKET_CHANGEDPRIORITY_NOTIFYDSC', 'この質問のプライオリティが変更される場合、通知を受け取ります。');
define('_MI_XHELP_TICKET_CHANGEDPRIORITY_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} 質問の優先度が変更されました');
define('_MI_XHELP_TICKET_CHANGEDPRIORITY_NOTIFYTPL', 'ticket_changedpriority_notify.tpl');

define('_MI_XHELP_TICKET_NEWOWNER_NOTIFY', 'ユーザー: 新担当者');
define('_MI_XHELP_TICKET_NEWOWNER_NOTIFYCAP', '担当者がこの質問用にいつ変更されたか私に通知します。');
define('_MI_XHELP_TICKET_NEWOWNER_NOTIFYDSC', '担当者がこの質問用に変更された場合、通知を受け取ります。');
define('_MI_XHELP_TICKET_NEWOWNER_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} 担当者が変更されました');
define('_MI_XHELP_TICKET_NEWOWNER_NOTIFYTPL', 'ticket_newowner_notify.tpl');

define('_MI_XHELP_TEMP_STAFF_ALL', 'スタッフテンプレート・ページの表示');
define('_MI_XHELP_TEMP_STAFF_TICKET_TABLE', 'スタッフ質問を表示するテンプレート・ページ');
define('_MI_XHELP_TEMP_SETDEPT', 'カテゴリーを設定するテンプレート');
define('_MI_XHELP_TEMP_SETPRIORITY', '優先度を設定するテンプレート');
define('_MI_XHELP_TEMP_SETOWNER', '担当者を設定するテンプレート');
define('_MI_XHELP_TEMP_SETSTATUS', 'ステータスを設定するテンプレート');
define('_MI_XHELP_TEMP_DELETE', '質問を一括削除するテンプレート');

define('_MI_XHELP_TICKET_NEWTICKET_NOTIFY', 'ユーザー:新質問');
define('_MI_XHELP_TICKET_NEWTICKET_NOTIFYCAP', '新質問が作成される場合、確認する');
define('_MI_XHELP_TICKET_NEWTICKET_NOTIFYDSC', '新質問が作成される場合、お知らせを受け取ります');
define('_MI_XHELP_TICKET_NEWTICKET_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} 質問の作成を確認しました');
define('_MI_XHELP_TICKET_NEWTICKET_NOTIFYTPL', 'ticket_newticket_notify.tpl');

define('_MI_XHELP_DEPT_CLOSETICKET_NOTIFY', 'スタッフ: 質問受付の終了');
define('_MI_XHELP_DEPT_CLOSETICKET_NOTIFYCAP', '質問受付がいつ終了したか、お知らせします。');
define('_MI_XHELP_DEPT_CLOSETICKET_NOTIFYDSC', '質問受付が終了している場合、お知らせ通知を受け取ります。');
define('_MI_XHELP_DEPT_CLOSETICKET_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} 質問受付の終了を確認しました');
define('_MI_XHELP_DEPT_CLOSETICKET_NOTIFYTPL', 'dept_closeticket_notify.tpl');

define('_MI_XHELP_TICKET_CLOSETICKET_NOTIFY', 'ユーザー: 質問受付の終了');
define('_MI_XHELP_TICKET_CLOSETICKET_NOTIFYCAP', 'Confirm when a ticket is closed');
define('_MI_XHELP_TICKET_CLOSETICKET_NOTIFYDSC', '質問受付が終了している場合、お知らせを受け取ります。');
define('_MI_XHELP_TICKET_CLOSETICKET_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} 質問受付の終了を確認しました');
define('_MI_XHELP_TICKET_CLOSETICKET_NOTIFYTPL', 'ticket_closeticket_notify.tpl');

define('_MI_XHELP_TEMP_BATCHRESPONSE', '回答ページに、一括追加のテンプレート');
define('_MI_XHELP_BNAME4', '質問に対するアクション');
define('_MI_XHELP_BNAME4_DESC', 'スタッフが質問にできるアクションを表示。');

define('_MI_XHELP_STAFF_ACTIONS', 'スタッフのアクション');
define('_MI_XHELP_STAFF_ACTIONS_DSC', 'What style would you like the staff actions to show up as? Inline is the default, Block-Style requires you to enable the Staff Actions block.');

define('_MI_XHELP_TEMP_ANON_ADDTICKET', 'Template for anonymous user add ticket page');
define('_MI_XHELP_TEMP_ERROR', 'Template for error page');

define('_MI_XHELP_MENU_MANAGE_ROLES', 'Manage Roles');

define('_MI_XHELP_DEFAULT_DEPT', 'Default Department');
define('_MI_XHELP_DEFAULT_DEPT_DSC', "This will be the default department that is selected in the list when adding a ticket. <a href='javascript:openWithSelfMain(\"" . XOOPS_URL . "/modules/xhelp/install.php?op=updateDepts\", \"xoops_module_install_xhelp\",400, 300);'>Click here</a> to update the departments.");
define('_MI_XHELP_ACTION1', 'Inline-Style');
define('_MI_XHELP_ACTION2', 'Block-Style');
define('_MI_XHELP_OVERDUE_TIME', 'Ticket Overdue Time');
define('_MI_XHELP_OVERDUE_TIME_DSC', 'This determines how long the staff have to finish a ticket before it is late (in hours).');

define('_MI_XHELP_TICKET_NEWUSER_NOTIFY', 'ユーザー: New User created (Email Submission)');
define('_MI_XHELP_TICKET_NEWUSER_NOTIFYCAP', 'Notify user that a new account has been created');
define('_MI_XHELP_TICKET_NEWUSER_NOTIFYDSC', 'Receive notification when a new user is created from an email submission');
define('_MI_XHELP_TICKET_NEWUSER_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} New User Created');
define('_MI_XHELP_TICKET_NEWUSER_NOTIFYTPL', 'ticket_new_user_byemail.tpl');
define('_MI_XHELP_MENU_CHECK_TABLES', 'Check tables');

define('_MI_XHELP_ALLOW_ANON', 'Allow Anonymous User Ticket Submission');
define('_MI_XHELP_ALLOW_ANON_DSC', 'This allows anyone to create a ticket on your site. When an anonymous user submits a ticket, they are also prompted to create an account.');
define('_MI_XHELP_MENU_CHECK_TABLES', 'Check Tables');

//MODIFIED
define('_MI_XHELP_DEFAULT_DEPT_DSC', "This will be the default department that is selected in the list when adding a ticket. <a href='javascript:openWithSelfMain(\"" . XOOPS_URL . "/modules/xhelp/install.php?op=updateDepts\", \"xoops_module_install_xhelp\",400, 300);'>Click here</a> to update the departments.");

define('_MI_XHELP_MENU_MAIL_EVENTS', 'Mail Events');
define('_MI_XHELP_MENU_CHECK_EMAIL', 'Check Email');
define('_MI_XHELP_TICKET_NEWUSER_ACT1_NOTIFY', 'ユーザー: New User created');
define('_MI_XHELP_TICKET_NEWUSER_ACT1_NOTIFYCAP', 'Notify user that a new account has been created');
define('_MI_XHELP_TICKET_NEWUSER_ACT1_NOTIFYDSC', 'Receive notification when a new user is created from an email submission (Auto Activation)');
define('_MI_XHELP_TICKET_NEWUSER_ACT1_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} New User Created');
define('_MI_XHELP_TICKET_NEWUSER_ACT1_NOTIFYTPL', 'ticket_new_user_activation1.tpl');

define('_MI_XHELP_TICKET_NEWUSER_ACT2_NOTIFY', 'ユーザー: New User created');
define('_MI_XHELP_TICKET_NEWUSER_ACT2_NOTIFYCAP', 'Notify user that a new account has been created');
define('_MI_XHELP_TICKET_NEWUSER_ACT2_NOTIFYDSC', 'Receive notification when a new user is created from an email submission (Requires Admin Activation)');
define('_MI_XHELP_TICKET_NEWUSER_ACT2_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} New User Created');
define('_MI_XHELP_TICKET_NEWUSER_ACT2_NOTIFYTPL', 'ticket_new_user_activation2.tpl');

define('_MI_XHELP_APPLY_VISIBILITY', 'Apply department visibility to staff members?');
define('_MI_XHELP_APPLY_VISIBILITY_DSC', 'This determines if staff are limited to what departments they can submit tickets to. If "yes" is selected, staff members will be limited to submitting tickets to departments where the XOOPS group they belong to is selected.');

define('_MI_XHELP_TICKET_EMAIL_ERROR_NOTIFY', 'ユーザー: Email Error');
define('_MI_XHELP_TICKET_EMAIL_ERROR_NOTIFYCAP', 'Notify user that their email was not stored');
define('_MI_XHELP_TICKET_EMAIL_ERROR_NOTIFYDSC', 'Receive notification when an email submission is not stored');
define('_MI_XHELP_TICKET_EMAIL_ERROR_NOTIFYSBJ', 'RE: {TICKET_SUBJECT}');
define('_MI_XHELP_TICKET_EMAIL_ERROR_NOTIFYTPL', 'ticket_email_error.tpl');

define('_MI_XHELP_DEPT_MERGE_TICKET_NOTIFY', 'スタッフ: Merge Tickets');
define('_MI_XHELP_DEPT_MERGE_TICKET_NOTIFYCAP', 'Notify me when tickets are merged');
define('_MI_XHELP_DEPT_MERGE_TICKET_NOTIFYDSC', 'Receive notification when tickets are merged');
define('_MI_XHELP_DEPT_MERGE_TICKET_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} Tickets merged');
define('_MI_XHELP_DEPT_MERGE_TICKET_NOTIFYTPL', 'dept_mergeticket_notify.tpl');

define('_MI_XHELP_TICKET_MERGE_TICKET_NOTIFY', 'ユーザー: Merge Tickets');
define('_MI_XHELP_TICKET_MERGE_TICKET_NOTIFYCAP', 'Notify me when tickets are merged');
define('_MI_XHELP_TICKET_MERGE_TICKET_NOTIFYDSC', 'Receive notification when tickets are merged');
define('_MI_XHELP_TICKET_MERGE_TICKET_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} Tickets merged');
define('_MI_XHELP_TICKET_MERGE_TICKET_NOTIFYTPL', 'ticket_mergeticket_notify.tpl');

define('_MI_XHELP_MENU_MANAGE_FILES', 'Manage Files');
define('_MI_XHELP_ADMIN_ABOUT', 'About');
define('_MI_XHELP_TEXT_MANAGE_STATUSES', 'Manage Statuses');
define('_MI_XHELP_TEXT_MANAGE_FIELDS', 'Manage Custom Fields');
define('_MI_XHELP_TEXT_NOTIFICATIONS', 'Manage Notifications');

define('_MI_XHELP_TICKET_NEWTICKET_EMAIL_NOTIFY', 'ユーザー:新質問 (email)');


?>