<?php

namespace Tests\Unit\Models;

use Mockery;
use App\Models\Like;
use App\Models\User;
use App\Models\Book;
use Tests\ModelTestCase;

class LikeTest extends ModelTestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->model = Mockery::mock(Like::class .'[of,check]');
    }

    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->model);
    }

    public function test_model_configuration()
    {
        $this->assertEmpty($this->model->getGuarded());

        $this->assertSame('likes', $this->model->getTable());
        $this->assertSame('id', $this->model->getKeyName());

        $this->assertSame([
            null,
            'liked_at',
        ], $this->model->getDates());
    }

    public function test_like_belongs_to_an_user()
    {
        $this->assertBelongsTo('user', User::class, 'user_id');
    }

    public function test_like_belongs_to_a_book()
    {
        $this->assertBelongsTo('book', Book::class, 'book_id');
    }

    public function test_model_can_get_like_by_user_and_book()
    {
        $user = new User();
        $book = new Book();

        $this->model->shouldReceive('of')
                    ->once()
                    ->with($user, $book)
                    ->andReturn(null);

        $this->assertNull($this->model::of($user, $book));
    }

    public function test_model_can_check_like_status_of_a_book()
    {
        $user = new User();
        $book = new Book();

        $this->model->shouldReceive('check')
                    ->once()
                    ->with($user, $book)
                    ->andReturn(false);

        $this->assertFalse($this->model::check($user, $book));
    }

}
