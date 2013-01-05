/*****************************************************************
 ricoLocale_fr.js - a component of Rico 3
 Localization strings for French
 
 If you have better translations, or would like to include translations for another language, 
 please post them on http://sourceforge.net/projects/openrico/
******************************************************************/
Rico.langCode='fr';

// used in ricoLiveGrid.js

Rico.addPhraseId('bookmarkExact',"Résultats $1 - $2 de $3");
Rico.addPhraseId('bookmarkAbout',"Résultats $1 - $2 sur un total d'environ $3");
Rico.addPhraseId('bookmarkNoRec',"Aucun article");
Rico.addPhraseId('bookmarkNoMatch',"Aucun article ne correspond");
Rico.addPhraseId('bookmarkLoading',"Chargement...");
Rico.addPhraseId('sorting',"Classement...");
Rico.addPhraseId('exportStatus',"Exportation de la rangée $1");
Rico.addPhraseId('filterAll',"(tous)");
Rico.addPhraseId('filterBlank',"(blanc)");
Rico.addPhraseId('filterEmpty',"(vide)");
Rico.addPhraseId('filterNotEmpty',"(pas vide)");
Rico.addPhraseId('filterLike',"comme: $1");
Rico.addPhraseId('filterNot',"pas: $1");
Rico.addPhraseId('requestError',"La requête a retourné une erreur:\n$1");
Rico.addPhraseId('keywordPrompt',"Écrivez le mot-clé à rechercher (utiliser * comme caractère générique):");
Rico.addPhraseId('apply',"Appliquer");

// used in ricoLiveGridMenu.js

Rico.addPhraseId('gridmenuSortBy',"Trier par: $1");
Rico.addPhraseId('gridmenuSortAsc',"Croissant");
Rico.addPhraseId('gridmenuSortDesc',"Décroissant");
Rico.addPhraseId('gridmenuFilterBy',"Filtrer par: $1");
Rico.addPhraseId('gridmenuRefresh',"Recharger");
Rico.addPhraseId('gridmenuChgKeyword',"Changer le mot-clé...");
Rico.addPhraseId('gridmenuExcludeAlso',"Exclure cette valeur aussi");
Rico.addPhraseId('gridmenuInclude',"Inclure seulement cette valeur");
Rico.addPhraseId('gridmenuGreaterThan',"Supérieur ou égal à cette valeur");
Rico.addPhraseId('gridmenuLessThan',"Inférieur ou égal à cette valeur");
Rico.addPhraseId('gridmenuContains',"Contenant le mot-clé...");
Rico.addPhraseId('gridmenuExclude',"Exclure cette valeur");
Rico.addPhraseId('gridmenuRemoveFilter',"Enlever le filtre");
Rico.addPhraseId('gridmenuRemoveAll',"Enlever tous les filtres");

Rico.addPhraseId('gridmenuExport',"Imprimer/Exporter");
Rico.addPhraseId('gridmenuExportVis2Web',"Rangs visibles vers une page Web");
Rico.addPhraseId('gridmenuExportAll2Web',"Tous les rangs vers une page Web");
Rico.addPhraseId('gridmenuExportVis2SS',"Rangs visibles vers un bilan");
Rico.addPhraseId('gridmenuExportAll2SS',"Tous les rangs vers un bilan");

Rico.addPhraseId('gridmenuHideShow',"Masquer/Afficher");
Rico.addPhraseId('gridmenuChooseCols',"Choisissez les colonnes...");
Rico.addPhraseId('gridmenuHide',"Masquer: $1");
Rico.addPhraseId('gridmenuShow',"Afficher: $1");
Rico.addPhraseId('gridmenuShowAll',"Afficher tous");

// used in ricoLiveGridAjax.js

Rico.addPhraseId('sessionExpireMinutes',"minutes avant que votre session expire");
Rico.addPhraseId('sessionExpired',"EXPIRÉ");
Rico.addPhraseId('requestTimedOut',"La requête a atteint sa limite de temps");
Rico.addPhraseId('waitForData',"En attente des données...");
Rico.addPhraseId('httpError',"La requête a retourné une erreur HTTP: $1");
Rico.addPhraseId('invalidResponse',"Le serveur a retourné une réponse non valide");

// used in ricoLiveGridCommon.js

Rico.addPhraseId('gridChooseCols',"Choisissez les colonnes");
Rico.addPhraseId('exportComplete',"Exportation complete");
Rico.addPhraseId('exportInProgress',"Exportation en marche...");
Rico.addPhraseId('showFilterRow',"Afficher le rang de filtre");
Rico.addPhraseId('hideFilterRow',"Masquer le rang de filtre");

// used in ricoLiveGridForms.js

Rico.addPhraseId('selectNone',"(aucun)");
Rico.addPhraseId('selectNewVal',"(nouvelle valeur)");
Rico.addPhraseId('record',"l'entrée");
Rico.addPhraseId('thisRecord',"cette entrée");
Rico.addPhraseId('confirmDelete',"Êtes-vous sûr de vouloir supprimer $1?");
Rico.addPhraseId('deleting',"Effacement en cours...");
Rico.addPhraseId('formPleaseEnter',"Veuillez saisir une valeur pour $1");
Rico.addPhraseId('formInvalidFmt',"Format invalide pour $1");
Rico.addPhraseId('formOutOfRange',"Valeur non-autorisée pour $1");
Rico.addPhraseId('formNewValue',"Nouvelle valeur:");
Rico.addPhraseId('saving',"Sauvegarde en cours...");
Rico.addPhraseId('clear',"Enlever");
Rico.addPhraseId('close',"Fermer");
Rico.addPhraseId('saveRecord',"Sauvegarder");
Rico.addPhraseId('cancel',"Annuler");
Rico.addPhraseId('editRecord',"Éditer cette entrée");
Rico.addPhraseId('deleteRecord',"Supprimer cette entrée");
Rico.addPhraseId('cloneRecord',"Copier cette entrée");
Rico.addPhraseId('addRecord',"Ajouter une nouvelle entrée");
Rico.addPhraseId('addedSuccessfully',"$1 a été ajoutée avec succès");
Rico.addPhraseId('deletedSuccessfully',"$1 a été supprimée avec succès");
Rico.addPhraseId('updatedSuccessfully',"$1 a été mis à jour avec succès");

// used in ricoTree.js

Rico.addPhraseId('treeSave',"Sauvegarder la selection");
Rico.addPhraseId('treeClear',"Enlever tous");

// used in ricoCalendar.js

Rico.addPhraseId('calToday',"Aujourd'hui est le $1 $2 $3");
Rico.addPhraseId('calWeekHdg',"Sem");
Rico.addPhraseId('calYearRange',"Année ($1-$2)");
Rico.addPhraseId('calInvalidYear',"Année non valide");

// Date & number formats

Rico.thouSep="'"
Rico.decPoint="."
Rico.dateFmt="dd.mm.yyyy"

Rico.monthNames=['Janvier','Février', 'Mars', 'Avril', 'Mai','Juin', 'Juillet','Août','Septembre','Octobre','Novembre','Décembre'];
Rico.dayNames=['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'];
Rico.monthNamesShort=['Jan','Fév','Mar','Avr','Mai','Jun','Jul','Aoû','Sep','Oct','Nov','Déc'];
Rico.dayNamesShort=['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'];

