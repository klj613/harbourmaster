Harbour Master
==============

### Required Setup ###

 * Run `php composer.phar install --dev`
 * Give `/writable/cache` read/write permission to the web user (or just `chmod 777 -R` for the cool kids)

### Application Settings ###

In the `public/index.php` file there is an array declared at the top called `$appSettings`. This should
be used for the configuration values required throughout the application.

To access `$appSettings` within a route, call it in with `global $appSettings;`

#### Route Caching ####

By default, the routes declared in `app/routes` are cached in a JSON file in `writable/cache/pm_loader_routes.json`
the cache has a TTL of 3600, although this can be changed by altering the `routeCacheTtl` setting in `$appSettings`


### Docs ###

* [Example apache virtualhost](vhost.dist)
* [How to use docker for harbourmaster](docker_setup.md)
