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
DB_DATABASE=test
DB_USERNAME=root
DB_PASSWORD=fhrmdls12
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

# 부트스트랩 적용

~~~
composer require laravel/ui
php artisan ui bootstrap
php artisan ui bootstrap --auth
npm install
npm run dev
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
php artisan make:model Blog -mc
~~~

Blog 라는 모델을 `/app/` 위치에 생성합니다.
Controller `/app/Http/Controllers/` 위치에 생성합니다.

> /database/migrations/최근생성된파일

~~~
...
public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
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
class BlogController extends Controller
{
    public function create() 
    {
        return view("blogs.create");
    }

    public function store(Request $request)
    {
        return $request -> all();
    }
}t
~~~

> resources/views/blogs/create.blade.php

~~~
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>Create Page</h1>
            
            <form action="{{ route('blogs.store') }}" method="post">
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

Route 설정

> web.php

~~~
// BlogController
Route::get("/blog/create", "BlogController@create")->name("blogs.create");
Route::post("/blog/store", "BlogController@store")->name("blogs.store");
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
        $table->unsignedBigInteger('user_id');
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
class ProfileController extends Controller
{
    public function show($id)
    {
        $user = User::find($id)->profile;

        dd($user);
    }
}
~~~

유저가 가지고있는 profile 정보를 가져옵니다.

# One To Many

주로 사용하는 예제는 포스트 하나에 등록된 댓글 여러개..

1 : M 관계는 한 쪽 엔티티가 관계를 맺은 엔티티 쪽의 여러 객체를 가질 수 있는 것을 의미합니다.

이 관계는 매우 흔한 방식이며, 실제 DB를 설계할 때 자주 쓰이는 방식입니다.

~~~
A -> B, C, D, E ...
~~~

간단 예제를 만들어 보겠습니다.

- DATABASE
    - comment

~~~
php artisan make:model Comment -mc
~~~

> /database/migrations/CreateCommentsTable

~~~
public function up()
{
    Schema::create('comments', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('post_id');
        $table->text('text');
        $table->timestamps();
    });
}
~~~

이후 Post Model 에 Comment 테이블을 `One to Many` 관계를 설정합니다.

> /app/Post.php

~~~
class Post extends Model
{
    // 대량 할당 - Mass Assignment
    protected $guarded = [];

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
}
~~~

다음 View 출력해주기 위해서 Route 설정을 합니다.

> web.php

~~~
// Post
Route::get('/post/{id}', "PostController@show")->name('posts.show');
Route::post('/comments', "CommentController@store")->name('comments.store');
~~~

댓글 생성 Controller 설정

> App\Http\Controllers/CommentController

~~~
class CommentController extends Controller
{
    public function store(Request $request)
    {
        Comment::create([
            'user_id' => $request->user()->id,
            'post_id' => $request->post_id,
            'text' => $request->text,
        ]);

        return redirect()->back();
    }
}
~~~

게시글 생성 Controller 설정

> App\Http\Controllers\PostController

~~~
class PostController extends Controller
{
    public function show($id)
    {
        $post = Post::with(['comments'])->where('id', $id)->firstOrFail();

        return view('posts.show', compact('post'));
    }

    public function store(Request $request)
    {
        Post::create([
            'user_id' => $request->user()->id,
            'title' => $request->title,
        ]);

        return redirect()->back();
    }
}
~~~

> resources/views/post/show.blade.php

~~~
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1>Post Show Page</h1>
                <p>Post Title : {{ $post->title }}</p>
            </div>

            <h2>Post Comment List</h2>
            <div>
                @foreach($post->comments as $comment)
                    <p>{{ $comment->text }}</p>
                @endforeach
            </div>

            <form action="{{ route('comments.store') }}" method="post">
                @csrf
                <input type="text" name="post_id" value="{{ $post->id }}">
                <input type="text" name="text" placeholder="text">
                <button>Create</button>
            </form>
        </div>
    </div>
@endsection
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

# mysql 데이터베이스 컬럼 추가

마이그레이션을 생성하기 위해 Artisan CLI에서 migrate : make 명령을 사용할 수 있습니다. 기존 모델과의 충돌을 피하려면 특정 이름을 사용하십시오.

라 라벨 3

php artisan migrate:make add_paid_to_users
라 라벨 5 이상 :

php artisan make:migration add_paid_to_users_table --table=users
그런 다음 Schema::table()새 테이블을 작성하지 않고 기존 테이블에 액세스 할 때 메소드 를 사용해야합니다 . 그리고 다음과 같은 열을 추가 할 수 있습니다.

public function up()
{
    Schema::table('users', function($table) {
        $table->integer('paid');
    });
}
롤백 옵션을 추가하는 것을 잊지 마십시오.

public function down()
{
    Schema::table('users', function($table) {
        $table->dropColumn('paid');
    });
}

https://stackoverflow.com/questions/16791613/add-a-new-column-to-existing-table-in-a-migration

# 새로운 마이그래이션 추가

php artisan make:migration create_users_table --create=users

# 커스텀 로그인

https://stackoverflow.com/questions/61320547/laravel-7-change-name-of-login-credentials

# Valid

유저 인지 아닌지 체크

https://laravel.com/docs/7.x/validation#rule-required-if

# 보류) 로그인 붙이기

https://gracefullight.dev/2017/07/09/Laravel-5-4-Login-with-Auth/

# 커스텀 헬퍼함수 추가

https://zetawiki.com/wiki/Laravel_%EC%BB%A4%EC%8A%A4%ED%85%80_%ED%97%AC%ED%8D%BC_%ED%95%A8%EC%88%98_%EC%B6%94%EA%B0%80

# 엑셀 기능

https://www.itsolutionstuff.com/post/laravel-6-import-export-excel-csv-file-tutorialexample.html
https://m.blog.naver.com/rladlaks123/221774073215

# 페이징 그리고 정렬

https://www.itsolutionstuff.com/post/laravel-7-pagination-tutorialexample.html
https://stackoverflow.com/questions/20701216/laravel-default-orderby

# active function

https://www.codechief.org/article/laravel-6-how-to-make-menu-item-active-by-urlroute#gsc.tab=0

# 소켓 통신

https://github.com/andhikayuana/laravel-socket.io
https://modestasv.com/chat-with-laravel-pusher-and-socket-io-at-your-command/

# AWS

https://tech.cloud.nongshim.co.kr/2018/10/11/%EC%B4%88%EB%B3%B4%EC%9E%90%EB%A5%BC-%EC%9C%84%ED%95%9C-aws-%EC%9B%B9%EA%B5%AC%EC%B6%95-%EC%9B%B9%EC%84%9C%EB%B2%84-%EC%95%84%ED%82%A4%ED%85%8D%EC%B2%98-%EC%86%8C%EA%B0%9C/
