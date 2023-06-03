<?php

Route::get('/', 'HomeController@index');
Route::get('/viewNews/{blog}', 'HomeController@viewNews');
Route::get('/finnifty', 'HomeController@finnifty');
Route::get('/optionChain', 'HomeController@optionChain');
