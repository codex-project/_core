<?php


$indexMethod = config('codex.http.use_welcome_page', false) ? 'welcome' : 'index';
Route::get('/', [ 'as' => 'index', 'uses' => 'CodexController@' . $indexMethod  ]);

$documentPrefix = str_ensure_right(config('codex.http.document_prefix', ''), '/');
$document = Route::get("{$documentPrefix}{projectSlug?}/{ref?}/{document?}", [ 'as' => 'document', 'uses' => 'CodexController@document' ]);
$document->where('document', '(.*)');

//if ( count(Extender::getExcludedProjectNames()) > 0 ) {
//    $document->where('projectSlug', '^((?!' . Extender::getExcludedProjectNames(true) . ').*?)$');
//}
$ignored = config('codex.http.ignore_project_names', [ ]);
if ( is_array($ignored) && count($ignored) > 0 ) {
    $document->where('projectSlug', '^((?!' . implode('|', $ignored) . '|api).*?)$');
} elseif ( is_string($ignored) ) {
    $document->where('projectSlug', $ignored);
}

Route::get('_markdown', [ 'as' => 'markdown', 'uses' => 'CodexController@markdown' ]);


if(codex()->isDev()){

    Route::group(['prefix' => 'dev'], function(){

    });
}
