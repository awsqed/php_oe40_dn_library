<?php

namespace Tests\Unit\Http\Controllers\Dashboard;

use App\Http\Controllers\Dashboard\BorrowRequestController;
use App\Models\BorrowRequest;
use App\Models\User;
use App\Repositories\Interfaces\BorrowRequestRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Mockery;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\ControllerTestCase;

class BorrowRequestControllerTest extends ControllerTestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->mockRepository(BorrowRequestRepositoryInterface::class);
        $this->controller = $this->app->make(BorrowRequestController::class);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    public function test_view_all_borrow_requests()
    {
        Gate::shouldReceive('authorize')->once();
        $this->repository->shouldReceive('search')->once();

        $view = $this->controller->index(new Request());

        $this->assertSame('dashboard.borrows.index', $view->name());
        $this->assertArrayHasKey('borrowRequests', $view->getData());
        $this->assertArrayHasKey('statusCode', $view->getData());
        $this->assertArrayHasKey('selection', $view->getData());
    }

    public function test_view_all_borrow_requests_with_filter()
    {
        Gate::shouldReceive('authorize')->once();
        $this->repository->shouldReceive('search')->once();

        $request = new Request();
        $request->headers->set('content-type', 'application/json');
        $request->setJson(new ParameterBag([
            'filter' => 1,
        ]));
        $view = $this->controller->index($request);

        $this->assertSame('dashboard.borrows.index', $view->name());
        $this->assertArrayHasKey('borrowRequests', $view->getData());
        $this->assertArrayHasKey('statusCode', $view->getData());
        $this->assertArrayHasKey('selection', $view->getData());
    }

    public function test_can_update_borrow_request()
    {
        Gate::shouldReceive('authorize', 'check')->once();

        $request = new Request();
        $request->headers->set('content-type', 'application/json');
        $request->setJson(new ParameterBag([
            'action' => 'foobar',
        ]));

        $this->repository->shouldReceive('updateBorrowRequest')
                            ->once()
                            ->with(0, 'foobar');
        $this->repository->shouldReceive('search')
                            ->once()
                            ->andReturn(collect([]));

        $response = $this->controller->update($request, 0);
    }

    public function test_cannot_destroy_other_users_borrow_request()
    {
        $borrowRequest = Mockery::mock(BorrowRequest::class);
        $borrowRequest->shouldReceive('user')
                        ->once()
                        ->andReturn(new User());

        $this->repository->shouldReceive('find')
                            ->once()
                            ->andReturn($borrowRequest);
        Auth::shouldReceive('user')->once();
        $this->expectException(HttpException::class);

        $response = $this->controller->destroy(0);
    }

    public function test_cannot_destroy_processed_borrow_request()
    {
        $user = new User();
        $borrowRequest = Mockery::mock(BorrowRequest::class);
        $borrowRequest->shouldReceive('user')
                        ->once()
                        ->andReturn($user);
        $borrowRequest->shouldReceive('getAttribute')
                        ->once()
                        ->with('status')
                        ->andReturn(Mockery::any());

        $this->repository->shouldReceive('find')
                            ->once()
                            ->andReturn($borrowRequest);
        Auth::shouldReceive('user')
            ->once()
            ->andReturn($user);
        $this->expectException(HttpException::class);

        $response = $this->controller->destroy(0);
    }

    public function test_can_destroy_own_borrow_request()
    {
        $user = new User();
        $borrowRequest = Mockery::mock(BorrowRequest::class);
        $borrowRequest->shouldReceive('user')
                        ->once()
                        ->andReturn($user);
        $borrowRequest->shouldReceive('getAttribute')
                        ->once()
                        ->with('status')
                        ->andReturn(null);

        $this->repository->shouldReceive('find', 'delete')
                            ->once()
                            ->andReturn($borrowRequest);
        Auth::shouldReceive('user')
            ->once()
            ->andReturn($user);

        $response = $this->controller->destroy(0);
    }

}
