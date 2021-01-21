<?php

namespace Tests\Unit\Models;

use Mockery;
use App\Models\User;
use App\Models\Book;
use App\Models\Image;
use App\Models\Author;
use Tests\ModelTestCase;
use App\Models\Publisher;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ImageTest extends ModelTestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->model = new Image();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->model);
    }

    public function test_model_configuration()
    {
        $this->assertEmpty($this->model->getGuarded());

        $this->assertSame('images', $this->model->getTable());
        $this->assertSame('id', $this->model->getKeyName());

        $this->assertEmpty($this->model->getDates());
    }

    public function test_image_can_be_uploaded_as_user_avatar()
    {
        $this->model->imageable_type = 'user';

        $this->assertInstanceOf(User::class, $this->model->imageable()->getRelated());
    }

    public function test_image_can_be_uploaded_as_author_avatar()
    {
        $this->model->imageable_type = 'author';

        $this->assertInstanceOf(Author::class, $this->model->imageable()->getRelated());
    }

    public function test_image_can_be_uploaded_as_publisher_logo()
    {
        $this->model->imageable_type = 'publisher';

        $this->assertInstanceOf(Publisher::class, $this->model->imageable()->getRelated());
    }

    public function test_image_can_be_uploaded_as_book_cover()
    {
        $this->model->imageable_type = 'book';

        $this->assertInstanceOf(Book::class, $this->model->imageable()->getRelated());
    }

}
