<?php

namespace Tests\Unit\Models;

use Closure;
use App\Models\Book;
use App\Models\Image;
use App\Models\Author;
use App\Models\Follow;
use Tests\ModelTestCase;
use Illuminate\Support\Facades\Cache;

class AuthorTest extends ModelTestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->model = new Author();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->model);
    }

    public function test_model_configuration()
    {
        $this->assertEmpty($this->model->getGuarded());

        $this->assertSame('authors', $this->model->getTable());
        $this->assertSame('id', $this->model->getKeyName());

        $this->assertEmpty($this->model->getDates());
    }

    public function test_author_has_an_avatar()
    {
        $this->assertMorphOne('image', Image::class, 'imageable_id');
    }

    public function test_author_has_many_books()
    {
        $this->assertHasMany('books', Book::class, 'author_id');
    }

    public function test_author_has_many_followers()
    {
        $this->assertMorphMany('followers', Follow::class, 'followable_id');
    }

    public function test_author_has_default_avatar()
    {
        $this->assertSame(asset('storage/'. config('app.default-image.author')), $this->model->avatar);
    }

    public function test_author_avatar_is_cached()
    {
        $default = asset('storage/'. config('app.default-image.author'));

        Cache::shouldReceive('remember')
                ->once()
                ->with("author-{$this->model->id}-avatar", config('app.cache-time'), Closure::class)
                ->andReturn($default);
        $this->assertSame($default, $this->model->avatar);
    }

    public function test_author_fullname_is_first_combine_last()
    {
        $fname = 'Foo';
        $lname = 'Bar';
        $fullname = "{$fname} {$lname}";

        $this->model->first_name = $fname;
        $this->model->last_name = $lname;

        $this->assertSame($fullname, $this->model->fullname);
    }

    public function test_author_breadcrumb_is_fullname()
    {
        $fname = 'Foo';
        $lname = 'Bar';
        $fullname = "{$fname} {$lname}";

        $this->model->first_name = $fname;
        $this->model->last_name = $lname;

        $this->assertSame($fullname, $this->model->breadcrumb);
    }

}
