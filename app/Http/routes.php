<?php

resource(
    '/',
    '\ScandiWebTest\Http\Controllers\AppController',
    ['only' => ['index']]
);

Route::group(['middleware' => 'ajax'], function () {
    resource(
        'tasks',
        '\ScandiWebTest\Http\Controllers\TaskController',
        ['only' => ['index', 'store']]
    );
});
