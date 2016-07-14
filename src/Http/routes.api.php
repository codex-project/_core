<?php

//Route::get('projects/{project?}', ['as' => 'projects', 'uses' => 'CodexApiController@projects']);
//Route::get('documents/{project}/{document?}', ['as' => 'documents', 'uses' => 'CodexApiController@documents']);


Route::get('projects', [ 'as' => 'projects', 'uses' => 'CodexApiController@getProjects']);
Route::get('project', [ 'as' => 'project', 'uses' => 'CodexApiController@getProject']);
Route::get('documents', [ 'as' => 'documents', 'uses' => 'CodexApiController@getDocuments']);
Route::get('document', [ 'as' => 'document', 'uses' => 'CodexApiController@getDocument']);
Route::get('menus', [ 'as' => 'menus', 'uses' => 'CodexApiController@getMenus']);
Route::get('menu', [ 'as' => 'menu', 'uses' => 'CodexApiController@getMenu']);
