<?php

Route::get('/', 'HomeController@index');
Route::get('/viewNews/{blog}', 'HomeController@viewNews');
Route::get('/nifty50', 'HomeController@nifty50');
Route::get('/optionChain', 'HomeController@optionChain');
