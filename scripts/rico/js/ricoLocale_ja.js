/*****************************************************************
 ricoLocale_ja.js - a component of Rico 3
 Localization strings for Japanese
 Initial translator: Nobuhito Takeuchi
 
 If you have better translations, or would like to include translations for another language, 
 please post them on http://sourceforge.net/projects/openrico/
******************************************************************/
Rico.langCode='ja';

// used in ricoLiveGrid.js

Rico.addPhraseId('bookmarkExact',"リストのレコードは $3 件中 $1 - $2 件目です");
Rico.addPhraseId('bookmarkAbout',"リストのレコードは少なくとも $3 件中 $1 - $2 件目です");
Rico.addPhraseId('bookmarkNoRec',"レコードがありません");
Rico.addPhraseId('bookmarkNoMatch',"一致するレコードがありません");
Rico.addPhraseId('bookmarkLoading',"ロード中です...");
Rico.addPhraseId('sorting',"並べ替え中です...");
Rico.addPhraseId('exportStatus',"$1 行目をエクスポート中です");
Rico.addPhraseId('filterAll',"(すべて)");
Rico.addPhraseId('filterBlank',"(空白)");
Rico.addPhraseId('filterEmpty',"(空の)");
Rico.addPhraseId('filterNotEmpty',"(空では無い)");
Rico.addPhraseId('filterLike',"$1 を含む");
Rico.addPhraseId('filterNot',"$1 を含まない");
Rico.addPhraseId('requestError',"そのリクエストはエラーを返しました:\n$1");
Rico.addPhraseId('keywordPrompt',"検索するキーワードを入力して下さい ( * はワイルドカードとして利用されます):");

// used in ricoLiveGridMenu.js

Rico.addPhraseId('gridmenuSortBy',"$1 を並べ替え");
Rico.addPhraseId('gridmenuSortAsc',"昇順");
Rico.addPhraseId('gridmenuSortDesc',"降順");
Rico.addPhraseId('gridmenuFilterBy',"$1 をフィルタ");
Rico.addPhraseId('gridmenuRefresh',"再描画");
Rico.addPhraseId('gridmenuChgKeyword',"キーワードの変更...");
Rico.addPhraseId('gridmenuExcludeAlso',"この値も含まない");
Rico.addPhraseId('gridmenuInclude',"この値のみを含む");
Rico.addPhraseId('gridmenuGreaterThan',"この値以上");
Rico.addPhraseId('gridmenuLessThan',"この値以下");
Rico.addPhraseId('gridmenuContains',"このキーワードを含む...");
Rico.addPhraseId('gridmenuExclude',"この値を含まない");
Rico.addPhraseId('gridmenuRemoveFilter',"フィルタを取り除く");
Rico.addPhraseId('gridmenuRemoveAll',"すべてのフィルタを取り除く");

Rico.addPhraseId('gridmenuExport',"インポート/エクスポート");
Rico.addPhraseId('gridmenuExportVis2Web',"表示されている行をウェブページへ");
Rico.addPhraseId('gridmenuExportAll2Web',"すべての行をウェブページへ");
Rico.addPhraseId('gridmenuExportVis2SS',"表示されている行をスプレッドシートへ");
Rico.addPhraseId('gridmenuExportAll2SS',"すべての行をスプレッドシートへ");

Rico.addPhraseId('gridmenuHideShow',"非表示/表示");
Rico.addPhraseId('gridmenuChooseCols',"列を選択...");
Rico.addPhraseId('gridmenuHide',"$1 を非表示");
Rico.addPhraseId('gridmenuShow',"$1 を表示");
Rico.addPhraseId('gridmenuShowAll',"すべて表示");

// used in ricoLiveGridAjax.js

Rico.addPhraseId('sessionExpireMinutes',"セッションが終了するまでの分数");
Rico.addPhraseId('sessionExpired',"終了");
Rico.addPhraseId('requestTimedOut',"データのリクエストが終了しました");
Rico.addPhraseId('waitForData',"データを待っています...");
Rico.addPhraseId('httpError',"HTTP エラーを受け取りました: $1");
Rico.addPhraseId('invalidResponse',"サーバは無効なレスポンスを返しました");

// used in ricoLiveGridCommon.js

Rico.addPhraseId('gridChooseCols',"列を選択して下さい");
Rico.addPhraseId('exportComplete',"エクスポートが完了しました");
Rico.addPhraseId('exportInProgress',"エクスポートの実行中です...");

// used in ricoLiveGridForms.js

Rico.addPhraseId('selectNone',"(無し)");
Rico.addPhraseId('selectNewVal',"(新しい値)");
Rico.addPhraseId('record',"レコード");
Rico.addPhraseId('thisRecord',"この $1");
Rico.addPhraseId('confirmDelete',"$1 を本当に削除してよろしいですか?");
Rico.addPhraseId('deleting',"削除しています...");
Rico.addPhraseId('formPleaseEnter',"$1 を入力して下さい");
Rico.addPhraseId('formInvalidFmt',"$1 は無効なフォーマットです");
Rico.addPhraseId('formOutOfRange',"$1 は範囲外です");
Rico.addPhraseId('formNewValue',"新しい値:");
Rico.addPhraseId('saving',"保存しています...");
Rico.addPhraseId('clear',"消去");
Rico.addPhraseId('close',"閉じる");
Rico.addPhraseId('saveRecord',"$1 の保存");
Rico.addPhraseId('cancel',"キャンセル");
Rico.addPhraseId('editRecord',"$1 を編集します");
Rico.addPhraseId('deleteRecord',"$1 を削除します");
Rico.addPhraseId('cloneRecord',"$1 の複製を作成します");
Rico.addPhraseId('addRecord',"$1 を追加します");
Rico.addPhraseId('addedSuccessfully',"$1 の追加に成功しました");
Rico.addPhraseId('deletedSuccessfully',"$1 の削除に成功しました");
Rico.addPhraseId('updatedSuccessfully',"$1 の更新に成功しました");

// used in ricoTree.js

Rico.addPhraseId('treeSave',"選択項目を保存");
Rico.addPhraseId('treeClear',"すべて消去");

// used in ricoCalendar.js

Rico.addPhraseId('calToday',"今日は $3 年 $4 月 $1 日です");
Rico.addPhraseId('calWeekHdg',"曜日");
Rico.addPhraseId('calYearRange',"$1 年 - $2 年"); 
Rico.addPhraseId('calInvalidYear',"無効な年です");

// Date & number formats

Rico.thouSep=","
Rico.decPoint="."
Rico.dateFmt="yyyy年mm月dd日"

Rico.monthNames=['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'];
Rico.monthNamesShort=['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'];
Rico.dayNames=['日曜日','月曜日','火曜日','水曜日','木曜日','金曜日','土曜日'];
Rico.dayNamesShort=['日','月','火','水','木','金','土'];

Rico.includeLoaded('ricoLocale_ja.js');
