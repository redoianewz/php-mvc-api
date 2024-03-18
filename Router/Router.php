<?php

$router->get('/', function () {
    $results = [];
    for ($i = 0; $i < 10; $i++) {
        $results[] = [
            'id' => 1,
            'name' => 'product1',
            'price' => 100,
            'quantity' => 10,
            'category' => 'category1',
            'description' => 'description1',
            'image' => 'image1',
            'created_at' => '2020-01-01 00:00:00',
            'updated_at' => '2020-01-01 00:00:00'
        ];
    }
    return $results;
});
$router->get('/home','Home@index');
$router->get('/home/:id', 'Home@getUser');
$router->post('/home', 'Home@createUser');
$router->put('/home/update/:id','Home@updateUser');
$router->delete('/home/delete/:id', 'Home@deleteUser');

