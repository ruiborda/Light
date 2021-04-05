# Light

Web Framework

## Installation

```shell
composer require ruiborda/light
```

## Example

```php
namespace Any{
    class User{
        public function method_name(int $id,string $name){
            echo 'id: '. $id;
            echo '<br/>';
            echo 'name: '. $name;
        }
    }
}
```

```php
<?php
require __DIR__ . "/../vendor/autoload.php";

$app = new \Light\Light();

$app->get(
            '/user/:/:',
            [\Any\User::class, 'method_name']
        );
        
$app->start();
```
