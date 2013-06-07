<?php

/**
 * GitShip.com PHP Library
 *
 * @copyright GitShip.com
 *
 * @author GitShip.com
 * @link http://www.GitShip.com
 *
 * @license This software and associated documentation (the "Software") may not be
 * used, copied, modified, distributed, published or licensed to any 3rd party
 * without the written permission of GitShip.com
 *
 * The above copyright notice and this permission notice shall be included in
 * all licensed copies of the Software.
 *
 */
namespace Ship\Loader;

/**
 * Routes
 */
class Routes {

    /**
     * Protected on purpose.
     */
    protected function __construct()
    {
    }

    /**
     * Read and cache all routes from the routes folder
     * @param string $routePath
     * @param Slim\Slim $app
     * @param string $cacheLocation (null)
     * @param integer $cacheAge (default 3600)
     * @throws \Exception
     */
    public static function loadOrCache($routePath, $app, $cacheLocation = '', $cacheAge = 3600)
    {
        if (null == $routePath) {
            throw new \Exception('routePath must be specified.');
        }
        if ($cacheLocation != null) {
            if (!is_int($cacheAge)) {
                throw new \Exception('cacheAge must be an integer.');
            }
            $cacheLocation = realpath($cacheLocation);
            $cacheLocation = rtrim($cacheLocation,' /');
            $cacheLocation .= '/pm_loader_routes.json';
            if (file_exists($cacheLocation)) {
                $age = filemtime($cacheLocation);
                if ($age < (time() - $cacheAge)) {
                    unlink($cacheLocation);
                    $openCache = true;
                } else {
                    // Age is ok.
                    $routes = file_get_contents($cacheLocation);
                    foreach (json_decode($routes) as $route) {
                        require_once $route;
                    }

                    return;
                }
            } else {
                $openCache = true;
            }
        }

        if ($openCache) {
            $fileHandle = @fopen($cacheLocation, 'w');
        }

        if (null != ($dirHandle = opendir($routePath))) {
            while (false !== ($file = readdir($dirHandle))) {
                if (substr($file, (strlen($file) - 4), 4) == '.php' && $file != "." && $file != "..") {
                    $route = $routePath . '/' . $file;
                    $routes[] = $route;
                    require_once $route;
                }
            }
            if ($cacheLocation != null) {
                fwrite($fileHandle, json_encode($routes));
                @fclose($fileHandle);
            }
        } else {
            throw new \Exception('Unable to load routes.');
        }
    }

}