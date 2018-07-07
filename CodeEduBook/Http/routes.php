<?php

    Route::group(['middleware' => ['auth', config('codeeduuser.middleware.isVerified'), 'auth.resource']], function (){
        Route::resource('categorias','CategoriasController', ['except' => 'show']);
        Route::group(['prefix' => 'livros/{livro}'], function (){
            Route::get('capa','LivrosController@coverForm')->name('livros.cover.create');
            Route::post('capa','LivrosController@coverStore')->name('livros.cover.store');
            Route::post('exportar','LivrosController@export')->name('livros.export');
            Route::get('download','LivrosController@download')->name('livros.download');
            Route::resource('capitulos','CapitulosController', ['except' => 'show']);
        });
        Route::resource('livros','LivrosController', ['except' => 'show']);
        Route::group(['prefix' => 'trashed', 'as' => 'trashed.'], function () {
            Route::resource('livros', 'LivrosTrashedController', ['except' => ['create', 'store', 'edit', 'destroy']]);
        });
    });

    Route::get('livros/{id}/download-common','LivrosController@downloadCommon')->name('livros.download-common');