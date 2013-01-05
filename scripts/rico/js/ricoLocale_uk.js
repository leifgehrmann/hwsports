/*****************************************************************
 Page : ricoLocale_uk.js
 Description : ukrainian localization strings
 Version 0.1 (revisions by Alexey Uvarov,Illiya Gannitskiy)
 
 If you have better translations, or would like to include translations for another language, 
 please post them on http://sourceforge.net/projects/openrico/
******************************************************************/
Rico.langCode='uk';  // uk-UA

// used in ricoLiveGrid.js

Rico.addPhraseId('bookmarkExact',"Перегляд записів $1 - $2 з $3");
Rico.addPhraseId('bookmarkAbout',"Перегляд записів $1 - $2 з більш ніж $3");
Rico.addPhraseId('bookmarkNoRec',"Немає записів");
Rico.addPhraseId('bookmarkNoMatch',"Немає збігів");
Rico.addPhraseId('bookmarkLoading',"Завантаження...");
Rico.addPhraseId('sorting',"Сортування...");
Rico.addPhraseId('exportStatus',"Експортується запис $1");
Rico.addPhraseId('filterAll',"(всі)");
Rico.addPhraseId('filterBlank',"(чистий)");
Rico.addPhraseId('filterEmpty',"(порожній)");
Rico.addPhraseId('filterNotEmpty',"(не порожній)");
Rico.addPhraseId('filterLike',"як: $1");
Rico.addPhraseId('filterNot',"не: $1");
Rico.addPhraseId('requestError',"Запит даних повернув помилку:\n$1");
Rico.addPhraseId('keywordPrompt',"Шукати по ключу (Використовуйте * для всіх записів):");

// used in ricoLiveGridMenu.js

Rico.addPhraseId('gridmenuSortBy',"Сортування по: $1");
Rico.addPhraseId('gridmenuSortAsc',"Зростаюча");
Rico.addPhraseId('gridmenuSortDesc',"Убутна");
Rico.addPhraseId('gridmenuFilterBy',"Фільтрація по: $1");
Rico.addPhraseId('gridmenuRefresh',"Обновити");
Rico.addPhraseId('gridmenuChgKeyword',"Змінити ключове слово...");
Rico.addPhraseId('gridmenuExcludeAlso',"Виключити також це значення");
Rico.addPhraseId('gridmenuInclude',"Включити тільки це значення");
Rico.addPhraseId('gridmenuGreaterThan',"Більше або дорівнює даному значенню");
Rico.addPhraseId('gridmenuLessThan',"Менше або дорівнює даному значенню");
Rico.addPhraseId('gridmenuContains',"Містить значення...");
Rico.addPhraseId('gridmenuExclude',"Виключити це значення");
Rico.addPhraseId('gridmenuRemoveFilter',"Вилучити фільтр");
Rico.addPhraseId('gridmenuRemoveAll',"Вилучити всі фільтри");

Rico.addPhraseId('gridmenuExport',"Друк/Експорт");
Rico.addPhraseId('gridmenuExportVis2Web',"Видимі записи на веб-сторінку");
Rico.addPhraseId('gridmenuExportAll2Web',"Усі записи на веб-сторінку");
Rico.addPhraseId('gridmenuExportVis2SS',"Видимі записи в аркуш excel");
Rico.addPhraseId('gridmenuExportAll2SS',"Усі записи в аркуш excel");

Rico.addPhraseId('gridmenuHideShow',"Сховати/Показати");
Rico.addPhraseId('gridmenuChooseCols',"Виберіть колонку...");
Rico.addPhraseId('gridmenuHide',"Сховати: $1");
Rico.addPhraseId('gridmenuShow',"Показати: $1");
Rico.addPhraseId('gridmenuShowAll',"Показати всі");

// used in ricoLiveGridAjax.js

Rico.addPhraseId('sessionExpireMinutes',"хвилин до закінчення сесії");
Rico.addPhraseId('sessionExpired',"МИНУЛА");
Rico.addPhraseId('requestTimedOut',"Перевищений інтервал очікування даних!");
Rico.addPhraseId('waitForData',"Очікування даних...");
Rico.addPhraseId('httpError',"Отримана HTTP помилка: $1");
Rico.addPhraseId('invalidResponse',"Сервер повернув неправильну відповідь");

// used in ricoLiveGridCommon.js

Rico.addPhraseId('gridChooseCols',"Вибрати колонку");
Rico.addPhraseId('exportComplete',"Експорт завершений");
Rico.addPhraseId('exportInProgress',"Експортування...");
Rico.addPhraseId('showFilterRow',"Показати відфільтровані записи");  // img alt text
Rico.addPhraseId('hideFilterRow',"Сховати відфільтровані записи");  // img alt text

// used in ricoLiveGridForms.js

Rico.addPhraseId('selectNone',"(нічого)");
Rico.addPhraseId('selectNewVal',"(нове значення)");
Rico.addPhraseId('record',"запис");
Rico.addPhraseId('thisRecord',"ця $1");
Rico.addPhraseId('confirmDelete',"Ви впевнені,що бажаєте видалити $1?");
Rico.addPhraseId('deleting',"Видалення...");
Rico.addPhraseId('formPleaseEnter',"Будь ласка, введіть значення для $1");
Rico.addPhraseId('formInvalidFmt',"Неправильний формат для $1");
Rico.addPhraseId('formOutOfRange',"Значення знаходиться поза діапазоном для $1");
Rico.addPhraseId('formNewValue',"нове значення:");
Rico.addPhraseId('saving',"Збереження...");
Rico.addPhraseId('clear',"очистити");
Rico.addPhraseId('close',"Закрити");
Rico.addPhraseId('saveRecord',"Зберегти $1");
Rico.addPhraseId('cancel',"Скасування");
Rico.addPhraseId('editRecord',"Редагувати цю $1");
Rico.addPhraseId('deleteRecord',"Вилучити цю $1");
Rico.addPhraseId('cloneRecord',"Копіювати цю $1");
Rico.addPhraseId('addRecord',"Додати нову $1");
Rico.addPhraseId('addedSuccessfully',"$1 додана успішно");
Rico.addPhraseId('deletedSuccessfully',"$1 вилучена успішно");
Rico.addPhraseId('updatedSuccessfully',"$1 оновлена успішно");

// used in ricoTree.js

Rico.addPhraseId('treeSave',"Зберегти виділення");
Rico.addPhraseId('treeClear',"Очистити все");

// used in ricoCalendar.js

Rico.addPhraseId('calToday',"Сьогодні $1 $2 $3");  // $1=day, $2=monthabbr, $3=year, $4=month number
Rico.addPhraseId('calWeekHdg',"Тд");
Rico.addPhraseId('calYearRange',"Рік ($1-$2)");
Rico.addPhraseId('calInvalidYear',"Неправильний рік");

// Date & number formats

Rico.thouSep=",";
Rico.decPoint=".";
Rico.dateFmt="dd/mm/yyyy";

Rico.monthNames=['Січень','Лютий','Березень','Квітень','Травень','Червень','Липень','Серпень','Вересень','Жовтень','Листопад','Грудень'];
Rico.monthNamesShort=['Січ','Лют','Бер','Кві','Тра','Чер','Лип','Сер','Вер','Жов','Лис','Гру'];
Rico.dayNames=['неділя','понеділок','вівторок','середа','четвер','п’ятниця','субота'];
Rico.dayNamesShort=['нед','пнд','вів','срд','чтв','птн','сбт'];
