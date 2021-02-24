<?php

namespace Tests\Unit\Http\Controllers\Dashboard;

use App\Http\Controllers\Dashboard\DashboardController;
use App\Repositories\Interfaces\BorrowRequestRepositoryInterface;
use Mockery;
use Tests\ControllerTestCase;

class DashboardControllerTest extends ControllerTestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->mockRepository(BorrowRequestRepositoryInterface::class);
        $this->controller = $this->app->make(DashboardController::class);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    public function test_view_index()
    {
        $now = now();

        $this->repository->shouldReceive('whereDate')
                            ->once()
                            ->with($now->toDateString())
                            ->andReturn(collect([]));
        $this->repository->shouldReceive('whereMonth')
                            ->once()
                            ->with($now->month)
                            ->andReturn(collect([]));
        $this->repository->shouldReceive('whereYear')
                            ->once()
                            ->with($now->year)
                            ->andReturn(collect([]));

        $view = $this->controller->index();

        $data = [
            'todayCount',
            'monthlyCount',
            'yearlyCount',
            'date',
            'month',
            'year',
        ];

        $this->assertSame('dashboard.index', $view->name());
        foreach ($data as $value) {
            $this->assertArrayHasKey($value, $view->getData());
        }
    }

}
