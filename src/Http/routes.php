<?php
use Codex\Core\Extensions\Extender;

$index = Route::get('/', ['as' => 'codex.index', 'uses' => 'CodexController@index']);

$document = Route::get('{projectSlug}/{ref?}/{document?}', [ 'as' => 'codex.document', 'uses' => 'CodexController@document' ]);
$document->where('document', '(.*)');

if (count(Extender::getExcludedProjectNames()) > 0) {
    $document->where('projectSlug', '^((?!' . Extender::getExcludedProjectNames(true) . ').*?)$');
}
