# Laraeval [![Build Status](https://travis-ci.org/astasoft/laraeval.png)](https://travis-ci.org/astasoft/laraeval) #

It is often when developing an application we want to try some code 
just to figure it out something or test the output. We ended up by creating a bunch
of dummy controllers or routes just to test. Introducing **Laraeval**! a Laravel 4 package 
for evaluating your PHP code right inside your browser. With Laraeval you can
quickly prototyping code that flying around inside your head without having to create
a single file. Just fire up your browser and point to Laraeval address and you're
ready to go!.

Everybody love screenshot so here are some of Laraeval's screenshots.

Code Editor Window
![Code Editor Window](https://dl.dropboxusercontent.com/u/4674107/laraeval/code-editor.png)

Output Window
![Output Window](https://dl.dropboxusercontent.com/u/4674107/laraeval/output-window.png)

Profiler Window
![Profiler Window](https://dl.dropboxusercontent.com/u/4674107/laraeval/profiler-window.png)

Storage Window
![Profiler Window](https://dl.dropboxusercontent.com/u/4674107/laraeval/storage-window.png)

## Installation ##

Add `laraeval/laraeval` as a requirement to `composer.json`:

```javascript
{
    ...
    "require": {
        ...
        "laraeval/laraeval": "dev-master"
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

### Persistent Storage ###

Sometime you don't want to lose all your code when browser is closed, refreshed, crashed or anything else. How to do that? Simple, just add parameter `storageid=[ID]` to the query string when opening Laraeval. You can change `[ID]` with anything you like. Take a look an example below.

`http://yourhost/index.php/laraeval?storageid=foo`

Now even  when your browser is closed all your codes is not gone. Laraeval put it into your browser local storage. When you  open `http://yourhost/index.php/laraeval?storageid=foo` for the next time all your previous code will show up again.

## Configuration ##

You can edit the Laraeval configuration by editing file `app/config/packages/laraeval/laraeval/config.php`.

 * `allowed_ips`: List of IP addresses that allowed to access Laraeval.
 * `trusted_proxies`: List of Proxy IP that need to be trusted by Symfony Request object. This is needed when your application is behind proxy such as load balancer or such things. Use value '*' to trust all IP.
 * `localstorage_prefix`: Prefix used for saving the content (code) to the browser localstorage object.

## Credit ##

* Laraeval is heavily inspired by Laravel 3 Bundle called *Console* https://github.com/Darsain/laravel-console. The author seems didn't have time to port it to L4 so I build Laraeval :).
* An awesome javascript editor CodeMirror http://codemirror.net/

## Contribute ##

There are a lot of improvements that can be made to Laraeval. Feel free to send me a **Pull Request**.

## License ##

Laraeval is open source licensed under [MIT license](http://opensource.org/licenses/MIT).
