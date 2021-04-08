<?php

require __DIR__ . "/../../vendor/autoload.php";


class App
{
    public function user(int $id, string $name)
    {
        echo "ID: " . $id;
        echo "<br/>";
        echo "Name: " . $name;
    }
}


use Light\Light;

$app = new Light();

$app->get('/user/:/:', [App::class, 'user']);

$app->start();