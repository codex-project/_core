<?php

Route::get('codex', 'CodexController@index');
Route::get('codex/search/{manual}/{version}', 'SearchController@show');
Route::get('codex/{manual}/{version?}/{page?}', 'CodexController@show')->where('page', '(.*)');
