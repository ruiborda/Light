# Light

[![Packagist](https://img.shields.io/packagist/v/ruiborda/light.svg)](https://packagist.org/packages/ruiborda/light)

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

# Execute Example

````shell
php -S localhost:8080 -t example/public/
````