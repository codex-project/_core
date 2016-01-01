<?php
use Codex\Core\Extensions;

$index = Route::get('/', ['as' => 'codex.index', 'uses' => 'CodexController@index']);

$document = Route::get('{projectSlug}/{ref?}/{document?}', [ 'as' => 'codex.document', 'uses' => 'CodexController@document' ]);
$document->where('document', '(.*)');

if(count(Extensions::getExcludedProjectNames()) > 0)
{
    $document->where('projectSlug', '^((?!' . Extensions::getExcludedProjectNames(true) . ').*?)$');
}

