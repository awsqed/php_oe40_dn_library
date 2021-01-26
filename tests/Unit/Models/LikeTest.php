<?php

namespace Tests\Unit\Models;

use App\Models\Like;
use App\Models\User;
use App\Models\Book;
use Tests\ModelTestCase;

class LikeTest extends ModelTestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->model = new Like();
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

}
