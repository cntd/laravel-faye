# laravel-faye
>  Laravel клиент для отправки моментальных сообщений с помощью [Faye](http://faye.jcoglan.com/)

## Установка

```shell
  composer require kodeks/laravel-faye 
```

Далее нужно добавить сервис провайдер в config/app.php

```shell
  'Kodeks\LaravelFaye\LaravelFayeServiceProvider',
```

##Использование

Необходимо установить коннект (например в global.php):

```shell
Faye::connect(Config::get('faye.server'));
