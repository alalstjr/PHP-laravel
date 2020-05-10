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

# Model 데이터베이스에 저장

나의 local mysql 정보

~~~
database test
username root
password fhrmdls12
~~~

visual studio code sqltools 쿼리 조회상법

`View -> Command Palette -> SQL Run this file`

[https://laravel.kr/docs/7.x/eloquent#Eloquent%20%EB%AA%A8%EB%8D%B8%20%EC%BB%A8%EB%B2%A4%EC%85%98] - 모델 정의하기

~~~
php artisan make:model Flight -mc
~~~

Flight 라는 모델을 `/app/` 위치에 생성합니다.
Controller `/app/Http/Controllers/` 위치에 생성합니다.

> /database/migrations/최근생성된파일

~~~
...
public function up()
    {
        Schema::create('flights', function (Blueprint $table) {
            // Custom Code
            $table->bigIncrements("id");
            $table->unsignedInteger("user_id");
            $table->string("title");
            $table->text("description");
            // Custom Code
            $table->timestamps();
        });
    }
    ...
}    
~~~

~~~
php artisan migrate
~~~

database 업데이트

이 후 Controller 처리하여 view 를 생성합니다.

> namespace App\Http\Controllers;

~~~
class FlightController extends Controller
{
    public function create() 
    {
        return view("flights.create");
    }

    public function store(Request $request)
    {
        return $request -> all();
    }
}t
~~~

> resources/views/flights/create.blade.php

~~~
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>Create Page</h1>
            
            <form action="{{ route('flights.store') }}" method="post">
                @csrf
                <input type="text" name="text" placeholder="title">
                <input type="text" name="description" placeholder="description">
                <button>Create</button>
            </form>
        </div>
    </div>
</div>
@endsection
~~~