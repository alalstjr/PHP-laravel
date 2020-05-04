# 설치방법

## Composer 설치

- 설치 영상
[https://www.youtube.com/watch?v=t-Db7yU84DY] - Composer 설치방법

- 설치 사이트
[https://getcomposer.org/download/] - Composer 다운로드
[https://getcomposer.org/doc/00-intro.md#globally] - Composer 설치


## Laravel 설치

~~~
composer create-project --prefer-dist laravel/laravel blog
~~~

## Laravel 실행

~~~
php artisan serve
~~~

혹은 package.json start 추가 

> package.json

~~~
    "scripts": {
        ...
        "start" : "php artisan serve"
    },
~~~

# MySQL MariaDB

~~~
mysql.server start

mysql -uroot -p
~~~

[https://whitepaek.tistory.com/16] - MySQL 설치방법

# DB 연결 방법

> .env

~~~
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
~~~

# Authentication 설정

[https://laravel.kr/docs/7.x/authentication] - Lalabel 인증

## Authentication View 설정

~~~
composer require laravel/ui --dev

php artisan ui vue --auth
~~~

인증 관련 View 생성 명령어

## authentication Table 설정

> blog/database/migrations

~~~
php artisan migrate
~~~

# CRUD Controller

[https://laravel.kr/docs/7.x/controllers] - Controller

Router List 확인 명령어

~~~
php artisan route:list
~~~

간단하게 CRUD 생성하기

~~~
php artisan make:controller PhotoController --resource
~~~

> app/Http/Controllers/PhotoController.php

~~~
Route::resource('photos', 'PhotoController');
~~~

위처럼 설정 하므로서 get, post, put, delete... 같은 중복의 코드를 줄여서 `resource` 하나로 사용할 수 있습니다.