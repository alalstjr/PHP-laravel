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

명령어를 실행하므로서 데이터베이스에 테이블을 생성합니다.

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

# One to One relationship

[https://www.lesstif.com/laravelprog/one-to-one-27295882.html] - 일대일(One to One) 설명

1 : 1 관계란 어느 엔티티 쪽에서 상대 엔티티를 보더라도 반드시 단 하나씩 관계를 가지는 것을 말합니다.

~~~
A <-> B
C <-> D

A <-> D (X)
~~~

간단 예제를 만들어 보겠습니다.

- DATABASE
    - users
    - profile

~~~
php artisan make:model Users -mc
php artisan make:model Profile -mc
~~~

> /database/migration/users

~~~
public function up()
{
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        $table->rememberToken();
        $table->timestamps();
    });
}

~~~

> /database/migration/profile

~~~
public function up()
{
    Schema::create('profiles', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('userId');
        $table->string('phone')->nullable();
        $table->string('address')->nullable();
        $table->string('nationality')->nullable();
        $table->timestamps();
    });
}
~~~

데이터베이스 테이블 컬럼을 작성합니다.

이후 User Model 에 Profile 테이블을 One 관계를 설정합니다.

> /app/User.php

~~~
public function userProfile()
{
    return $this->hasOne('App/Profile');
}
~~~

다음 View 출력해주기 위해서 Route 설정을 합니다.

> web.php

~~~
// Profile
Route::get("users/{id}", "ProfileController@show")->name("user.profile.show");
~~~

Route 설정 후 ProfileController show 메소드를 완성합니다.

> /app/Http/Controller/ProfileController.php

~~~

~~~

# Many to Many relationship

[https://laravel.kr/docs/7.x/migrations] - 마이그레이션 파일 생성하기

~~~
php artisan make:model Post --migration -mc
php artisan make:model Tag --migration -mc
~~~

-mc : 명령어는 model, controller 생성을 의미합니다.

Post 와 Tag 중간 역할을 하는 테이블 생성

~~~
php artisan make:migration create_post_tag_table --create=post_tag
~~~

## 외래키 제약조건 추가

[https://laravel.kr/docs/7.x/migrations#%EC%99%B8%EB%9E%98%ED%82%A4%20%EC%A0%9C%EC%95%BD%EC%A1%B0%EA%B1%B4(Constraints)] - 외래키 제약조건(Constraints)

~~~
$table->
foreign('tag_id')->
references('id')->
on('tags')->
onDelete('cascade');
~~~

"on delete" 와 "on update" 는 연관되어 있는 테이블이 삭제가 되거나 업데이트가 되면 같이 반응하도록 설정하는 메소드입니다.


[https://juyoung-1008.tistory.com/17] - mysql 컬럼 수정