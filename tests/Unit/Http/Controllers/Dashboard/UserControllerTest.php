<?php

namespace Tests\Unit\Http\Controllers\Dashboard;

use App\Http\Controllers\Dashboard\UserController;
use App\Http\Requests\UserRequest;
use App\Models\Permission;
use App\Models\User;
use App\Repositories\Interfaces\PermissionRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Gate;
use Mockery;
use Symfony\Component\HttpFoundation\ParameterBag;
use Tests\ControllerTestCase;

class UserControllerTest extends ControllerTestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->userRepo = $this->mockRepository(UserRepositoryInterface::class);
        $this->permRepo = $this->mockRepository(PermissionRepositoryInterface::class);
        $this->controller = $this->app->make(UserController::class);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    public function test_view_all_users()
    {
        Gate::shouldReceive('authorize')->once();
        $this->userRepo->shouldReceive('paginate')->once();

        $view = $this->controller->index();

        $this->assertSame('dashboard.users.index', $view->name());
        $this->assertArrayHasKey('users', $view->getData());
    }

    public function test_view_create_user()
    {
        $permissions = collect(new Permission([
            'id' => 0,
            'name' => 'foobar',
        ]));

        Gate::shouldReceive('authorize')->once();
        $this->permRepo->shouldReceive('all')
                ->once()
                ->andReturn($permissions);

        $view = $this->controller->create();

        $this->assertSame('dashboard.users.create', $view->name());
        $this->assertArrayHasKey('permissions', $view->getData());
        $this->assertSame($permissions, $view->getData()['permissions']);
    }

    public function test_can_store_user()
    {
        $userRequest = new UserRequest();
        $userRequest->headers->set('content-type', 'application/json');
        $userRequest->setJson(new ParameterBag([
            'username' => 'foobar',
            'email' => 'foobar@example.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ]));

        $this->userRepo->shouldReceive('createUser')
                        ->once()
                        ->with($userRequest);

        $response = $this->controller->store($userRequest);

        $this->assertEquals(route('users.index'), $response->headers->get('Location'));
    }

    public function test_view_edit_user_with_permissions()
    {
        $user = new User();
        $permissions = collect(new Permission([
            'id' => 0,
            'name' => 'foobar',
        ]));

        Gate::shouldReceive('authorize', 'allows')
            ->once()
            ->andReturn(true);
        $this->userRepo->shouldReceive('find')
                ->once()
                ->with(0)
                ->andReturn($user);
        $this->permRepo->shouldReceive('all')
                ->once()
                ->andReturn($permissions);

        $view = $this->controller->edit(0);

        $this->assertSame('dashboard.users.edit', $view->name());
        $this->assertArrayHasKey('user', $view->getData());
        $this->assertArrayHasKey('permissions', $view->getData());
        $this->assertSame($user, $view->getData()['user']);
        $this->assertSame($permissions, $view->getData()['permissions']);
    }

    public function test_view_edit_user_without_permissions()
    {
        $user = new User();

        Gate::shouldReceive('authorize', 'allows')->once();
        $this->userRepo->shouldReceive('find')
                ->once()
                ->with(0)
                ->andReturn($user);
        $this->permRepo->shouldNotReceive('all');

        $view = $this->controller->edit(0);

        $this->assertSame('dashboard.users.edit', $view->name());
        $this->assertArrayHasKey('user', $view->getData());
        $this->assertArrayHasKey('permissions', $view->getData());
        $this->assertSame($user, $view->getData()['user']);
        $this->assertEmpty($view->getData()['permissions']);
    }

    public function test_can_update_user()
    {
        $userRequest = new UserRequest();
        $userRequest->headers->set('content-type', 'application/json');
        $userRequest->setJson(new ParameterBag([
            'username' => 'foobar',
            'email' => 'foobar@example.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ]));

        $this->userRepo->shouldReceive('updateUser')
                        ->once()
                        ->with(0, $userRequest);

        $response = $this->controller->update($userRequest, 0);

        $this->assertEquals(route('users.index'), $response->headers->get('Location'));
    }

    public function test_can_destroy_user()
    {
        Gate::shouldReceive('authorize')->once();
        $this->userRepo->shouldReceive('deleteUser')
                        ->once()
                        ->with(0);

        $response = $this->controller->destroy(0);
    }

}
