/*****************************************************************
 ricoLocale_ko.js - a component of Rico 3
 Localization strings for Korean
 
 If you have better translations, or would like to include translations for another language, 
 please post them on http://sourceforge.net/projects/openrico/
******************************************************************/
Rico.langCode='ko';

// used in ricoLiveGrid.js

Rico.addPhraseId('bookmarkExact',"총 $3 중 $1 ~ $2");
Rico.addPhraseId('bookmarkAbout',"총 약 $3 중 $1 ~ $2");
Rico.addPhraseId('bookmarkNoRec',"자료가 없습니다.");
Rico.addPhraseId('bookmarkNoMatch',"조건에 일치하는 자료가 없습니다.");
Rico.addPhraseId('bookmarkLoading',"불러오는 중...");
Rico.addPhraseId('sorting',"정렬 중...");
Rico.addPhraseId('exportStatus',"$1 번째 열을 전달하고 있습니다.");
Rico.addPhraseId('filterAll',"(모두)");
Rico.addPhraseId('filterBlank',"(없슴)");
Rico.addPhraseId('filterEmpty',"(빈)");
Rico.addPhraseId('filterNotEmpty',"(비지 않은)");
Rico.addPhraseId('filterLike',"$1 과 유사한");
Rico.addPhraseId('filterNot',"$1 이 아닌");
Rico.addPhraseId('requestError',"입력하신 요청이 오류를 반환했습니다:\n$1");
Rico.addPhraseId('keywordPrompt',"찿으시려는 키워드를 입력하십시오. ( * 키도 사용하실 수 있습니다.):");

// used in ricoLiveGridMenu.js

Rico.addPhraseId('gridmenuSortBy',"$1 으로 정렬");
Rico.addPhraseId('gridmenuSortAsc',"오름차순");
Rico.addPhraseId('gridmenuSortDesc',"내림차순");
Rico.addPhraseId('gridmenuFilterBy',"$1 으로 찾기");
Rico.addPhraseId('gridmenuRefresh',"다시보기");
Rico.addPhraseId('gridmenuChgKeyword',"키워드 바꾸기...");
Rico.addPhraseId('gridmenuExcludeAlso',"이 값도 제외");
Rico.addPhraseId('gridmenuInclude',"이 값만 포함");
Rico.addPhraseId('gridmenuGreaterThan',"이 값보다 크거나 같다.");
Rico.addPhraseId('gridmenuLessThan',"이 값보다 작거나 같다.");
Rico.addPhraseId('gridmenuContains',"값(키워드)을 포함.");
Rico.addPhraseId('gridmenuExclude',"이 값은 제외.");
Rico.addPhraseId('gridmenuRemoveFilter',"필터 없애기");
Rico.addPhraseId('gridmenuRemoveAll',"모든 필터 없애기");

Rico.addPhraseId('gridmenuExport',"인쇄/내보내기");
Rico.addPhraseId('gridmenuExportVis2Web',"보이는 행 웹페이지로");
Rico.addPhraseId('gridmenuExportAll2Web',"모든 행 웹페이지로");
Rico.addPhraseId('gridmenuExportVis2SS',"보이는 행 계산판으로(엑셀)로");
Rico.addPhraseId('gridmenuExportAll2SS',"모든 행 계산판으로(엑셀)로");

Rico.addPhraseId('gridmenuHideShow',"숨기기/보이기");
Rico.addPhraseId('gridmenuChooseCols',"열 선택...");
Rico.addPhraseId('gridmenuHide',"$1 숨기기");
Rico.addPhraseId('gridmenuShow',"$1 보이기");
Rico.addPhraseId('gridmenuShowAll',"모두 보이기");

// used in ricoLiveGridAjax.js

Rico.addPhraseId('sessionExpireMinutes',"분 남았습니다. (세션)");
//could you please, change the above format in this way? $1 minutes before ........
Rico.addPhraseId('sessionExpired',"끝났습니다.");
Rico.addPhraseId('requestTimedOut',"자료요청이 제한 시간을 초과했습니다!");
Rico.addPhraseId('waitForData',"자료를 기다리고 있습니다......");
Rico.addPhraseId('httpError',"HTTP 오류를 받았습니다: $1");
Rico.addPhraseId('invalidResponse',"서버가 부적절한 답변을 보냈습니다.");

// used in ricoLiveGridCommon.js

Rico.addPhraseId('gridChooseCols',"열 선택");
Rico.addPhraseId('exportComplete',"내보내기 완료.");
Rico.addPhraseId('exportInProgress',"내보내는 중입니다.");
Rico.addPhraseId('showFilterRow',"필터 행 보이기");  // img alt text
Rico.addPhraseId('hideFilterRow',"필터 행 숨기기");  // img alt text

// used in ricoLiveGridForms.js

Rico.addPhraseId('selectNone',"(선택없슴)");
Rico.addPhraseId('selectNewVal',"(새 값)");
Rico.addPhraseId('record',"record");
Rico.addPhraseId('thisRecord',"이 $1");
Rico.addPhraseId('confirmDelete',"$1을 삭제하시겠습니까?");
Rico.addPhraseId('deleting',"삭제 중......");
Rico.addPhraseId('formPleaseEnter',"$1 에 적절한 값을 입력하십시오.");
Rico.addPhraseId('formInvalidFmt',"$1 에게 적절한 형식이 아닙니다.");
Rico.addPhraseId('formOutOfRange',"$1 에 적절한 범위를 벗어났습니다.");
Rico.addPhraseId('formNewValue',"새 값");
Rico.addPhraseId('saving',"저장 중......");
Rico.addPhraseId('clear',"비우기");
Rico.addPhraseId('close',"닫기");
Rico.addPhraseId('saveRecord',"$1 저장");
Rico.addPhraseId('cancel',"취소");
Rico.addPhraseId('editRecord',"$1 수정");
Rico.addPhraseId('deleteRecord',"$1 삭제");
Rico.addPhraseId('cloneRecord',"$1 복제");
Rico.addPhraseId('addRecord',"새 $1 추가");
Rico.addPhraseId('addedSuccessfully',"$1 은 성공적으로 추가되었습니다.");
Rico.addPhraseId('deletedSuccessfully',"$1 은 성공적으로 삭제되었습니다.");
Rico.addPhraseId('updatedSuccessfully',"$1 은 성공적으로 수정되었습니다.");

// used in ricoTree.js

Rico.addPhraseId('treeSave',"선택영역 저장");
Rico.addPhraseId('treeClear',"모두 비우기/원상태로");

// used in ricoCalendar.js

Rico.addPhraseId('calToday',"오늘은 $3년 $4월 $1일 입니다.");  // $1=day, $2=monthabbr, $3=year, $4=month number
Rico.addPhraseId('calWeekHdg',"Wk");
Rico.addPhraseId('calYearRange',"$1년 부터 $2년 까지)");
Rico.addPhraseId('calInvalidYear',"년도가 적절하지 않습니다.");


// Date & number formats
Rico.thouSep=","
Rico.decPoint="."
Rico.dateFmt="yyyy/mm/dd"

Rico.monthNames=['1월','2월', '3월', '4월', '5월','6월', '7월','8월','9월','10월','11월','12월']
Rico.dayNames=['일','월','화','수','목','금','토']
