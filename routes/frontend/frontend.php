<?php

Route::get('/', 'HomeController@index');
Route::get('/nifty', 'HomeController@Nifty');
Route::get('/banknifty', 'HomeController@Banknifty');
Route::get('/finnifty', 'HomeController@Finnifty');
Route::get('/optionChain', 'HomeController@OptionChain');

Route::get('/viewNews/{blog}', 'HomeController@viewNews');