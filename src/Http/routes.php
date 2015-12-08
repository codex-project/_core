<?php

/*
|--------------------------------------------------------------------------
| Docit Routes
|--------------------------------------------------------------------------
|
*/

Route::get('/', ['as' => 'docit.index', 'uses' => 'DocitController@index']);
Route::get('{projectSlug}/{ref?}/{document?}', [
    'as' => 'docit.document',
    'uses' => 'DocitController@document'
])
    ->where('projectSlug', '^((?!' . \Docit\Core\Extensions::getExcludedProjectNames(true) . ').*?)$')
    ->where('document', '(.*)');
