<?php

namespace Tests\Unit\Http\Controllers\Dashboard;

use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Support\Facades\Gate;
use Mockery;
use Symfony\Component\HttpFoundation\ParameterBag;
use Tests\ControllerTestCase;

class CategoryControllerTest extends ControllerTestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->mockRepository(CategoryRepositoryInterface::class);
        $this->controller = $this->app->make(CategoryController::class);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    public function test_view_all_categories()
    {
        Gate::shouldReceive('authorize')->once();
        $this->repository->shouldReceive('paginate')->once();

        $view = $this->controller->index();

        $this->assertSame('dashboard.categories.index', $view->name());
        $this->assertArrayHasKey('categories', $view->getData());
    }

    public function test_view_create_category()
    {
        $categories = collect([new Category([
            'id' => 0,
            'name' => 'Foobar',
        ])]);

        Gate::shouldReceive('authorize')->once();
        $this->repository->shouldReceive('allWithoutFallback')
                            ->once()
                            ->andReturn($categories);

        $view = $this->controller->create();

        $this->assertSame('dashboard.categories.create', $view->name());
        $this->assertArrayHasKey('categories', $view->getData());
        $this->assertSame($categories, $view->getData()['categories']);
    }

    public function test_can_store_category()
    {
        $categoryRequest = new CategoryRequest();
        $categoryRequest->headers->set('content-type', 'application/json');
        $categoryRequest->setJson(new ParameterBag([
            'name' => 'Foobar',
        ]));

        $this->repository->shouldReceive('create')
                        ->once()
                        ->with([
                            'name' => 'Foobar',
                            'parent_id' => null,
                            'description' => null,
                        ]);

        $response = $this->controller->store($categoryRequest);

        $this->assertEquals(route('categories.index'), $response->headers->get('Location'));
    }

    public function test_view_edit_category()
    {
        $category = new Category();
        $categories = collect([new Category([
            'id' => 1,
            'name' => 'Foobar',
        ])]);

        Gate::shouldReceive('authorize')->once();
        $this->repository->shouldReceive('find')
                ->once()
                ->with(0)
                ->andReturn($category);
        $this->repository->shouldReceive('getValidParents')
                ->once()
                ->with(0)
                ->andReturn($categories);

        $view = $this->controller->edit(0);

        $this->assertSame('dashboard.categories.edit', $view->name());
        $this->assertArrayHasKey('category', $view->getData());
        $this->assertArrayHasKey('categories', $view->getData());
        $this->assertSame($category, $view->getData()['category']);
        $this->assertSame($categories, $view->getData()['categories']);
    }

    public function test_can_update_category()
    {
        $categoryRequest = new CategoryRequest();
        $categoryRequest->headers->set('content-type', 'application/json');
        $categoryRequest->setJson(new ParameterBag([
            'name' => 'Foobar',
        ]));

        $this->repository->shouldReceive('updateCategory')
                        ->once()
                        ->with(0, $categoryRequest);

        $response = $this->controller->update($categoryRequest, 0);

        $this->assertEquals(route('categories.index'), $response->headers->get('Location'));
    }

    public function test_can_destroy_category()
    {
        Gate::shouldReceive('authorize')->once();
        $this->repository->shouldReceive('deleteCategory')
                        ->once()
                        ->with(0);

        $response = $this->controller->destroy(0);
    }

}
