<?php

namespace Tests\Unit\Http\Controllers\Dashboard;

use App\Http\Controllers\Dashboard\PublisherController;
use App\Http\Requests\PublisherRequest;
use App\Models\Publisher;
use App\Repositories\Interfaces\PublisherRepositoryInterface;
use Illuminate\Support\Facades\Gate;
use Mockery;
use Symfony\Component\HttpFoundation\ParameterBag;
use Tests\ControllerTestCase;

class PublisherControllerTest extends ControllerTestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->mockRepository(PublisherRepositoryInterface::class);
        $this->controller = $this->app->make(PublisherController::class);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    public function test_view_all_publishers()
    {
        Gate::shouldReceive('authorize')->once();
        $this->repository->shouldReceive('paginate')->once();

        $view = $this->controller->index();

        $this->assertSame('dashboard.publishers.index', $view->name());
        $this->assertArrayHasKey('publishers', $view->getData());
    }

    public function test_view_create_publisher()
    {
        Gate::shouldReceive('authorize')->once();

        $view = $this->controller->create();

        $this->assertSame('dashboard.publishers.create', $view->name());
    }

    public function test_can_store_publisher()
    {
        $publisherRequest = new PublisherRequest();
        $publisherRequest->headers->set('content-type', 'application/json');
        $publisherRequest->setJson(new ParameterBag([
            'name' => 'Foobar',
        ]));

        $this->repository->shouldReceive('createPublisher')
                            ->once()
                            ->with($publisherRequest);

        $response = $this->controller->store($publisherRequest);

        $this->assertEquals(route('publishers.index'), $response->headers->get('Location'));
    }

    public function test_view_edit_publisher()
    {
        $publisher = new Publisher();

        Gate::shouldReceive('authorize')
            ->once();
        $this->repository->shouldReceive('find')
                ->once()
                ->with(0)
                ->andReturn($publisher);

        $view = $this->controller->edit(0);

        $this->assertSame('dashboard.publishers.edit', $view->name());
        $this->assertArrayHasKey('publisher', $view->getData());
        $this->assertSame($publisher, $view->getData()['publisher']);
    }

    public function test_can_update_publisher()
    {
        $publisherRequest = new PublisherRequest();
        $publisherRequest->headers->set('content-type', 'application/json');
        $publisherRequest->setJson(new ParameterBag([
            'name' => 'Foobar',
        ]));

        $this->repository->shouldReceive('updatePublisher')
                            ->once()
                            ->with(0, $publisherRequest);

        $response = $this->controller->update($publisherRequest, 0);

        $this->assertEquals(route('publishers.index'), $response->headers->get('Location'));
    }

    public function test_can_destroy_publisher()
    {
        Gate::shouldReceive('authorize')->once();
        $this->repository->shouldReceive('delete')
                            ->once()
                            ->with(0);

        $response = $this->controller->destroy(0);
    }

}
