<?php

namespace Tests\Unit\Models;

use Closure;
use App\Models\Book;
use App\Models\Image;
use Tests\ModelTestCase;
use App\Models\Publisher;
use Illuminate\Support\Facades\Cache;

class PublisherTest extends ModelTestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->model = new Publisher();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->model);
    }

    public function test_model_configuration()
    {
        $this->assertEmpty($this->model->getGuarded());

        $this->assertSame('publishers', $this->model->getTable());
        $this->assertSame('id', $this->model->getKeyName());

        $this->assertEmpty($this->model->getDates());
    }

    public function test_publisher_has_a_logo()
    {
        $this->assertMorphOne('image', Image::class, 'imageable_id');
    }

    public function test_publisher_has_many_books()
    {
        $this->assertHasMany('books', Book::class, 'publisher_id');
    }

    public function test_publisher_has_default_logo()
    {
        $this->assertSame(asset('storage/'. config('app.default-image.publisher')), $this->model->logo);
    }

    public function test_publisher_logo_is_cached()
    {
        $default = asset('storage/'. config('app.default-image.publisher'));

        Cache::shouldReceive('remember')
                ->once()
                ->with("publisher-{$this->model->id}-logo", config('app.cache-time'), Closure::class)
                ->andReturn($default);
        $this->assertSame($default, $this->model->logo);
    }

    public function test_publisher_breadcrumb_is_name()
    {
        $name = 'foobar';
        $this->model->name = $name;

        $this->assertSame($name, $this->model->breadcrumb);
    }

}
