<?php

Route::get('/', function () {

    [$left, $right] = collect(glob(resource_path('views/information') . '/*.php'))
        ->map(function ($file) {
            return 'information.' . str_replace('.blade.php', '', basename($file));
        })->partition(function ($file, $index) {
            return $index % 2 == 0;
        });

    return view('pages.home', compact('left', 'right'));

})->name('home');

Route::view('about', 'pages.about')->name('about');

Route::view('legal', 'pages.legal')->name('legal');

Route::match(['get', 'post'], '/bot', 'BotManController@handle');