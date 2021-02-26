<?php

namespace Tests\Unit\Http\Controllers\Dashboard;

use App\Http\Controllers\Dashboard\PermissionController;
use App\Models\Permission;
use App\Repositories\Interfaces\PermissionRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Mockery;
use Symfony\Component\HttpFoundation\ParameterBag;
use Tests\ControllerTestCase;

class PermissionControllerTest extends ControllerTestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->mockRepository(PermissionRepositoryInterface::class);
        $this->controller = $this->app->make(PermissionController::class);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    public function test_view_all_permissions()
    {
        Gate::shouldReceive('authorize')->once();
        $this->repository->shouldReceive('paginate')->once();

        $view = $this->controller->index();

        $this->assertSame('dashboard.permissions.index', $view->name());
        $this->assertArrayHasKey('permissions', $view->getData());
    }

    public function test_view_edit_permission()
    {
        $permission = new Permission();

        Gate::shouldReceive('authorize')->once();
        $this->repository->shouldReceive('find')
                            ->once()
                            ->andReturn($permission);

        $view = $this->controller->edit(0);

        $this->assertSame('dashboard.permissions.edit', $view->name());
        $this->assertArrayHasKey('permission', $view->getData());
        $this->assertArrayHasKey('childs', $view->getData());
        $this->assertSame($permission, $view->getData()['permission']);
        $this->assertEmpty($view->getData()['childs']);
    }

    public function test_can_update_permission()
    {
        Gate::shouldReceive('authorize')->once();

        $request = new Request();
        $request->headers->set('content-type', 'application/json');
        $request->setJson(new ParameterBag([
            'description' => 'foobar',
        ]));

        $this->repository->shouldReceive('update')
                            ->once()
                            ->with(0, [
                                'description' => 'foobar',
                            ]);

        $response = $this->controller->update($request, 0);

        $this->assertEquals(route('permissions.index'), $response->headers->get('Location'));
    }

}
