<?php

namespace Tests\Unit\Models;

use App\Models\Book;
use App\Models\Category;
use Tests\ModelTestCase;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoryTest extends ModelTestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->model = new Category();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->model);
    }

    public function test_model_configuration()
    {
        $this->assertEmpty($this->model->getGuarded());

        $this->assertSame('categories', $this->model->getTable());
        $this->assertSame('id', $this->model->getKeyName());

        $this->assertEmpty($this->model->getDates());
    }

    public function test_category_belongs_to_one_parent()
    {
        $this->assertBelongsTo('parent', Category::class, 'parent_id');
    }

    public function test_category_has_many_childs()
    {
        $this->assertHasMany('childs', Category::class, 'parent_id');
    }

    public function test_category_has_many_books()
    {
        $this->assertHasMany('books', Book::class, 'category_id');
    }

    public function test_category_breadcrumb_is_category_name()
    {
        $name = 'foobar';
        $this->model->name = $name;

        $this->assertSame($name, $this->model->breadcrumb);
    }

}
