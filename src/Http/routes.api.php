<?php

//Route::get('projects/{project?}', ['as' => 'projects', 'uses' => 'CodexApiController@projects']);
//Route::get('documents/{project}/{document?}', ['as' => 'documents', 'uses' => 'CodexApiController@documents']);


Route::resource('project', 'ProjectsApiController', [
    'only' => ['index', 'show']
]);
