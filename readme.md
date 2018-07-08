uSchedule
=========

Installation:
-------------
```
1. Console: "composer install"
2. Console: "npm install"
3. Clone .env.example to .env file
4. Config .env file for your configuration
5. Console: "php artisan key:generate"
6. Console: "php artisan jwt:secret"
.. @todo Frontend
```

TODO:
-----
- [x] Teachers
  - [x] api.index (params - search, orderBy, page)
  - [x] api.show
  - [x] api.store
  - [x] api.update
  - [x] api.destroy
- [ ] Subjects
  - [ ] api.index (params - search, orderBy, page)
  - [ ] api.show
  - [ ] api.store
  - [ ] api.update
  - [ ] api.destroy
- [ ] Users
  - [ ] api.index (params - search, orderBy, page)
  - [ ] api.show
  - [ ] api.store
  - [ ] api.update
  - [ ] api.destroy
- [ ] Auth
  - [x] api.login
  - [x] api.logout
  - [x] api.register
  - [x] api.me
  - [x] api.refresh
  - [ ] api.restore
  
![Database](/database.png)
