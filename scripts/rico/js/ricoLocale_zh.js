/*****************************************************************
 ricoLocale_zh.js - a component of Rico 3
 Localization strings for Simplified Chinese
 Initial translator: Xinjun Liu
 
 If you have better translations, or would like to include translations for another language, 
 please post them on http://sourceforge.net/projects/openrico/
******************************************************************/
Rico.langCode='zh';

// used in ricoLiveGrid.js

Rico.addPhraseId('bookmarkExact',"第 $1 - $2 条记录(总计$3条)");
Rico.addPhraseId('bookmarkAbout',"第 $1 - $2 条记录(总数超过$3条)");
Rico.addPhraseId('bookmarkNoRec',"未发现记录");
Rico.addPhraseId('bookmarkNoMatch',"未找到匹配的记录");
Rico.addPhraseId('bookmarkLoading',"正在加载...");
Rico.addPhraseId('sorting',"正在排序...");
Rico.addPhraseId('exportStatus',"导出第 $1 行");
Rico.addPhraseId('filterAll',"(所有)");
Rico.addPhraseId('filterBlank',"(空白)");
Rico.addPhraseId('filterEmpty',"(空值)");
Rico.addPhraseId('filterNotEmpty',"(非空)");
Rico.addPhraseId('filterLike',"类似于: $1");
Rico.addPhraseId('filterNot',"非: $1");
Rico.addPhraseId('requestError',"该请求返回一个错误:\n$1");
Rico.addPhraseId('keywordPrompt',"请输入搜索词(可使用通配符*):");
Rico.addPhraseId('apply',"Apply");

// used in ricoLiveGridMenu.js

Rico.addPhraseId('gridmenuSortBy',"排序 依据:$1");
Rico.addPhraseId('gridmenuSortAsc',"升序");
Rico.addPhraseId('gridmenuSortDesc',"降序");
Rico.addPhraseId('gridmenuFilterBy',"过滤 依据:     $1");
Rico.addPhraseId('gridmenuRefresh',"刷新");
Rico.addPhraseId('gridmenuChgKeyword',"更改搜索词...");
Rico.addPhraseId('gridmenuExcludeAlso',"不包括此值");
Rico.addPhraseId('gridmenuInclude',"只包括此值");
Rico.addPhraseId('gridmenuGreaterThan',"大于或等于此值");
Rico.addPhraseId('gridmenuLessThan',"小于或等于此值");
Rico.addPhraseId('gridmenuContains',"包含关键字...");
Rico.addPhraseId('gridmenuExclude',"不包括此值");
Rico.addPhraseId('gridmenuRemoveFilter',"移除过滤器");
Rico.addPhraseId('gridmenuRemoveAll',"移除所有过滤器");

Rico.addPhraseId('gridmenuExport',"打印/输出");
Rico.addPhraseId('gridmenuExportVis2Web',"输出可见行至网页");
Rico.addPhraseId('gridmenuExportAll2Web',"输出所有行至网页");
Rico.addPhraseId('gridmenuExportVis2SS',"输出可见行至表格");
Rico.addPhraseId('gridmenuExportAll2SS',"输出所有行至表格");

Rico.addPhraseId('gridmenuHideShow',"隐藏/显示");
Rico.addPhraseId('gridmenuChooseCols',"选择以下列...");
Rico.addPhraseId('gridmenuHide',"隐藏: $1");
Rico.addPhraseId('gridmenuShow',"显示: $1");
Rico.addPhraseId('gridmenuShowAll',"显示所有");

// used in ricoLiveGridAjax.js

Rico.addPhraseId('sessionExpireMinutes',"分钟后您的会话将过期");
Rico.addPhraseId('sessionExpired',"已过期");
Rico.addPhraseId('requestTimedOut',"数据传输超时!");
Rico.addPhraseId('waitForData',"正在加载数据...");
Rico.addPhraseId('httpError',"接收到HTTP错误: $1");
Rico.addPhraseId('invalidResponse',"服务器返回一个无效的响应");

// used in ricoLiveGridCommon.js

Rico.addPhraseId('gridChooseCols',"选择以下列...");
Rico.addPhraseId('exportComplete',"输出完成！");
Rico.addPhraseId('exportInProgress',"正在输出...");
Rico.addPhraseId('showFilterRow',"显示被过滤的行");  // img alt text
Rico.addPhraseId('hideFilterRow',"隐藏被过滤的行");  // img alt text

// used in ricoLiveGridForms.js

Rico.addPhraseId('ok',"OK");
Rico.addPhraseId('selectNone',"(无)");
Rico.addPhraseId('selectNewVal',"(新值)");
Rico.addPhraseId('record',"记录");
Rico.addPhraseId('thisRecord',"该 $1");
Rico.addPhraseId('confirmDelete',"您确定要删除 $1 吗?");
Rico.addPhraseId('deleting',"正在删除...");
Rico.addPhraseId('formPleaseEnter',"请输入 $1 的值");
Rico.addPhraseId('formInvalidFmt',"不符合 $1 的格式");
Rico.addPhraseId('formOutOfRange',"值超出 $1 的范围");
Rico.addPhraseId('formNewValue',"新值:");
Rico.addPhraseId('saving',"正在保存...");
Rico.addPhraseId('clear',"清除");
Rico.addPhraseId('close',"关闭");
Rico.addPhraseId('saveRecord',"保存");
Rico.addPhraseId('cancel',"撤销");
Rico.addPhraseId('editRecord',"编辑"); //$1 ommited
Rico.addPhraseId('deleteRecord',"删除"); //$1 ommited
Rico.addPhraseId('cloneRecord',"克隆");//$1 ommited
Rico.addPhraseId('addRecord',"添加");   //$1 ommited
Rico.addPhraseId('addedSuccessfully',"$1 添加成功");
Rico.addPhraseId('deletedSuccessfully',"$1 删除成功");
Rico.addPhraseId('updatedSuccessfully',"$1 更新成功");

// used in ricoTree.js

Rico.addPhraseId('treeSave',"保存选择");
Rico.addPhraseId('treeClear',"全部清除");

// used in ricoCalendar.js

Rico.addPhraseId('calToday',"今天是 $3 年 $4 月 $1 日");  // $1=day, $2=monthabbr, $3=year, $4=month number
Rico.addPhraseId('calWeekHdg',"星期");
Rico.addPhraseId('calYearRange',"$1年 - $2年");
Rico.addPhraseId('calInvalidYear',"无效的年份");

// Date & number formats

Rico.thouSep=",";
Rico.decPoint=".";
Rico.dateFmt="yyyy年mm月dd日";

Rico.monthNames=['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月'];
Rico.monthNamesShort=['一','二','三','四','五','六','七','八','九','十','十一','十二'];
Rico.dayNames=['星期日','星期一','星期二','星期三','星期四','星期五','星期六'];
Rico.dayNamesShort=['周日','周一','周二','周三','周四','周五','周六'];

Rico.includeLoaded('ricoLocale_zh.js');
