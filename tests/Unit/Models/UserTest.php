<?php

namespace Tests\Unit\Models;

use Closure;
use App\Models\User;
use App\Models\Book;
use App\Models\Like;
use App\Models\Image;
use App\Models\Follow;
use Tests\ModelTestCase;
use App\Models\Permission;
use Illuminate\Support\Facades\Cache;

class UserTest extends ModelTestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->model = new User();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->model);
    }

    public function test_model_configuration()
    {
        $this->assertEmpty($this->model->getGuarded());
        $this->assertSame([
            'password',
            'remember_token',
        ], $this->model->getHidden());

        $this->assertSame('users', $this->model->getTable());
        $this->assertSame('id', $this->model->getKeyName());

        $this->assertSame([
            'created_at',
            'updated_at',
        ], $this->model->getDates());
    }

    public function test_user_has_an_avatar()
    {
        $this->assertMorphOne('imageRelation', Image::class, 'imageable_id');
    }

    public function test_user_has_many_permissions()
    {
        $this->assertBelongsToMany('permissions', Permission::class, 'user_permissions', 'user_id', 'permission_id');
    }

    public function test_user_has_many_borrow_requests()
    {
        $this->assertBelongsToMany('bookBorrowRequests', Book::class, 'borrow_requests', 'user_id', 'book_id', [
            'from',
            'to',
            'note',
            'status',
            'processed_at',
            'returned_at',
            'created_at',
            'updated_at',
        ]);
    }

    public function test_user_has_many_likes()
    {
        $this->assertHasMany('likes', Like::class, 'user_id');
    }

    public function test_user_can_follow_many()
    {
        $this->assertHasMany('followings', Follow::class, 'user_id');
    }

    public function test_user_has_many_followers()
    {
        $this->assertMorphMany('followers', Follow::class, 'followable_id');
    }

    public function test_user_has_many_reviews()
    {
        $this->assertBelongsToMany('reviews', Book::class, 'reviews', 'user_id', 'book_id', [
            'rating',
            'comment',
            'reviewed_at',
        ]);
    }

    public function test_user_has_default_avatar()
    {
        $default = asset('storage/'. config('app.default-image.user'));

        $cacheKey = get_class($this->model) .'.'. $this->model->id;
        Cache::shouldReceive('remember')
                ->once()
                ->with($cacheKey, config('app.cache-time'), Closure::class)
                ->andReturn($default);
        $this->assertSame($default, $this->model->avatar);
    }

    public function test_user_avatar_is_cached()
    {
        $default = asset('storage/'. config('app.default-image.user'));

        $cacheKey = get_class($this->model) .'.'. $this->model->id;
        Cache::shouldReceive('remember')
                ->once()
                ->with($cacheKey, config('app.cache-time'), Closure::class)
                ->andReturn($default);
        $this->assertSame($default, $this->model->avatar);
    }

    public function test_user_permissions_is_cached()
    {
        Cache::shouldReceive('remember')
                ->once()
                ->with('foobar', config('app.cache-time'), Closure::class)
                ->andReturn(false);

        $this->assertFalse($this->model->hasPermission('foobar'));
    }

    public function test_user_fullname_is_first_combine_last()
    {
        $fname = 'Foo';
        $lname = 'Bar';
        $fullname = "{$fname} {$lname}";

        $this->model->first_name = $fname;
        $this->model->last_name = $lname;

        $this->assertSame($fullname, $this->model->fullname);
    }

    public function test_user_breadcrumb_is_username()
    {
        $username = 'foobar';
        $this->model->username = $username;

        $this->assertSame($username, $this->model->breadcrumb);
    }

}
