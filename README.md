# laravel-faye
>  Laravel клиент для отправки моментальных сообщений с помощью [Faye](http://faye.jcoglan.com/)

## Установка

```
  composer require kodeks/laravel-faye 
```

Далее нужно добавить сервис провайдер в config/app.php

```
  'Kodeks\LaravelFaye\LaravelFayeServiceProvider',
```

##Использование

Необходимо установить коннект (например в global.php):

```
Faye::connect(Config::get('faye.server'));
```

Дальше где угодно:

```
Faye::send('/test', 'Hi!');
```

> Третим параметром можно передать ext

> Если нужно получить ошибки можно использовать метод Faye::getLastError()
