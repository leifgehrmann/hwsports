/*****************************************************************
 ricoLocale_de.js - a component of Rico 2.x & 3.x
 Localization strings for German
 Initial translator: rainer@langheiter@.com
 May 08: minor changes by klaus
 
 If you have better translations, or would like to include translations for another language, 
 please post them on http://sourceforge.net/projects/openrico/
******************************************************************/
Rico.langCode='de';

// used in ricoLiveGrid.js

Rico.addPhraseId('bookmarkExact',"Zeige Einträge $1 - $2 von $3");
Rico.addPhraseId('bookmarkAbout',"Zeige Einträge $1 - $2 von ungefähr $3");
Rico.addPhraseId('bookmarkNoRec',"Keine Einträge");
Rico.addPhraseId('bookmarkNoMatch',"Keine übereinstimmenden Einträge");
Rico.addPhraseId('bookmarkLoading',"Lade...");
Rico.addPhraseId('sorting',"Daten werden sortiert ...");
Rico.addPhraseId('exportStatus',"Exportieren der Reihe $1");
Rico.addPhraseId('filterAll',"(alle)");
Rico.addPhraseId('filterBlank',"(freier Raum)");
Rico.addPhraseId('filterEmpty',"(leer)");
Rico.addPhraseId('filterNotEmpty',"(nicht leer)");
Rico.addPhraseId('filterLike',"wie: $1");
Rico.addPhraseId('filterNot',"nicht: $1");
Rico.addPhraseId('requestError',"Die Anfrage ergab einen Fehler:\n$1");
Rico.addPhraseId('keywordPrompt',"Schlüsselwort eintragen, nach dem gesucht werden soll (verwende * als Wildcard):");
Rico.addPhraseId('apply',"Übernehmen");

// used in ricoLiveGridMenu.js

Rico.addPhraseId('gridmenuSortBy',"Sortiert nach: $1");
Rico.addPhraseId('gridmenuSortAsc',"Aufsteigend");
Rico.addPhraseId('gridmenuSortDesc',"Absteigend");
Rico.addPhraseId('gridmenuFilterBy',"Gefiltert nach: $1");
Rico.addPhraseId('gridmenuRefresh',"erneuern Sie");
Rico.addPhraseId('gridmenuChgKeyword',"Schlüsselwort ändern...");
Rico.addPhraseId('gridmenuExcludeAlso',"Diesen Wert ebenfalls ausschließen");
Rico.addPhraseId('gridmenuInclude',"Nur diesen Wert einbeziehen");
Rico.addPhraseId('gridmenuGreaterThan',"Größer oder gleich diesem Wert");
Rico.addPhraseId('gridmenuLessThan',"Kleiner oder gleich diesem wert");
Rico.addPhraseId('gridmenuContains',"Enthält Schlüsselwort...");
Rico.addPhraseId('gridmenuExclude',"Diesen Wert ausschließen");
Rico.addPhraseId('gridmenuRemoveFilter',"Entferne Filter");
Rico.addPhraseId('gridmenuRemoveAll',"Entfernen Sie alle Filter");

Rico.addPhraseId('gridmenuExport',"Druck/Exportiert");
Rico.addPhraseId('gridmenuExportVis2Web',"Sichtbare Zeilen auf eine Webseite");
Rico.addPhraseId('gridmenuExportAll2Web',"Alle Zeilen auf eine Webseite");
Rico.addPhraseId('gridmenuExportVis2SS',"Sichtbare Zeilen in einen Verteilungsbogen");
Rico.addPhraseId('gridmenuExportAll2SS',"Alle Zeilen in einen Verteilungsbogen");

Rico.addPhraseId('gridmenuHideShow',"Verbergen/Zeigen");
Rico.addPhraseId('gridmenuChooseCols',"Wählen Sie die Spalten...");
Rico.addPhraseId('gridmenuHide',"Verbergen: $1");
Rico.addPhraseId('gridmenuShow',"Zeige: $1");
Rico.addPhraseId('gridmenuShowAll',"Alle zeigen");

// used in ricoLiveGridAjax.js

Rico.addPhraseId('sessionExpireMinutes',"Minuten bis zum Ablauf Ihrer Sitzung.");
Rico.addPhraseId('sessionExpired',"ABGELAUFEN");
Rico.addPhraseId('requestTimedOut',"Zeitüberschreitung");
Rico.addPhraseId('waitForData',"Warte auf Daten ...");
Rico.addPhraseId('httpError',"Die Anfrage ergab einen Fehler HTTP: $1");
Rico.addPhraseId('invalidResponse',"Der Server brachte eine unzulässige Antwort zurück");

// used in ricoLiveGridCommon.js

Rico.addPhraseId('gridChooseCols',"Wählen Sie die Spalten");
Rico.addPhraseId('exportComplete',"der Export ist komplett");
Rico.addPhraseId('exportInProgress',"der Export läuft ...");
Rico.addPhraseId('showFilterRow',"Filter-Reihe zeigen");
Rico.addPhraseId('hideFilterRow',"Filter-Reile verbergen");

// used in ricoLiveGridForms.js

Rico.addPhraseId('selectNone',"(keine)");
Rico.addPhraseId('selectNewVal',"(neuer Wert)");
Rico.addPhraseId('record',"die Eintragung");
Rico.addPhraseId('thisRecord',"diesen Eintrag");
Rico.addPhraseId('confirmDelete',"Möchten Sie dies wirklich löschen $1?");
Rico.addPhraseId('deleting',"Löschen läuft ...");
Rico.addPhraseId('formPleaseEnter',"Geben Sie bitte einen Wert ein für $1");
Rico.addPhraseId('formInvalidFmt',"unzulässiges Format bei $1");
Rico.addPhraseId('formOutOfRange',"Ungültiger (zu großer) Wert bei $1");
Rico.addPhraseId('formNewValue',"neuer Wert:");
Rico.addPhraseId('saving',"sichere ...");
Rico.addPhraseId('clear',"Löschtaste");
Rico.addPhraseId('close',"Schließen");
Rico.addPhraseId('saveRecord',"Speichere");
Rico.addPhraseId('cancel',"Abbrechen");
Rico.addPhraseId('editRecord',"Bearbeiten Sie diesen Eintrag");
Rico.addPhraseId('deleteRecord',"Löschen Sie diesen Eintrag");
Rico.addPhraseId('cloneRecord',"Kopieren Sie diesen Eintrag");
Rico.addPhraseId('addRecord',"Erstellen Sie einen neuen Eintrag");
Rico.addPhraseId('addedSuccessfully',"$1 wurde erfolgreich addiert");
Rico.addPhraseId('deletedSuccessfully',"$1 wurde erfolgreich gelöscht");
Rico.addPhraseId('updatedSuccessfully',"$1 wurde erfolgreich aktualisiert");

// used in ricoTree.js

Rico.addPhraseId('treeSave',"Auswahl speichern");
Rico.addPhraseId('treeClear',"Alles löschen");

// used in ricoCalendar.js

Rico.addPhraseId('calToday',"Heute ist der $1 $2 $3");
Rico.addPhraseId('calWeekHdg',"Woche");
Rico.addPhraseId('calYearRange',"Jahr ($1-$2)");
Rico.addPhraseId('calInvalidYear',"unzulässiges Jahr");

// Date & number formats

Rico.monthNames=["Januar", "Februar", "März", "April", "Mai","Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"];
Rico.dayNames=["Sonntag", "Montag","Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag"];
Rico.monthNamesShort=['Jan','Feb','Mär','Apr','Mai','Jun','Jul','Aug','Sep','Okt','Nov','Dez'];
Rico.dayNamesShort=['So','Mo','Di','Mi','Do','Fr','Sa'];

Rico.thouSep="."
Rico.decPoint=","
Rico.dateFmt="dd.mm.yyyy"

Rico.includeLoaded('ricoLocale_de.js');
