<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Backend\CrudTablesController@showTables')->name('showTables');
Route::get('/create_tables', 'Backend\CreateTablesController@createTables');
Route::get('/insert_tables', 'Backend\CrudTablesController@insertTables');
//Route::get('/insert_descr', 'Backend\CrudTablesController@insertTables');
Route::post('/store_tables', 'Backend\CrudTablesController@storeTables')->name('storeTables');
Route::get('/edit_tables/{id}', 'Backend\CrudTablesController@editTables');
Route::post('/store_edit_tables', 'Backend\CrudTablesController@storeEditTables');
//Route::post('/delete_row', 'Backend\CrudTablesController@deleteRowTables')->name('deleteRow');
Route::get('/delete_row', 'Backend\CrudTablesController@deleteRowTables')->name('deleteRow1');///{id}/{dell_desc}

Route::get('/show_size', 'Backend\CrudSizeController@showSize')->name('showSize');
Route::get('/insert_size', 'Backend\CrudSizeController@insertSize');
Route::post('/store_size', 'Backend\CrudSizeController@storeSize');
Route::get('/edit_size/{id}', 'Backend\CrudSizeController@editSize');
Route::post('/store_edit_size', 'Backend\CrudSizeController@storeEditSize');
Route::get('/delete_size', 'Backend\CrudSizeController@deleteRowSize')->name('deleteRowSize');

Route::get('/show_color', 'Backend\CrudColorController@showColor')->name('showColor');
Route::get('/insert_color', 'Backend\CrudColorController@insertColor');
Route::post('/store_color', 'Backend\CrudColorController@storeColor');
Route::get('/edit_color/{id}', 'Backend\CrudColorController@editColor');
Route::post('/store_edit_color', 'Backend\CrudColorController@storeEditColor');
Route::get('/delete_color', 'Backend\CrudColorController@deleteRowColor')->name('deleteRowColor');

Route::get('/show_descr', 'Backend\CrudDescrController@showDescr')->name('showDescr');
Route::get('/insert_descr', 'Backend\CrudDescrController@insertDescr');
Route::post('/store_descr', 'Backend\CrudDescrController@storeDescr');
Route::get('/edit_descr/{id}', 'Backend\CrudDescrController@editDescr');
Route::post('/store_edit_descr', 'Backend\CrudDescrController@storeEditDescr');
Route::get('/delete_descr', 'Backend\CrudDescrController@deleteRowDescr')->name('deleteRowDescr');

Route::get('/show_pict', 'Backend\CrudPictController@showPict')->name('showPict');
Route::get('/insert_pict', 'Backend\CrudPictController@insertPict');
Route::post('/store_pict', 'Backend\CrudPictController@storePict');
Route::get('/edit_pict/{id}', 'Backend\CrudPictController@editPict');
Route::post('/store_edit_pict', 'Backend\CrudPictController@storeEditPict');
Route::get('/delete_pict', 'Backend\CrudPictController@deleteRowPict')->name('deleteRowPict');

