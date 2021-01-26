<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Models\Book;
use App\Models\Review;
use Tests\ModelTestCase;

class ReviewTest extends ModelTestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->model = new Review();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->model);
    }

    public function test_model_configuration()
    {
        $this->assertEmpty($this->model->getGuarded());

        $this->assertSame('reviews', $this->model->getTable());
        $this->assertSame('id', $this->model->getKeyName());

        $this->assertTrue($this->model->getIncrementing());

        $this->assertSame([
            'reviewed_at',
            null,
        ], $this->model->getDates());
    }

    public function test_review_has_a_rating_text()
    {
        $this->model->rating = 4;

        $this->assertSame('<span class="text-danger">★★★★</span>', $this->model->rating_text);
    }

}
