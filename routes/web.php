<?php

Route::view('/', 'welcome')->name('home');

Route::view('about', 'about')->name('about');

Route::view('legal', 'legal')->name('legal');

Route::match(['get', 'post'], '/botman', 'BotManController@handle');

Route::get('/botman/tinker', 'BotManController@tinker');
