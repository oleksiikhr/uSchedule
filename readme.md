uSchedule
=========

Installation:
-------------

```
1. Console: "composer update"
2. Console: "npm install"
3. Copy .env
4. Config .env file for your configuration
5. Console: "php artisan key:generate"
6. Console: "php artisan jwt:secret"
```

Информация для разработчиков (рус.):
------
- Все ошибки в php коде должны возвращать массив с
элементом `message`, для вызова Snackbar:

```php
['message' => 'Error text']
```
