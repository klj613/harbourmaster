Harbour Master
==============

# Application Settings #

In the `public/index.php` file there is an array declared at the top called `$appSettings`. This should
be used for the configuration values required throughout the application.

To access `$appSettings` within a route, call it in with `global $appSettings;`

## Route Caching ##

By default, the routes declared in `app/routes` are cached in a JSON file in `writable/cache/pm_loader_routes.json`
the cache has a TTL of 3600, although this can be changed by altering the `routeCacheTtl` setting in `$appSettings`



# Example Apache VirtualHost #

```text
<VirtualHost *:80>
        ServerAdmin webmaster@localhost
        ServerName example.local
        DocumentRoot /path/to/public
        <Directory "/path/to/public">
            Order Deny,Allow
            Allow from all
            AllowOverride None
            SetEnv APPLICATION_ENV production
            RewriteEngine On
            RewriteCond %{REQUEST_FILENAME} -s [OR]
            RewriteCond %{REQUEST_FILENAME} -l [OR]
            RewriteCond %{REQUEST_FILENAME} -d
            RewriteRule ^.*$ - [NC,L]
            RewriteRule ^.*$ index.php [NC,L]
        </Directory>
</VirtualHost>
```
