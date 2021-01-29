<?php

namespace Tests\Unit\Models;

use Closure;
use App\Models\User;
use App\Models\Book;
use App\Models\Like;
use App\Models\Image;
use App\Models\Author;
use App\Models\Follow;
use App\Models\Category;
use Tests\ModelTestCase;
use App\Models\Publisher;
use Illuminate\Support\Facades\Cache;

class BookTest extends ModelTestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->model = new Book();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->model);
    }

    public function test_model_configuration()
    {
        $this->assertEmpty($this->model->getGuarded());

        $this->assertSame('books', $this->model->getTable());
        $this->assertSame('id', $this->model->getKeyName());

        $this->assertSame([
            'created_at',
            'updated_at',
        ], $this->model->getDates());
    }

    public function test_book_has_a_cover()
    {
        $this->assertMorphOne('imageRelation', Image::class, 'imageable_id');
    }

    public function test_book_belongs_to_an_author()
    {
        $this->assertBelongsTo('author', Author::class, 'author_id');
    }

    public function test_book_belongs_to_a_publisher()
    {
        $this->assertBelongsTo('publisher', Publisher::class, 'publisher_id');
    }

    public function test_book_belongs_to_a_category()
    {
        $this->assertBelongsTo('category', Category::class, 'category_id');
    }

    public function test_book_has_many_borrowers()
    {
        $this->assertBelongsToMany('borrowers', User::class, 'borrow_requests', 'book_id', 'user_id', [
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

    public function test_book_has_many_likes()
    {
        $this->assertHasMany('likes', Like::class, 'book_id');
    }

    public function test_book_has_many_followers()
    {
        $this->assertMorphMany('followers', Follow::class, 'followable_id');
    }

    public function test_book_has_many_reviews()
    {
        $this->assertBelongsToMany('reviews', User::class, 'reviews', 'book_id', 'user_id', [
            'rating',
            'comment',
            'reviewed_at',
        ]);
    }

    public function test_book_has_default_cover()
    {
        $default = asset('storage/'. config('app.default-image.book'));

        $cacheKey = get_class($this->model) .'.'. $this->model->id;
        Cache::shouldReceive('remember')
                ->once()
                ->with($cacheKey, config('app.cache-time'), Closure::class)
                ->andReturn($default);
        $this->assertSame($default, $this->model->cover);
    }

    public function test_book_cover_is_cached()
    {
        $default = asset('storage/'. config('app.default-image.book'));

        $cacheKey = get_class($this->model) .'.'. $this->model->id;
        Cache::shouldReceive('remember')
                ->once()
                ->with($cacheKey, config('app.cache-time'), Closure::class)
                ->andReturn($default);
        $this->assertSame($default, $this->model->cover);
    }

    public function test_book_has_an_average_rating()
    {
        $this->assertSame(0, $this->model->avg_rating);
    }

    public function test_book_can_print_average_rating_text()
    {
        $this->assertSame('☆☆☆☆☆', $this->model->printAvgRatingText());
    }

}
