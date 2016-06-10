<?php

$index = Route::get('/', [ 'as' => 'index', 'uses' => 'CodexController@index' ]);

$document = Route::get('{projectSlug}/{ref?}/{document?}', [ 'as' => 'document', 'uses' => 'CodexController@document' ]);
$document->where('document', '(.*)');

//if ( count(Extender::getExcludedProjectNames()) > 0 ) {
//    $document->where('projectSlug', '^((?!' . Extender::getExcludedProjectNames(true) . ').*?)$');
//}
$ignored = config('codex.routing.ignore_project_names', [ ]);
if ( is_array($ignored) && count($ignored) > 0 ) {
    $document->where('projectSlug', '^((?!' . implode('|', $ignored) . '|api).*?)$');
} elseif ( is_string($ignored) ) {
    $document->where('projectSlug', $ignored);
}

Route::get('_markdown', [ 'as' => 'markdown', 'uses' => 'CodexController@markdown' ]);


