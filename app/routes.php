<?php

$framework->get('/',
    $framework->controller('ScandiWebTest\Controllers\AppController@index')
);

$framework->get('/tasks', [
    'controller' => $framework->controller('ScandiWebTest\Controllers\TaskController@index'),
    'middleware' => $framework->middleware('ScandiWebTest\Middleware\Ajax')
]);

$framework->post('/tasks', [
    'controller' => $framework->controller('ScandiWebTest\Controllers\TaskController@store'),
    'middleware' => $framework->middleware('ScandiWebTest\Middleware\Ajax')
]);