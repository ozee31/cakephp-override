<?php
namespace Override\Routing;

use Cake\Routing\RouteBuilder;
use Cake\Core\Configure;

class Override
{
    /**
     * Connect all overrides routes
     *
     * @param RouteBuilder $routeBuilder
     * @return bool
     */
    public static function connect(RouteBuilder $routeBuilder)
    {
        $routes = Configure::read('Overrides.routes');

        if (!is_array($routes)) {
            return false;
        }

        foreach ($routes as $route => $config) {
            $options = (isset($config['options'])) ? (array) $config['options'] : [];
            $routeBuilder->connect($route, $config['route'], $options);
        }

        return true;
    }
}
