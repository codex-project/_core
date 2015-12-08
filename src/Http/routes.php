<?php
use Docit\Core\Extensions;

$index = Route::get('/', ['as' => 'docit.index', 'uses' => 'DocitController@index']);

$document = Route::get('{projectSlug}/{ref?}/{document?}', [ 'as' => 'docit.document', 'uses' => 'DocitController@document' ]);
$document->where('document', '(.*)');

if(count(Extensions::getExcludedProjectNames()) > 0)
{
    $document->where('projectSlug', '^((?!' . Extensions::getExcludedProjectNames(true) . ').*?)$');
}

