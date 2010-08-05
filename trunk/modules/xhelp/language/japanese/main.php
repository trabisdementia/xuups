<?php
 
 /**
 *    $Id: main.php,v 1.4 2005/04/08 15:47:29 eric_juden Exp $
 *
 *    Japanese Translation by : Seibu Tsushin KK www.seibu-tsushin.co.jp
 *    Valentin  Nils  <opensource@seibu-tsushin.co.jp>
 *    Mizukoshi Norio <opensource@seibu-tsushin.co.jp>
 *
 */
 
 
 
 define('_XHELP_CATEGORY1', '所有権割り当て');
 define('_XHELP_CATEGORY2', '回答の削除');
 define('_XHELP_CATEGORY3', '質問削除');
 define('_XHELP_CATEGORY4', 'ユーザー質問のログ');
 define('_XHELP_CATEGORY5', '回答修正');
 define('_XHELP_CATEGORY6', '質問情報を修正します');
 
 define('_SEC_STAFF_ASSIGN_OWNER', '1');
 define('_SEC_STAFF_DELETE_RESPONSES', '2');
 define('_SEC_STAFF_DELETE_TICKETS', '3');
 define('_SEC_STAFF_LOG_USER_TICKETS', '4');
 define('_SEC_STAFF_MODIFY_RESPONSES', '5');
 define('_SEC_STAFF_MODIFY_TICKET_INFO', '6');
 
 define('_XHELP_MESSAGE_ADD_DEPT', 'カテゴリーを追加しました');
 define('_XHELP_MESSAGE_ADD_DEPT_ERROR', 'エラー : カテゴリーは追加できませんでした');
 define('_XHELP_MESSAGE_UPDATE_DEPT', 'カテゴリーを変更しました');
 define('_XHELP_MESSAGE_UPDATE_DEPT_ERROR', 'エラー : カテゴリーは更新できませんでした');
 define('_XHELP_MESSAGE_DEPT_DELETE', 'カテゴリーを削除しました');
 define('_XHELP_MESSAGE_DEPT_DELETE_ERROR', 'エラー : カテゴリーは削除できませんでした');
 define('_XHELP_MESSAGE_ADDSTAFF_ERROR', 'エラー : スタッフ・メンバーは追加できませんでした');
 define('_XHELP_MESSAGE_ADDSTAFF', 'スタッフメンバーを追加しました');
 define('_XHELP_MESSAGE_STAFF_DELETE', 'スタッフメンバーを削除しました');
 define('_XHELP_MESSAGE_STAFF_DELETE_ERROR', 'スタッフメンバーは削除できませんでした');
 define('_XHELP_MESSAGE_EDITSTAFF', 'スタッフメンバーのプロファイルを更新しました');
 define('_XHELP_MESSAGE_EDITSTAFF_ERROR', 'エラー : スタッフ・メンバーは更新できませんでした');
 define('_XHELP_MESSAGE_EDITSTAFF_NOCLEAR_ERROR', 'エラー :カテゴリーの削除をできませんでした');
 define('_XHELP_MESSAGE_DEPT_EXISTS', 'カテゴリーは既に存在します');
 define('_XHELP_MESSAGE_ADDTICKET', '質問が追加されました');
 define('_XHELP_MESSAGE_ADDTICKET_ERROR', 'エラー : 質問は記録されませんでした');
 define('_XHELP_MESSAGE_LOGMESSAGE_ERROR', 'エラー : アクションはデータ・ベースに記録されませんでした');
 define('_XHELP_MESSAGE_UPDATE_PRIORITY', '質問の評価が変更されました');
 define('_XHELP_MESSAGE_UPDATE_PRIORITY_ERROR', 'エラー : 質問優先度は更新されませんでした');
 define('_XHELP_MESSAGE_UPDATE_STATUS', '質問のステータスが変更されました');
 define('_XHELP_MESSAGE_UPDATE_STATUS_ERROR', 'エラー : 質問ステータスが変更できませんでした');
 define('_XHELP_MESSAGE_CLAIM_OWNER', '質問の所有権を要求しました');
 define('_XHELP_MESSAGE_CLAIM_OWNER_ERROR', 'エラー : 質問所有権は要求されませんでした');
 define('_XHELP_MESSAGE_ASSIGN_OWNER', '担当者が変更されました');
 define('_XHELP_MESSAGE_ASSIGN_OWNER_ERROR', 'エラー : 質問所有権は割り当てられませんでした');
 define('_XHELP_MESSAGE_UPDATE_OWNER', '担当者が更新されました');
 define('_XHELP_MESSAGE_ADDFILE', 'ファイルが更新されました');
 define('_XHELP_MESSAGE_ADDFILE_ERROR', 'エラー : ファイルはアップロードされませんでした');
 define('_XHELP_MESSAGE_ADDRESPONSE', '回答が追加されました');
 define('_XHELP_MESSAGE_ADDRESPONSE_ERROR', 'エラー : 回答が追加されませんでした');
 define('_XHELP_MESSAGE_UPDATE_CALLS_CLOSED_ERROR', 'エラー : callsClosed フィールドは更新されませんでした');
 define('_XHELP_MESSAGE_ALREADY_OWNER', '%s さんは既に担当に設定されています');
 define('_XHELP_MESSAGE_ALREADY_STATUS', '質問は既にステータスに設定されています');
 define('_XHELP_MESSAGE_DELETE_TICKET', '質問は削除されました');
 define('_XHELP_MESSAGE_DELETE_TICKET_ERROR', 'エラー : 質問は削除されませんでした');
 define('_XHELP_MESSAGE_ADD_SIGNATURE', '署名が追加されました');
 define('_XHELP_MESSAGE_ADD_SIGNATURE_ERROR', 'エラー : 更新されない署名');
 define('_XHELP_MESSAGE_RESPONSE_TPL', '題名が変更されました');
 define('_XHELP_MESSAGE_RESPONSE_TPL_ERROR', 'エラー : 回答は変更されませんでした');
 define('_XHELP_MESSAGE_DELETE_RESPONSE_TPL', '題名が削除されました');
 define('_XHELP_MESSAGE_DELETE_RESPONSE_TPL_ERROR', 'エラー :　題名が削除されませんでした');
 define('_XHELP_MESSAGE_ADD_STAFFREVIEW', 'スタッフの評価が追加されました');
 define('_XHELP_MESSAGE_ADD_STAFFREVIEW_ERROR', 'エラー : 調査は追加できませんでした');
 define('_XHELP_MESSAGE_UPDATE_STAFF_ERROR', 'エラー : 更新できないスタッフ・メンバー情報');
 define('_XHELP_MESSAGE_UPDATE_SIG_ERROR', 'エラー : 更新できない署名');
 define('_XHELP_MESSAGE_UPDATE_SIG', '署名が更新されました');
 define('_XHELP_MESSAGE_EDITTICKET', '更新された質問');
 define('_XHELP_MESSAGE_EDITTICKET_ERROR', 'エラー : 更新できない質問');
 define('_XHELP_MESSAGE_USER_MOREINFO', '質問が変更されました。');
 define('_XHELP_MESSAGE_USER_MOREINFO_ERROR', 'エラー : 質問が変更されませんでした');
 define('_XHELP_MESSAGE_EDITRESPONSE', '回答は変更されました');
 define('_XHELP_MESSAGE_EDITRESPONSE_ERROR', 'エラー : 回答は変更されませんでした');
 define('_XHELP_MESSAGE_NOTIFY_UPDATE', '通知が変更されました');
 define('_XHELP_MESSAGE_NOTIFY_UPDATE_ERROR', '通知は更新されませんでした');
 define('_XHELP_MESSAGE_NO_NOTIFICATIONS', 'ユーザーは通知を持っていません');
 define('_XHELP_MESSAGE_NO_DEPTS', 'エラー : カテゴリーがまだ追加されていません。管理者に連絡して下さい。');
 define('_XHELP_MESSAGE_NO_STAFF', 'エラー : スタッフがまだ追加されていません。管理者に連絡して下さい。');
 define('_XHELP_MESSAGE_TICKET_REOPEN', '質問が再開されました。');
 define('_XHELP_MESSAGE_TICKET_REOPEN_ERROR', 'エラー : 質問は再開されませんでした。');
 define('_XHELP_MESSAGE_NOT_USER', 'エラー : 提出しなかった質問を再開できませんでした。');
 define('_XHELP_MESSAGE_NO_TICKETS', 'エラー : 質問は選択できませんでした。');
 define('_XHELP_MESSAGE_NOOWNER', '担当者は未設定');
 define('_XHELP_MESSAGE_UNKNOWN', '知りません');
 define('_XHELP_MESSAGE_WRONG_MIMETYPE', 'エラー : ファイルタイプが許可されていません。');
 define('_XHELP_MESSAGE_NO_UID', 'エラー : 指定されたユーザーIDは、ありません');
 define('_XHELP_MESSAGE_NO_PRIORITY', 'エラー : 指定された優先度はありません');
 define('_XHELP_MESSAGE_FILE_ERROR', 'エラー : ファイルのアップロード出きませんでした。理由:<br />%s');
 
 define('_XHELP_ERROR_INV_TICKET', 'エラー : 無効の質問を指定しました。質問をチェックして、再度試みてください!');
 define('_XHELP_ERROR_INV_RESPONSE', 'エラー : 無効の 回答を指定しました。 回答をチェックして、再度試みてください!');
 define('_XHELP_ERROR_NODEPTPERM', '質問の回答の追加ができませんでした。理由:このスタッフは、このカテゴリーのメーンバーではありません。');
 define('_XHELP_ERROR_INV_STAFF', 'エラー : ユーザーはスタッフ・メンバーではありません。');
 define('_XHELP_ERROR_INV_TEMPLATE', 'エラー : テンプレート名又はテキストが入力されていません');
 
 define('_XHELP_TITLE_ADDTICKET', '質問の追加');
 define('_XHELP_TITLE_ADDRESPONSE', '回答の追加');
 define('_XHELP_TITLE_EDITTICKET', '質問の変更');
 define('_XHELP_TITLE_EDITRESPONSE', '回答の変更');
 define('_XHELP_TITLE_SEARCH', '検索');
 
 define('_XHELP_TEXT_ID', 'ID:');
 define('_XHELP_TEXT_NAME', 'ユーザー名:');
 define('_XHELP_TEXT_USER', 'ユーザー:');
 define('_XHELP_TEXT_USERID', 'ユーザーID:');
 define('_XHELP_TEXT_LOOKUP', '検索');
 define('_XHELP_TEXT_LOOKUP_USER', 'ユーザー検索');
 define('_XHELP_TEXT_EMAIL', '電子メール:');
 define('_XHELP_TEXT_ASSIGNTO', '担当者:');
 define('_XHELP_TEXT_PRIORITY', '優先度:');
 define('_XHELP_TEXT_STATUS', 'ステータス:');
 define('_XHELP_TEXT_SUBJECT', '題名:');
 define('_XHELP_TEXT_DEPARTMENT', 'カテゴリー:');
 define('_XHELP_TEXT_OWNER', '担当者:');
 define('_XHELP_TEXT_CLOSEDBY', '質問を閉じた担当者:');
 define('_XHELP_TEXT_NOTAPPLY', '使用不可');
 define('_XHELP_TEXT_TIMESPENT', '作業時間:');
 define('_XHELP_TEXT_DESCRIPTION', '記述:');
 define('_XHELP_TEXT_ADDFILE', 'ファイル追加:');
 define('_XHELP_TEXT_FILE', 'ファイル:');
 define('_XHELP_TEXT_RESPONSE', ' 回答');
 define('_XHELP_TEXT_RESPONSES', ' 回答');
 define('_XHELP_TEXT_CLAIMOWNER', '署名:');
 define('_XHELP_TEXT_CLAIM_OWNER', '署名');
 define('_XHELP_TEXT_TICKETDETAILS', '質問詳細');
 define('_XHELP_TEXT_MINUTES', '分');
 define('_XHELP_TEXT_SEARCH', '検索:');
 define('_XHELP_TEXT_SEARCHBY', '選択:');
 define('_XHELP_SEARCH_DESC', '記述');
 define('_XHELP_SEARCH_SUBJECT', '題名');
 define('_XHELP_TEXT_NUMRESULTS', '1ページ当たり結果の数:');
 define('_XHELP_TEXT_RESULT1', '5');
 define('_XHELP_TEXT_RESULT2', '10');
 define('_XHELP_TEXT_RESULT3', '25');
 define('_XHELP_TEXT_RESULT4', '50');
 define('_XHELP_TEXT_SEARCH_RESULTS', '検索結果');
 define('_XHELP_TEXT_PREDEFINED_RESPONSES', '回答のテンプレート:');
 define('_XHELP_TEXT_PREDEFINED0', '-- 題名の追加 --');
 define('_XHELP_TEXT_NO_USERS', 'ユーザーは見つかりません');
 define('_XHELP_TEXT_SEARCH_AGAIN', '再検索');
 define('_XHELP_TEXT_LOGGED_BY', 'ユーザー:');
 define('_XHELP_TEXT_LOG_TIME', '作成日:');
 define('_XHELP_TEXT_OWNERSHIP_DETAILS', ' 担当者詳細');
 define('_XHELP_TEXT_ACTIVITY_LOG', 'アクションログ');
 define('_XHELP_TEXT_HELPDESK_TICKET', 'ヘルプデスク質問:');
 define('_XHELP_TEXT_YES', 'Yes');
 define('_XHELP_TEXT_NO', 'No');
 define('_XHELP_TEXT_ALL_TICKETS', '全ての質問');
 define('_XHELP_TEXT_HIGH_PRIORITY', '優先度の高い質問');
 define('_XHELP_TEXT_NEW_TICKETS', '新しい質問');
 define('_XHELP_TEXT_MY_TICKETS', '私の質問');
 define('_XHELP_TEXT_ANNOUNCEMENTS', '発表');
 define('_XHELP_TEXT_MY_PERFORMANCE', '私のパフォーマンス');
 define('_XHELP_TEXT_RESPONSE_TIME', '平均回答時間:');
 define('_XHELP_TEXT_RATING', 'ランキング:');
 define('_XHELP_TEXT_NUMREVIEWS', '調査数:');
 define('_XHELP_TEXT_NUM_TICKETS_CLOSED', '終了した質問:');
 define('_XHELP_TEXT_TEMPLATE_NAME', 'テンプレート名:');
 define('_XHELP_TEXT_MESSAGE', 'メッセージ:');
 define('_XHELP_TEXT_ACTIONS', ' サーポトのアクション : ');
 define('_XHELP_TEXT_ACTIONS2', 'サーポトのアクション ');
 define('_XHELP_TEXT_MY_NOTIFICATIONS', 'イベントのお知らせ：');
 define('_XHELP_TEXT_SELECT_ALL', '全て選択');
 define('_XHELP_TEXT_USER_IP', 'ユーザー IP :');
 define('_XHELP_TEXT_OWNERSHIP', '担当者');
 define('_XHELP_TEXT_ASSIGN_OWNER', '担当者の選択');
 define('_XHELP_TEXT_TICKET', '質問');
 define('_XHELP_TEXT_USER_RATING', 'ユーザー格付け :');
 define('_XHELP_TEXT_EDIT_RESPONSE', '回答編集');
 define('_XHELP_TEXT_FILE_ADDED', 'ファイル追加 :');
 define('_XHELP_TEXT_ACTION', 'アクション:');
 define('_XHELP_TEXT_LAST_TICKETS', '最新の質問:');
 define('_XHELP_TEXT_RATE_STAFF', 'スタッフの評価');
 define('_XHELP_TEXT_COMMENTS', 'コメント:');
 define('_XHELP_TEXT_MY_OPEN_TICKETS', '私の質問');
 define('_XHELP_TEXT_RATE_RESPONSE', '評価の追加');
 define('_XHELP_TEXT_RESPONSE_RATING', '回答の評価:');
 define('_XHELP_TEXT_REOPEN_TICKET', '質問の再回答');
 define('_XHELP_TEXT_MORE_INFO', '詳細要求');
 define('_XHELP_TEXT_REOPEN_REASON', '質問の再回答の理由(オプション)');
 define('_XHELP_TEXT_MORE_INFO2', '詳細要求の追加');
 
 // Ticket.php - Actions
 define('_XHELP_TEXT_ADD_RESPONSE', '回答の追加');
 define('_XHELP_TEXT_EDIT_TICKET', '質問編集');
 define('_XHELP_TEXT_DELETE_TICKET', '質問削除');
 define('_XHELP_TEXT_PRINT_TICKET', '質問印刷');
 define('_XHELP_TEXT_UPDATE_PRIORITY', '最新版優先度');
 define('_XHELP_TEXT_UPDATE_STATUS', '最新版状況');
 
 define('_XHELP_PIC_ALT_USER_AVATAR', 'ユーザーのアバター');
 
 // Index.php - Auto Refresh Page vars
 define('_XHELP_TEXT_AUTO_REFRESH0', '最新の情報に更新無し');
 define('_XHELP_TEXT_AUTO_REFRESH1', '1分・１回　最新の情報に更新最新');
 define('_XHELP_TEXT_AUTO_REFRESH2', '5分・１回　最新の情報に更新最新');
 define('_XHELP_TEXT_AUTO_REFRESH3', '10分・１回　最新の情報に更新最新');
 define('_XHELP_TEXT_AUTO_REFRESH4', '30分・１回　最新の情報に更新最新');
 define('_XHELP_AUTO_REFRESH0', 0);          // Change these to
 define('_XHELP_AUTO_REFRESH1', 60);         // adjust the values 
 define('_XHELP_AUTO_REFRESH2', 300);        // in the select box
 define('_XHELP_AUTO_REFRESH3', 600);
 define('_XHELP_AUTO_REFRESH4', 1800);
 
 define('_XHELP_MENU_MAIN', 'ホーム');
 define('_XHELP_MENU_LOG_TICKET', '質問の追加');
 define('_XHELP_MENU_MY_PROFILE', '私の評価');
 define('_XHELP_MENU_ALL_TICKETS', '全ての質問');
 define('_XHELP_MENU_SEARCH', '検索');
 
 define('_XHELP_SEARCH_EMAIL', '電子メール');
 define('_XHELP_SEARCH_USERNAME', 'ユーザー名');
 define('_XHELP_SEARCH_UID', 'ユーザーID');
 
 define('_XHELP_BUTTON_ADDRESPONSE', '回答追加');
 define('_XHELP_BUTTON_ADDTICKET', '質問の追加');
 define('_XHELP_BUTTON_EDITTICKET', '質問編集');
 define('_XHELP_BUTTON_RESET', 'リセット');
 define('_XHELP_BUTTON_EDITRESPONSE', '最新版回答');
 define('_XHELP_BUTTON_SEARCH', '検索');
 define('_XHELP_BUTTON_LOG_USER', '問い合わせ履歴');
 define('_XHELP_BUTTON_FIND_USER', 'ユーザー検索');
 define('_XHELP_BUTTON_SUBMIT', '更新');
 define('_XHELP_BUTTON_DELETE', '削除');
 define('_XHELP_BUTTON_UPDATE', '最新版');
 define('_XHELP_BUTTON_UPDATE_PRIORITY', '最新版優先度');
 define('_XHELP_BUTTON_UPDATE_STATUS', '最新版状況');
 define('_XHELP_BUTTON_ADD_INFO', '情報追加');
 
 define('_XHELP_PRIORITY1', 1);
 define('_XHELP_PRIORITY2', 2);
 define('_XHELP_PRIORITY3', 3);
 define('_XHELP_PRIORITY4', 4);
 define('_XHELP_PRIORITY5', 5);
 
 define('_XHELP_STATUS0', 'オープン');
 define('_XHELP_STATUS1', 'ペンディング');
 define('_XHELP_STATUS2', '閉じる');
 
 define('_XHELP_RATING0', 'ランク無し');
 define('_XHELP_RATING1', '最悪');
 define('_XHELP_RATING2', '悪い');
 define('_XHELP_RATING3', '普通');
 define('_XHELP_RATING4', '良い');
 define('_XHELP_RATING5', '非常に良い');
 
 // Log Messages
 define('_XHELP_LOG_ADDTICKET', '質問が追加されました');
 define('_XHELP_LOG_ADDTICKET_FORUSER', 'ユーザー　%s　は　%s　の質問に追加しました');
 define('_XHELP_LOG_EDITTICKET', '質問情報が編集されました');
 define('_XHELP_LOG_UPDATE_PRIORITY', '優先度をpri:　%u　から　pri:　%u　に　変更しました');
 define('_XHELP_LOG_UPDATE_STATUS', 'ステータスを　%s　から　%s　に　変更しました');
 define('_XHELP_LOG_CLAIM_OWNERSHIP', '担当宣言');
 define('_XHELP_LOG_ASSIGN_OWNERSHIP', '受ける担当者： %s');
 define('_XHELP_LOG_ADDRESPONSE', '回答追加');
 define('_XHELP_LOG_USER_MOREINFO', '多くの情報を追加');
 define('_XHELP_LOG_EDIT_RESPONSE', '# %s は　回答を変更しました');
 define('_XHELP_LOG_REOPEN_TICKET', '質問の再回答');
 define('_XHELP_LOG_CLOSE_TICKET', '質問の終了');
 define('_XHELP_LOG_ADDRATING', 'ランキング %u');
 
 // Error checking for no records in DB
 define('_XHELP_NO_TICKETS_ERROR', '質問がありません');
 define('_XHELP_NO_RESPONSES_ERROR', '回答 が見つかりませんでした');
 define('_XHELP_NO_FILES_ERROR', 'ファイルが見つかりませんでした');
 
 define('_XHELP_SIG_SPACER', '<br /><br />-------------------------------<br />');
 define('_XHELP_COMMMENTS', 'コメント ?');
 define("_XHELP_ANNOUNCE_READMORE","多くの読み取り...");
 define("_XHELP_ANNOUNCE_ONECOMMENT","1 コメント");
 define("_XHELP_ANNOUNCE_NUMCOMMENTS","%s コメント");
 
 define('_XHELP_NO_OWNER', '担当者は未設定');
 define('_XHELP_RESPONSE_EDIT', 'ユーザー　%s　は　%s　の回答を変更しました');
 
 define('_XHELP_TIME_SECS', '秒');
 define('_XHELP_TIME_MINS', '分');
 define('_XHELP_TIME_HOURS', '時間');
 define('_XHELP_TIME_DAYS', '日');
 
 define('_XHELP_JSC_TEXT_DELETE', 'この質問を、削除してもよろしいですか。');
 define('_XHELP_MESSAGE_UPDATE_DEPARTMENT', '質問はカテゴリーによって、更新されました。');
 define('_XHELP_MESSAGE_UPDATE_DEPARTMENT_ERROR', 'エラー : 質問は更新されませんでした。');
 define('_XHELP_MESSAGE_TICKET_CLOSE', '質問受付は終了しました。');
 define('_XHELP_MESSAGE_TICKET_CLOSE_ERROR', 'エラー : 質問受付は終了しませんでした。');
 define('_XHELP_MESSAGE_UPDATE_EMAIL_ERROR', 'エラー : メールは更新されませんでした。');
 define('_XHELP_MESSAGE_TICKET_DELETE_CNFRM', '質問本当に削除しますか。');
 define('_XHELP_MESSAGE_DELETE_TICKETS', '質問は削除されました。');
 define('_XHELP_MESSAGE_DELETE_TICKETS_ERROR', 'エラー : 質問は削除されませんでした。');
 
 define('_XHELP_TEXT_NO_DEPT', 'カテゴリーはありません。');
 define('_XHELP_TEXT_NOT_EMAIL', 'メールアドレス :');
 define('_XHELP_TEXT_LAST_REVIEWS', '最新スタッフ調査 :');
 define('_XHELP_TEXT_SORT_TICKETS', 'このコラムによって、質問を分類');
 define('_XHELP_TEXT_ELAPSED', '経過 :');
 define('_XHELP_TEXT_FILTERTICKETS', 'Filter Tickets:');
 define('_XHELP_TEXT_LIMIT', 'ページ当たりレコード数');
 define('_XHELP_TEXT_SUBMITTEDBY', 'ユーザーID:');
 define('_XHELP_TEXT_NO_INCLUDE', 'ANY');
 define('_XHELP_TEXT_PRIVATE_RESPONSE', '個人の回答 :');
 define('_XHELP_TEXT_PRIVATE', '個人');
 define('_XHELP_TEXT_CLOSE_TICKET', '似通った質問');
 
 define('_XHELP_TEXT_BATCH_ACTIONS', '一括のアクション');
 define('_XHELP_TEXT_BATCH_DEPARTMENT', 'カテゴリーの変更');
 define('_XHELP_TEXT_BATCH_PRIORITY', '優先度の変更');
 define('_XHELP_TEXT_BATCH_STATUS', 'ステータスの変更');
 define('_XHELP_TEXT_BATCH_DELETE', '質問の削除');
 define('_XHELP_TEXT_BATCH_RESPONSE', '回答');
 define('_XHELP_TEXT_BATCH_OWNERSHIP', '所有権を割り当てる');
 
 define('_XHELP_TEXT_SETDEPT', 'カテゴリーの選択 :');
 define('_XHELP_TEXT_SETPRIORITY', '質問の優先度の設定 :');
 define('_XHELP_TEXT_SETOWNER', '担当者の選択 :');
 define('_XHELP_TEXT_SETSTATUS', '質問のステータスの設定 :');
 define('_XHELP_TEXT_SELECTED', '選択 :');
 define('_XHELP_BUTTON_SET', '送信');
 
 define('_XHELP_TEXT_PRIORITY1', '高い');
 define('_XHELP_TEXT_PRIORITY2', '中間の上');
 define('_XHELP_TEXT_PRIORITY3', '中間');
 define('_XHELP_TEXT_PRIORITY4', '中間の下');
 define('_XHELP_TEXT_PRIORITY5', '低い');
 
 define('_XHELP_LOG_SETDEPT', '%sカテゴリーに割り当てられました。');
 
 define('_XHELP_TIME_WEEKS', '週');
 define('_XHELP_TIME_YEARS', '年');
 
 define('_XHELP_TIME_SEC', '秒');
 define('_XHELP_TIME_MIN', '分');
 define('_XHELP_TIME_HOUR', '時');
 define('_XHELP_TIME_DAY', '日');
 define('_XHELP_TIME_WEEK', '週');
 define('_XHELP_TIME_YEAR', '年');
 
 define('_XHELP_TEXT_ADD_SIGNATURE', '回答に署名を追加しますか。');
 define('_XHELP_MESSAGE_VALIDATE_ERROR', '質問はエラーです。再度、修正してください :');
 define('_XHELP_TEXT_SUBMITTED_TICKETS', '私の担当質問');
 define('_XHELP_TEXT_LASTUPDATE', '最終更新日');
 
 define('_XHELP_TEXT_UPDATE_COMP', 'アップデートが終了しました。');
 define('_XHELP_TEXT_TOPICS_ADDED', 'Topics Added');
 define('_XHELP_TEXT_CLOSE_WINDOW', 'ウィンドウを閉じる');
 define('_XHELP_MESSAGE_USER_NO_INFO', 'エラー: 新しい方法が入力されませんでした。');
 
 define('_XHELP_TEXT_USER_LOOKUP', 'ユーザー検索');
 define('_XHELP_TEXT_EVENT', 'イベント');
 define('_XHELP_TEXT_AVAIL_FILETYPES', '添付できるファイルタイプ');
 define('_XHELP_MESSAGE_VALIDATE_ERROR', '送信した質問は、エラーです。もう一度、入力してください。');
 define('_XHELP_MESSAGE_UNAME_TAKEN', ' そのユーザー名は、使用中です。他のユーザー名を選んでください。');
 define('_XHELP_MESSAGE_INVALID', ' は無効です。');
 define('_XHELP_MESSAGE_LONG', ' は長すぎます。');
 define('_XHELP_MESSAGE_SHORT', ' は短かすぎです。');
 define('_XHELP_MESSAGE_NOT_ENTERED', ' was not entered.');
 define('_XHELP_MESSAGE_NOT_NUMERIC', ' is not numeric.');
 define('_XHELP_MESSAGE_RESERVED', ' 入力項目が重複しています。');
 define('_XHELP_MESSAGE_NO_SPACES', ' ブランクは、入力できません。');
 define('_XHELP_MESSAGE_NOT_SAME', ' 入力エラーです。もう一度、入力してください。');
 define('_XHELP_MESSAGE_NOT_SUPPLIED', ' is not supplied.');
 
 define('_XHELP_MESSAGE_CREATE_USER_ERROR', ' ユーザー名が追加できませんでした。');
define('_XHELP_MESSAGE_NO_REGISTER', 'エラー: この機能は、ユーザー登録が必要になります。');

define('_XHELP_SEC_TICKET_ADD', 0);
define('_XHELP_SEC_TICKET_EDIT', 1);
define('_XHELP_SEC_TICKET_DELETE', 2);
define('_XHELP_SEC_TICKET_OWNERSHIP', 3);
define('_XHELP_SEC_TICKET_STATUS', 4);
define('_XHELP_SEC_TICKET_PRIORITY', 5);
define('_XHELP_SEC_TICKET_LOGUSER', 6);
define('_XHELP_SEC_RESPONSE_ADD', 7);
define('_XHELP_SEC_RESPONSE_EDIT', 8);

define('_XHELP_SEC_TEXT_TICKET_ADD', '質問の追加');
define('_XHELP_SEC_TEXT_TICKET_EDIT', '質問の編集');
define('_XHELP_SEC_TEXT_TICKET_DELETE', '質問の編集');
define('_XHELP_SEC_TEXT_TICKET_OWNERSHIP', '質問の担当者の変更');
define('_XHELP_SEC_TEXT_TICKET_STATUS', '質問の状態の編集');
define('_XHELP_SEC_TEXT_TICKET_PRIORITY', '質問の優先度の編集');
define('_XHELP_SEC_TEXT_TICKET_LOGUSER', '質問するユーザー名');
define('_XHELP_SEC_TEXT_RESPONSE_ADD', '回答の追加');
define('_XHELP_SEC_TEXT_RESPONSE_EDIT', '回答の編集');

define('_XHELP_MESSAGE_NO_ADD_TICKET', 'あなたには、質問を入力する権限がありません。');
define('_XHELP_MESSAGE_NO_DELETE_TICKET', 'あなたには、質問を削除する権限がありません。');
define('_XHELP_MESSAGE_NO_EDIT_TICKET', 'あなたには、質問を編集する権限がありません。');
define('_XHELP_MESSAGE_NO_CHANGE_OWNER', 'あなたには、担当者を変更する権限がありません。');
define('_XHELP_MESSAGE_NO_CHANGE_PRIORITY', 'あなたには、優先度を変更する権限がありません。');
define('_XHELP_MESSAGE_NO_CHANGE_STATUS', 'あなたには、ステータスを変更する権限がありません。');
define('_XHELP_MESSAGE_NO_ADD_RESPONSE', 'あなたには、回答を入力する権限がありません。');
define('_XHELP_MESSAGE_NO_EDIT_RESPONSE', 'あなたには、回答を編集する権限がありません。');

define('_XHELP_ROLE_NAME1', 'リーダー');
define('_XHELP_ROLE_NAME2', 'スタッフ');
define('_XHELP_ROLE_NAME3', 'Browser');
define('_XHELP_ROLE_DSC1', '管理者の権限');
define('_XHELP_ROLE_DSC2', '質問・回答に対して、入力・編集・削除ができます。');
define('_XHELP_ROLE_DSC3', '編集できないユーザ');
define('_XHELP_ROLE_VAL1', '511');
define('_XHELP_ROLE_VAL2', '241');
define('_XHELP_ROLE_VAL3', '0');
define("_XHELP_TICKET_MD5SIGNATURE", "サポート キー:");
define('_XHELP_USER_REGISTER', 'ユーザ登録');
define('_XHELP_TEXT_DEPTS_ADDED', 'カテゴリーが追加されました。');

define('_XHELP_MESSAGE_NEW_USER_ERR', 'エラー: ユーザー登録ができませんでした。');
define('_XHELP_MESSAGE_EMAIL_USED', 'エラー: Eメールは登録済です。');
 
define('_XHELP_MAILEVENT_CLASS0', '0'); // Connection message
define('_XHELP_MAILEVENT_CLASS1', '1'); // Parse message
define('_XHELP_MAILEVENT_CLASS2', '2'); // Storage message
define('_XHELP_MAILEVENT_CLASS3', '3'); // General message
define('_XHELP_MAILEVENT_DESC0', 'エラー: サーバーに接続できませんでした。');
define('_XHELP_MAILEVENT_DESC1', 'エラー: メッセージの入力ができませんでした。');
define('_XHELP_MAILEVENT_DESC2', 'エラー: メッセージが保存されませんでした。');
define('_XHELP_MAILEVENT_DESC3', '');

define('_XHELP_MESSAGE_UPLOAD_ALLOWED_ERR', 'エラー: ファイルアップロードの権限がありません。');
define('_XHELP_MESSAGE_UPLOAD_ERR', 'エラー: ファイル %s (%s から) が保存できませんでした。エラーの内容 %s');

define('_XHELP_MISMATCH_EMAIL', '%s has been notified that their message was not stored. Support key matched, but message should have been sent from %s instead.');

define('_XHELP_RESPONSE_NO_TICKET', 'No ticket found for ticket response');
define('_XHELP_MESSAGE_NO_ANON', '%s からのメッセージをすべて拒否します。未登録ユーザーは、質問の入力が出来ません。');

define('_XHELP_MESSAGE_EMAIL_DEPT_MBOX', 'エラー: スタッフは、Eメールによる質問の追加は出来ません。オンライン・フォームを使用してください。');

define('_XHELP_TEXT_MERGE_TICKET', 'Merge Tickets');
define('_XHELP_SEC_TICKET_MERGE', 9);
define('_XHELP_SEC_TEXT_TICKET_MERGE', 'Merge Tickets');
define('_XHELP_MESSAGE_NO_MERGE', 'You do not have permission to merge tickets.');
define('_XHELP_MESSAGE_NO_TICKET2', 'エラー: you did not specify a ticket to merge with.');
define('_XHELP_LOG_MERGETICKETS', 'Merged ticket %s to %s');
define('_XHELP_MESSAGE_MERGE', 'Merge successfully completed.');
define('_XHELP_MESSAGE_MERGE_ERROR', 'エラー: merge was not completed.');

define('_XHELP_TEXT_MERGE_TITLE', 'Enter the ticket ID you want to merge with.');
define('_XHELP_MESSAGE_ADDED_EMAIL', 'メールアドレスを追加しました。');
define('_XHELP_MESSAGE_ADDED_EMAIL_ERROR', 'エラー: メールアドレスを追加しました。');
define('_XHELP_BUTTON_ADD_EMAIL', 'メールの追加');
define('_XHELP_TEXT_EMAIL_NOTIFICATION', 'メールのお知らせ:');
define('_XHELP_MESSAGE_NO_EMAIL', 'エラー: メールが追加できませんでした');
define('_XHELP_TEXT_EMAIL_NOTIFICATION_TITLE', 'お知らせのメールアドレスを入力してください。');
define('_XHELP_TEXT_RECEIVE_NOTIFICATIONS', 'メールアドレスのお知らせ:');
define('_XHELP_TEXT_EMAIL_SUPPRESS', 'メールの送信ができません。クリックすると送信可能です。');
define('_XHELP_TEXT_EMAIL_NOT_SUPPRESS', 'メールの送信が可能です。クリックすると送信がされません。');
define('_XHELP_TEXT_TICKET_NOTIFICATIONS', '質問のお知らせ');
define('_XHELP_MESSAGE_ADD_EMAIL', 'メールのお知らせが更新されました。');
define('_XHELP_MESSAGE_ADD_EMAIL_ERROR', 'エラー: メールのお知らせが更新されませんでした。');
define('_XHELP_MESSAGE_NO_MERGE_TICKET', 'あなたは、メールの送信を止めることはできません。(権限がありません)');

define('_XHELP_STATE1', 'Unresolved');
define('_XHELP_STATE2', 'Resolved');
define('_XHELP_MESSAGE_NO_REGISTER', 'Please login to your account to submit a ticket.');
define('_XHELP_TEXT_STATE', 'State:');

define('_XHELP_NUM_STATE1', 1);
define('_XHELP_NUM_STATE2', 2);

define('_XHELP_MESSAGE_DELETE_FILE_ERR', 'Error: file was not deleted.');
define('_XHELP_LOG_DELETEFILE', 'File %s deleted');
define('_XHELP_SEC_FILE_DELETE', 10);
define('_XHELP_SEC_TEXT_FILE_DELETE', 'Delete File Attachments');

define('_XHELP_SIZE_BYTES', 'Bytes');
define('_XHELP_SIZE_KB', 'KB');
define('_XHELP_SIZE_MB', 'MB');
define('_XHELP_SIZE_GB', 'GB');
define('_XHELP_SIZE_TB', 'TB');
define('_XHELP_MESSAGE_NO_FILE_DELETE', 'You do not have permission to delete files.');

define('_XHELP_NO_MAILBOX_ERROR', 'Invalid Mailbox Specified');
define('_XHELP_MBOX_ERR_LOGIN', 'Connection failed to mail server: invalid login/password');
define('_XHELP_MBOX_INV_BOXTYPE', 'Specified mailbox type is not supported');

define('_XHELP_TEXT_USER_NOT_ACTIVATED', 'User has not finished activation process.');

define('_XHELP_TEXT_VIEW1', 'Basic View');
define('_XHELP_TEXT_VIEW2', 'Advanced View');

define('_XHELP_TEXT_SAVE_SEARCH', 'Save Search?');
define('_XHELP_TEXT_SEARCH_NAME', 'Search Name:');
define('_XHELP_TEXT_SAVED_SEARCHES', 'Previously Saved Searches');
define('_XHELP_BUTTON_RUN', 'Run');

define('_XHELP_TEXT_SWITCH_TO', 'Switch To ');
define('_XHELP_DEFAULT_PRIORITY', 4);

define('_XHELP_CONTROL_DESC_TXTBOX', 'Text Box');
define('_XHELP_CONTROL_DESC_TXTAREA', 'Multi-line Text Box');
define('_XHELP_CONTROL_DESC_SELECT', 'Select Box');
define('_XHELP_CONTROL_DESC_MULTISELECT', 'Multi-Select Box');
define('_XHELP_CONTROL_DESC_YESNO', 'Yes / No');
define('_XHELP_CONTROL_DESC_CHECKBOX', 'Checkbox');
define('_XHELP_CONTROL_DESC_RADIOBOX', 'Radiobox');
define('_XHELP_CONTROL_DESC_DATETIME', 'Date+Time');
define('_XHELP_CONTROL_DESC_FILE', 'File');

define('_XHELP_DATATYPE_TEXT', 'Text');
define('_XHELP_DATATYPE_NUMBER_INT', 'Number (INTEGER)');
define('_XHELP_DATATYPE_NUMBER_DEC', 'Number (Decimal)');
define('_XHELP_TEXT_ADMIN_DISABLED', '<em>[Disabled by Administrator]</em>');

define('_XHELP_TEXT_CURRENT_NOTIFICATION', 'Current Notification Method');
define('_XHELP_NOTIFY_METHOD1', 'Private Message');
define('_XHELP_NOTIFY_METHOD2', 'Email');

 ?>