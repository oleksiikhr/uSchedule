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

Notes for developers:
------
- All errors in the php code should return array:

```php
['message' => 'error text']
```

*To call Snackbar
