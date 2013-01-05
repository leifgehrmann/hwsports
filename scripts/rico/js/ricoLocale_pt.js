/*****************************************************************
 ricoLocale_pt.js - a component of Rico 3
 Localization strings for Portugese
 
 If you have better translations, or would like to include translations for another language, 
 please post them on http://sourceforge.net/projects/openrico/
******************************************************************/
Rico.langCode='pt';

// used in ricoLiveGrid.js

Rico.addPhraseId('bookmarkExact',"Listar registros $1 - $2 de $3");
Rico.addPhraseId('bookmarkAbout',"Listar registros $1 - $2 de aproximadamente $3");
Rico.addPhraseId('bookmarkNoRec',"Nenhum registro");
Rico.addPhraseId('bookmarkNoMatch',"Nenhum registro encontrado");
Rico.addPhraseId('bookmarkLoading',"Carregamento...");
Rico.addPhraseId('sorting',"Classificar é em andamento...");
Rico.addPhraseId('exportStatus',"Exportando a fileira $1");
Rico.addPhraseId('filterAll',"(tudo)");
Rico.addPhraseId('filterBlank',"(espaço em branco)");
Rico.addPhraseId('filterEmpty',"(vazio)");
Rico.addPhraseId('filterNotEmpty',"(nao vazio)");
Rico.addPhraseId('filterLike',"como: $1");
Rico.addPhraseId('filterNot',"nao: $1");
Rico.addPhraseId('requestError',"O pedido para dados retornou um erro:\n$1");
Rico.addPhraseId('keywordPrompt',"Informe texto a ser pesquisado (use * como 'coringa'):");

// used in ricoLiveGridMenu.js

Rico.addPhraseId('gridmenuSortBy',"Ordenar por: $1");
Rico.addPhraseId('gridmenuSortAsc',"Ascendente");
Rico.addPhraseId('gridmenuSortDesc',"Descendente");
Rico.addPhraseId('gridmenuFilterBy',"Filtrar por: $1");
Rico.addPhraseId('gridmenuRefresh',"Actualizar");
Rico.addPhraseId('gridmenuChgKeyword',"Alterar texto...");
Rico.addPhraseId('gridmenuExcludeAlso',"Excluir este valor também");
Rico.addPhraseId('gridmenuInclude',"Incluir apenas este valor");
Rico.addPhraseId('gridmenuGreaterThan',"Maior ou igual a este valor");
Rico.addPhraseId('gridmenuLessThan',"Menor ou igual a este valor");
Rico.addPhraseId('gridmenuContains',"Contém texto...");
Rico.addPhraseId('gridmenuExclude',"Excluir este valor");
Rico.addPhraseId('gridmenuRemoveFilter',"Remover filtro");
Rico.addPhraseId('gridmenuRemoveAll',"Remova todos os filtros");

Rico.addPhraseId('gridmenuExport',"Imprimir/Exportar");
Rico.addPhraseId('gridmenuExportVis2Web',"Fileiras visíveis para uma página da Web");
Rico.addPhraseId('gridmenuExportAll2Web',"Todas as fileiras para uma página da Web");
Rico.addPhraseId('gridmenuExportVis2SS',"Fileiras visíveis para um spreadsheet");
Rico.addPhraseId('gridmenuExportAll2SS',"Todas as fileiras para um spreadsheet");

Rico.addPhraseId('gridmenuHideShow',"Ocultar/Exibir");
Rico.addPhraseId('gridmenuChooseCols',"Escolha as colunas...");
Rico.addPhraseId('gridmenuHide',"Ocultar: $1");
Rico.addPhraseId('gridmenuShow',"Exibir: $1");
Rico.addPhraseId('gridmenuShowAll',"Exibir tudo");

// used in ricoLiveGridAjax.js

Rico.addPhraseId('sessionExpireMinutes',"minutos antes de sua sessão expiram");
Rico.addPhraseId('sessionExpired',"EXPIRADO");
Rico.addPhraseId('requestTimedOut',"Tempo esgotado para espera de dados");
Rico.addPhraseId('waitForData',"Aguardando dados...");
Rico.addPhraseId('httpError',"Um erro do HTTP foi recebido: $1");
Rico.addPhraseId('invalidResponse',"O servidor retornou uma resposta inválida");

// used in ricoLiveGridCommon.js

Rico.addPhraseId('gridChooseCols',"Escolha as colunas");
Rico.addPhraseId('exportComplete',"A exportação está completa");
Rico.addPhraseId('exportInProgress',"A exportação é em andamento...");
Rico.addPhraseId('showFilterRow',"Exibir a fileira do filtro");
Rico.addPhraseId('hideFilterRow',"Ocultar a fileira do filtro");

// used in ricoLiveGridForms.js

Rico.addPhraseId('selectNone',"(nenhuns)");
Rico.addPhraseId('selectNewVal',"(valor novo)");
Rico.addPhraseId('record',"o registro");
Rico.addPhraseId('thisRecord',"este registro");
Rico.addPhraseId('confirmDelete',"É você certo você quer suprimir $1?");
Rico.addPhraseId('deleting',"O apagamento é em andamento...");
Rico.addPhraseId('formPleaseEnter',"Registe um valor para $1");
Rico.addPhraseId('formInvalidFmt',"Formato inválido em $1");
Rico.addPhraseId('formOutOfRange',"Valor fora da escala em $1");
Rico.addPhraseId('formNewValue',"valor novo:");
Rico.addPhraseId('saving',"Salvar em andamento...");
Rico.addPhraseId('clear',"remover");
Rico.addPhraseId('close',"Fechar");
Rico.addPhraseId('saveRecord',"Salvar");
Rico.addPhraseId('cancel',"Cancelar");
Rico.addPhraseId('editRecord',"Editar este registro");
Rico.addPhraseId('deleteRecord',"Apagar este registro");
Rico.addPhraseId('cloneRecord',"Copiar este registro");
Rico.addPhraseId('addRecord',"Criar um registro novo");
Rico.addPhraseId('addedSuccessfully',"$1 foi adicionado com sucesso");
Rico.addPhraseId('deletedSuccessfully',"$1 foi apagado com sucesso");
Rico.addPhraseId('updatedSuccessfully',"$1 foi atualizado com sucesso");

// used in ricoTree.js

Rico.addPhraseId('treeSave',"Salvar a seleção");
Rico.addPhraseId('treeClear',"Cancele tudo");

// used in ricoCalendar.js

Rico.addPhraseId('calToday',"Hoje é $1 $2 $3");
Rico.addPhraseId('calWeekHdg',"Sem");
Rico.addPhraseId('calYearRange',"Ano ($1-$2)");
Rico.addPhraseId('calInvalidYear',"Ano inválido");

// Date & number formats

Rico.thouSep=".";
Rico.decPoint=",";
Rico.dateFmt="dd/mm/yyyy";

Rico.monthNames=["Janeiro", "Fevereiro", "Março", "Abril", "Maio","Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];
Rico.dayNames=["Domingo", "Segunda","Terça", "Quarta", "Quinta", "Sexta", "Sábado"];
Rico.monthNamesShort=['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'];
Rico.dayNamesShort=['Dom','Seg','Ter','Qua','Qui','Sex','Sab'];

Rico.includeLoaded('ricoLocale_pt.js');
