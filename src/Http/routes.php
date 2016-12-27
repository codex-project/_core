<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author    Robin Radic
 * @copyright Copyright 2016 (c) Codex Project
 * @license   http://codex-project.ninja/license The MIT License
 */
$controller = config('codex.http.use_welcome_page', false) ? 'Welcome' : 'Document';
Route::get('/', [ 'as' => 'index', 'uses' => "Codex{$controller}Controller@getIndex" ]);

$documentPrefix = str_ensure_right(config('codex.http.document_prefix', ''), '/');
$document       = Route::get("{$documentPrefix}{projectSlug?}/{ref?}/{document?}", [ 'as' => 'document', 'uses' => 'CodexDocumentController@getDocument' ]);
$document->where('document', '(.*)');

//if ( count(Extender::getExcludedProjectNames()) > 0 ) {
//    $document->where('projectSlug', '^((?!' . Extender::getExcludedProjectNames(true) . ').*?)$');
//}
$ignored = config('codex.http.ignore_project_names', []);
if ( is_array($ignored) && count($ignored) > 0 ) {
    $document->where('projectSlug', '^((?!' . implode('|', $ignored) . '|api).*?)$');
} elseif ( is_string($ignored) ) {
    $document->where('projectSlug', $ignored);
}

//Route::get('_markdown', [ 'as' => 'markdown', 'uses' => 'CodexController@markdown' ]);
