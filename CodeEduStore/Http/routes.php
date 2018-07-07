<?php

Route::get('/', 'StoreController@index');
Route::get('/pub/categorias/{categoria}', 'StoreController@categoria')->name('store.categoria');
Route::get('/pub/search', 'StoreController@search')->name('store.search');
Route::get('/pub/livros/{slug}', 'StoreController@showProduto')->name('store.show-produto');

Route::group(['middleware' => 'auth'], function (){
    Route::get('/checkout/{produto}', 'StoreController@checkout')->name('store.checkout');
    Route::post('/process/{produto}', 'StoreController@process')->name('store.process');
    Route::get('/orders', 'StoreController@orders')->name('store.orders');
});

