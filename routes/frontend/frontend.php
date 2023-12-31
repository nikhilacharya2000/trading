<?php

Route::get('/', 'HomeController@index');
Route::get('/nifty', 'HomeController@Nifty');
Route::get('/banknifty', 'HomeController@BankNifty');
Route::get('/finnifty', 'HomeController@FinNifty');
Route::get('/optionChain', 'HomeController@OptionChain');
Route::get('/niftItSectoral', 'HomeController@NiftItSectoral');
Route::get('/viewNews/{blog}', 'HomeController@viewNews');


Route::get('/get-finniftywithDt/{id}', 'HomeController@getFinNiftywithDt');
Route::get('/get-bankniftywithDt/{id}', 'HomeController@getBankNiftywithDt');
Route::get('/get-niftywithDt/{id}', 'HomeController@getNiftywithDt');

