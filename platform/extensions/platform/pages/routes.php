<?php

Route::any(API . '/pages/content/datatable', 'platform/pages::api.content@datatable');
Route::any(API . '/pages/content/(:any)', 'platform/pages::api.content@index');
Route::any(API . '/pages/content', 'platform/pages::api.content@index');
Route::any(API . '/pages/datatable', 'platform/pages::api.pages@datatable');
Route::any(API . '/pages/(:any)', 'platform/pages::api.pages@index');