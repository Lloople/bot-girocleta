<?php

Route::get('/', function () {

    [$left, $right] = collect(glob(resource_path('views/information').'/*.php'))->split(2);

    return view('pages.home', compact('left', 'right'));

})->name('home');

Route::view('about', 'pages.about')->name('about');

Route::view('legal', 'pages.legal')->name('legal');

Route::match(['get', 'post'], '/botman', 'BotManController@handle');