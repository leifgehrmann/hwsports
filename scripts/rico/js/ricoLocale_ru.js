/*****************************************************************
 Page : ricoLocale_ru.js
 Description : russian localization strings
 Version 0.1 (revisions by Alexey Uvarov,Illiya Gannitskiy)
 
 If you have better translations, or would like to include translations for another language, 
 please post them on http://sourceforge.net/projects/openrico/
******************************************************************/
Rico.langCode='ru';

// used in ricoLiveGrid.js

Rico.addPhraseId('bookmarkExact',"Просмотр записей $1 - $2 из $3");
Rico.addPhraseId('bookmarkAbout',"Просмотр записей $1 - $2 из более чем $3");
Rico.addPhraseId('bookmarkNoRec',"Нет записей");
Rico.addPhraseId('bookmarkNoMatch',"Нет совпадений");
Rico.addPhraseId('bookmarkLoading',"Загрузка...");
Rico.addPhraseId('sorting',"Сортировка...");
Rico.addPhraseId('exportStatus',"Экспортируется запись $1");
Rico.addPhraseId('filterAll',"(все)");
Rico.addPhraseId('filterBlank',"(чистый)");
Rico.addPhraseId('filterEmpty',"(пустой)");
Rico.addPhraseId('filterNotEmpty',"(не пустой)");
Rico.addPhraseId('filterLike',"как: $1");
Rico.addPhraseId('filterNot',"не: $1");
Rico.addPhraseId('requestError',"Запрос данных возвратил ошибку:\n$1");
Rico.addPhraseId('keywordPrompt',"Искать по ключу (Используйте * для всех записей):");
Rico.addPhraseId('apply',"Применить");

// used in ricoLiveGridMenu.js

Rico.addPhraseId('gridmenuSortBy',"Сортировка по: $1");
Rico.addPhraseId('gridmenuSortAsc',"Возрастающая");
Rico.addPhraseId('gridmenuSortDesc',"Убывающая");
Rico.addPhraseId('gridmenuFilterBy',"Фильтрация по: $1");
Rico.addPhraseId('gridmenuRefresh',"Обновить");
Rico.addPhraseId('gridmenuChgKeyword',"Изменить ключевое слово...");
Rico.addPhraseId('gridmenuExcludeAlso',"Исключить также это значение");
Rico.addPhraseId('gridmenuInclude',"Включить только это значение");
Rico.addPhraseId('gridmenuGreaterThan',"Больше либо равно данному значению");
Rico.addPhraseId('gridmenuLessThan',"Меньше либо равно данному значению");
Rico.addPhraseId('gridmenuContains',"Содержит значение...");
Rico.addPhraseId('gridmenuExclude',"Исключить это значение");
Rico.addPhraseId('gridmenuRemoveFilter',"Удалить фильтр");
Rico.addPhraseId('gridmenuRemoveAll',"Удалить все фильтры");

Rico.addPhraseId('gridmenuExport',"Печать/Экспорт");
Rico.addPhraseId('gridmenuExportVis2Web',"Видимые записи на вэб-страницу");
Rico.addPhraseId('gridmenuExportAll2Web',"Все записи на вэб-страницу");
Rico.addPhraseId('gridmenuExportVis2SS',"Видимые записи в лист excel");
Rico.addPhraseId('gridmenuExportAll2SS',"Все записи в лист excel");

Rico.addPhraseId('gridmenuHideShow',"Скрыть/Показать");
Rico.addPhraseId('gridmenuChooseCols',"Выберите столбец...");
Rico.addPhraseId('gridmenuHide',"Скрыть: $1");
Rico.addPhraseId('gridmenuShow',"Показать: $1");
Rico.addPhraseId('gridmenuShowAll',"Показать все");

// used in ricoLiveGridAjax.js

Rico.addPhraseId('sessionExpireMinutes',"минут до истечения сессии");
Rico.addPhraseId('sessionExpired',"ИСТЕКЛА");
Rico.addPhraseId('requestTimedOut',"Превышен интервал ожидания данных!");
Rico.addPhraseId('waitForData',"Ожидание данных...");
Rico.addPhraseId('httpError',"Получена HTTP ошибка: $1");
Rico.addPhraseId('invalidResponse',"Сервер возвратил неправильный ответ");

// used in ricoLiveGridCommon.js

Rico.addPhraseId('gridChooseCols',"Выбрать столбец");
Rico.addPhraseId('exportComplete',"Экспорт завершен");
Rico.addPhraseId('exportInProgress',"Экспортирование...");
Rico.addPhraseId('showFilterRow',"Показать отфильтрованные записи");  // img alt text
Rico.addPhraseId('hideFilterRow',"Спрятать отфильтрованные записи");  // img alt text

// used in ricoLiveGridForms.js

Rico.addPhraseId('selectNone',"(ничего)");
Rico.addPhraseId('selectNewVal',"(новое значение)");
Rico.addPhraseId('record',"запись");
Rico.addPhraseId('thisRecord',"эта $1");
Rico.addPhraseId('confirmDelete',"Вы уверенны, что хотите удалить $1?");
Rico.addPhraseId('deleting',"Удаление...");
Rico.addPhraseId('formPleaseEnter',"Пожалуйста, введите значение для $1");
Rico.addPhraseId('formInvalidFmt',"Неправильный формат для $1");
Rico.addPhraseId('formOutOfRange',"Значение находится вне диапазона для $1");
Rico.addPhraseId('formNewValue',"новое значение:");
Rico.addPhraseId('saving',"Сохранение...");
Rico.addPhraseId('clear',"очистить");
Rico.addPhraseId('close',"Закрыть");
Rico.addPhraseId('saveRecord',"Сохранить $1");
Rico.addPhraseId('cancel',"Отмена");
Rico.addPhraseId('editRecord',"Редактировать эту $1");
Rico.addPhraseId('deleteRecord',"Удалить эту $1");
Rico.addPhraseId('cloneRecord',"Копировать эту $1");
Rico.addPhraseId('addRecord',"Добавить новую $1");
Rico.addPhraseId('addedSuccessfully',"$1 добавлена успешно");
Rico.addPhraseId('deletedSuccessfully',"$1 удалена успешно");
Rico.addPhraseId('updatedSuccessfully',"$1 обновлена успешно");

// used in ricoTree.js

Rico.addPhraseId('treeSave',"Сохранить выделение");
Rico.addPhraseId('treeClear',"Очистить все");

// used in ricoCalendar.js

Rico.addPhraseId('calToday',"Сегодня $1 $2 $3");  // $1=day, $2=monthabbr, $3=year, $4=month number
Rico.addPhraseId('calWeekHdg',"Нд");
Rico.addPhraseId('calYearRange',"Год ($1-$2)");
Rico.addPhraseId('calInvalidYear',"Неправильный год");

// Date & number formats

Rico.thouSep=",";
Rico.decPoint=".";
Rico.dateFmt="mm/dd/yyyy";

Rico.monthNames=['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'];
Rico.dayNames=['Воскресенье','Понедельник','Вторник','Среда','Четверг','Пятница','Суббота'];
Rico.monthNamesShort=['Янв','Фев','Мар','Апр','Май','Июн','Июл','Авг','Сен','Окт','Ноя','Дек'];
Rico.dayNamesShort=['вск','пнд','втр','срд','чтв','птн','сбт'];

