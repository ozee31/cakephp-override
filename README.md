# Override plugin for CakePHP

## Requirements

- PHP version 5.6 or higher
- CakePhp 3.4 or higher

## Installation

You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).

The recommended way to install composer packages is:

```
composer require ozee31/cakephp-override
```

End load plugin in `config/bootstrap.php`

```php
Plugin::load('Override', ['bootstrap' => true]);
```

## Configuration

- Create config file `config/overrides.php` with this code :

```php
<?php return ['Overrides' => [
    'routes' => [
        /*
         * (!) You must also add the model overload
         */
    ],
    'models' => [
        /*
         * (!) Always redeclare entityClass when overloading className otherwise cakephp does not use it
         */
    ],
    'helpers' => []
]];

```

- Add this code in your `config/routes.php` file and move `Plugin::routes()` at the end of file

- Load Overload component in your `AppController`

```php
public function initialize()
{
    parent::initialize();

    $this->loadComponent('Override.Override');
}
```

```php
<?php
// Use Override class
use Override\Routing\Override;


Router::scope('/', function (RouteBuilder $routes) {
    // In Router scope add this code
    Override::connect($routes);

    // ... other routes
});

// Plugin routes must be declared after Override::connect()
Plugin::routes();
```

## Exemples

### Routes

In my example I will override the [Croogo plugin](https://github.com/croogo/croogo) but it works with any plugins

If you want rewrite this route :

```php
$routes->connect(
    '/user/:username', 
    ['controller' => 'Users', 'action' => 'view'],
    ['pass' => ['username']]
);
```

You must add in `config/overrides.php`

```php
'routes' => [
    '/user/:username' => [
        'route' => ['controller' => 'Users', 'action' => 'view', 'plugin' => false],
        'options' => ['pass' => ['username']]
    ],
],
```

### Templates

Template overload is native in Cakephp

If you want rewrite the `Users/index.ctp` template of `MyPlugin`, you just need to create the following file in your project : `src/Template/Plugin/MyPlugin/Users/index.ctp` (`src/Template/Plugin/PluginName/ControllerName/ActionName.ctp`)

Croogo use subPlugin, If you want rewrite `Users/view.ctp` template of `Croogo.Users` plugin, you just need to create the following file in your project : `src/Template/Plugin/Croogo/Users/Users/view.ctp` (`src/Template/Plugin/PluginName/SubpluginName/ControllerName/ActionName.ctp`)

### Models

#### Only entity

If you want overload the `User` entity of `MyPlugin` you must add this code in `config/overrides.php`

```php
'models' => [
    'MyPlugin.Users' => ['entityClass' => 'App\Model\Entity\User'],
],
```

#### Table and entity

If you want overload the `User` entity and the `Users` table of `MyPlugin` you must add this code in `config/overrides.php` 

```php
'models' => [
    'MyPlugin.Users' => [
        'className' => 'App\Model\Table\UsersTable', 
        'entityClass' => 'App\Model\Entity\User'
    ],
],
```

#### Only Table

If you want just overload the `Users` table of `MyPlugin` you must redeclare the entity class :

```php
'models' => [
    'MyPlugin.Users' => [
        'className' => 'App\Model\Table\UsersTable', 
        'entityClass' => 'MyPlugin\Model\Entity\User'
    ],
],
```
