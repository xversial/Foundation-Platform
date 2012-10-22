<?php

Route::any(API . '/pages/content/datatable', 'pages::api.content@datatable');
Route::any(API . '/pages/content/(:any)', 'pages::api.content@index');
Route::any(API . '/pages/content', 'pages::api.content@index');
Route::any(API . '/pages/datatable', 'pages::api.pages@datatable');
Route::any(API . '/pages/(:any)', 'pages::api.pages@index');