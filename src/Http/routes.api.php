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

//Route::get('projects/{project?}', ['as' => 'projects', 'uses' => 'CodexApiController@projects']);
//Route::get('documents/{project}/{document?}', ['as' => 'documents', 'uses' => 'CodexApiController@documents']);

//
//Route::get('projects', [ 'as' => 'projects', 'uses' => 'CodexApiController@getProjects']);
//Route::get('project', [ 'as' => 'project', 'uses' => 'CodexApiController@getProject']);
//Route::get('documents', [ 'as' => 'documents', 'uses' => 'CodexApiController@getDocuments']);
//Route::get('document', [ 'as' => 'document', 'uses' => 'CodexApiController@getDocument']);
//Route::get('menus', [ 'as' => 'menus', 'uses' => 'CodexApiController@getMenus']);
//Route::get('menu', [ 'as' => 'menu', 'uses' => 'CodexApiController@getMenu']);



Route::get('/', ['as' => 'index', 'uses' => 'CodexApiController@getIndex']);

Route::get('projects', [ 'as' => 'projects', 'uses' => 'CodexApiController@getProjects']);
Route::get('projects/{project}', [ 'as' => 'project', 'uses' => 'CodexApiController@getProject']);
Route::get('projects/{project}/refs', [ 'as' => 'project', 'uses' => 'CodexApiController@getRefs']);
Route::get('projects/{project}/refs/{ref}', [ 'as' => 'project', 'uses' => 'CodexApiController@getRef']);
Route::get('projects/{project}/refs/{ref}/documents', [ 'as' => 'documents', 'uses' => 'CodexApiController@getDocuments']);
Route::get('projects/{project}/refs/{ref}/documents/{document}', [ 'as' => 'document', 'uses' => 'CodexApiController@getDocument'])->where('document', '(.*)');

Route::get('menus', [ 'as' => 'menus', 'uses' => 'CodexApiController@getMenus']);
Route::get('menus/{menu}', [ 'as' => 'menu', 'uses' => 'CodexApiController@getMenu']);

//Route::get('phpdoc/projects');
//Route::get('projects/{project}/refs/{ref}/phpdoc');
Route::get('query/{query}', ['as' => 'query', 'uses' => 'CodexApiController@getQuery'])->where('query', '(.*)');
Route::get('config/{key?}', ['as' => 'config', 'uses' => 'CodexApiController@getConfig'])->where('key', '(.*)');
