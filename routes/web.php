<?php

Route::post('/pessoas/pesquisar', ['as' => 'pessoas.pesquisar', 'uses' => 'PessoaController@pesquisar']);
Route::resource('/pessoas','PessoaController');