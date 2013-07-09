# Laraeval #

It is often when developing an application we want to try some code 
just to figure it out something or test the output. We ended up by creating a bunch
of dummy controllers or routes just to test. Introducing **Laraeval**! a Laravel 4 package 
for evaluating your PHP code right inside your browser. Everybody love screenshot so 
here are some of Laraeval's screenshots.

Code Editor Window
![Code Editor Window](http://farm4.staticflickr.com/3757/9250820122_97e53cc739_b.jpg)

Output Window
![Output Window](http://farm8.staticflickr.com/7284/9248039007_2b66f4144e_b.jpg)

Profiler Window
![Profiler Window](http://farm3.staticflickr.com/2821/9250819862_c61d60950f_b.jpg)

## Installation ##

Add `laraeval/laraeval` as a requirement to `composer.json`:

```javascript
{
    ...
    "require": {
        ...
        "laraeval/laraeval": "1.0.*"
        ...
    },
}
```

Update composer:
```
$ php composer.phar update
```

Add the provider to your `app/config/app.php`:
```php
'providers' => array(

    ...
    'Laraeval\Laraeval\LaraevalServiceProvider',

),
```

Publish package assets:
```
$ php artisan asset:publish laraeval/laraeval
```

Publish package config:
```
$ php artisan config:publish laraeval/laraeval
```

## Usage ##

You can access Laraeval with the following URL http://yourhost/index.php/laraeval.

## Configuration ##

 * `allowed_ips`: List of IP addresses that allowed to access Laraeval.
 * `trusted_proxies`: List of Proxy IP that need to be trusted by Symfony Request object. This is needed when your application is behind proxy such as load balancer or such things. Use value '*' to trust all IP.

## Credit ##

* Laraeval is heavily inspired by Laravel 3 Bundle called *Console* https://github.com/Darsain/laravel-console. The author seems didn't have time to port it to L4 so I build Laraeval :).
* An awesome javascript editor CodeMirror http://codemirror.net/

## Contribute ##

There are a lot of improvements that can be made to Laraeval. Feel free to send me a **Pull Request**.
