<?php

namespace Tests\Unit\Http\Controllers\Dashboard;

use App\Http\Controllers\Dashboard\AuthorController;
use App\Http\Requests\AuthorRequest;
use App\Models\Author;
use App\Repositories\Interfaces\AuthorRepositoryInterface;
use Illuminate\Support\Facades\Gate;
use Mockery;
use Symfony\Component\HttpFoundation\ParameterBag;
use Tests\ControllerTestCase;

class AuthorControllerTest extends ControllerTestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->authorRepo = $this->mockRepository(AuthorRepositoryInterface::class);
        $this->controller = $this->app->make(AuthorController::class);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    public function test_view_all_authors()
    {
        Gate::shouldReceive('authorize')->once();
        $this->authorRepo->shouldReceive('paginate')->once();

        $view = $this->controller->index();

        $this->assertSame('dashboard.authors.index', $view->name());
        $this->assertArrayHasKey('authors', $view->getData());
    }

    public function test_view_create_author()
    {
        Gate::shouldReceive('authorize')->once();

        $view = $this->controller->create();

        $this->assertSame('dashboard.authors.create', $view->name());
    }

    public function test_can_store_author()
    {
        $authorRequest = new AuthorRequest();
        $authorRequest->headers->set('content-type', 'application/json');
        $authorRequest->setJson(new ParameterBag([
            'first_name' => 'Foo',
            'last_name' => 'Bar',
            'gender' => 0,
            'date_of_birth' => '1990-01-01',
        ]));

        $this->authorRepo->shouldReceive('createAuthor')
                            ->once()
                            ->with($authorRequest);

        $response = $this->controller->store($authorRequest);

        $this->assertEquals(route('authors.index'), $response->headers->get('Location'));
    }

    public function test_view_edit_author()
    {
        $author = new Author();

        Gate::shouldReceive('authorize')
            ->once();
        $this->authorRepo->shouldReceive('find')
                ->once()
                ->with(0)
                ->andReturn($author);

        $view = $this->controller->edit(0);

        $this->assertSame('dashboard.authors.edit', $view->name());
        $this->assertArrayHasKey('author', $view->getData());
        $this->assertSame($author, $view->getData()['author']);
    }

    public function test_can_update_author()
    {
        $authorRequest = new AuthorRequest();
        $authorRequest->headers->set('content-type', 'application/json');
        $authorRequest->setJson(new ParameterBag([
            'first_name' => 'Foo',
            'last_name' => 'Bar',
            'gender' => 0,
            'date_of_birth' => '1990-01-01',
        ]));

        $this->authorRepo->shouldReceive('updateAuthor')
                            ->once()
                            ->with(0, $authorRequest);

        $response = $this->controller->update($authorRequest, 0);

        $this->assertEquals(route('authors.index'), $response->headers->get('Location'));
    }

    public function test_can_destroy_author()
    {
        Gate::shouldReceive('authorize')->once();
        $this->authorRepo->shouldReceive('delete')
                            ->once()
                            ->with(0);

        $response = $this->controller->destroy(0);
    }

}
