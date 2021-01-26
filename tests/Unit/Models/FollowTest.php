<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Models\Book;
use App\Models\Author;
use App\Models\Follow;
use Tests\ModelTestCase;

class FollowTest extends ModelTestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->model = new Follow();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->model);
    }

    public function test_model_configuration()
    {
        $this->assertEmpty($this->model->getGuarded());

        $this->assertSame('follows', $this->model->getTable());
        $this->assertSame('id', $this->model->getKeyName());

        $this->assertSame([
            null,
            'followed_at',
        ], $this->model->getDates());
    }

    public function test_follow_can_be_of_a_user()
    {
        $this->model->followable_type = 'user';

        $this->assertInstanceOf(User::class, $this->model->followable()->getRelated());
    }

    public function test_follow_can_be_of_a_author()
    {
        $this->model->followable_type = 'author';

        $this->assertInstanceOf(Author::class, $this->model->followable()->getRelated());
    }

    public function test_follow_can_be_of_a_book()
    {
        $this->model->followable_type = 'book';

        $this->assertInstanceOf(Book::class, $this->model->followable()->getRelated());
    }

    public function test_follow_belongs_to_an_user()
    {
        $this->assertBelongsTo('user', User::class, 'user_id');
    }

}
