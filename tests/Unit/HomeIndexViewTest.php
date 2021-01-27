<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;


class HomeIndexViewTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        Auth::shouldReceive('user')
            ->once()
            ->andReturn(new User());
        Auth::shouldReceive('id')
            ->twice();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function test_index_view_can_be_rendered_to_guest()
    {
        Auth::shouldReceive('guard->guest')
            ->once()
            ->andReturn(true);

        $view = $this->view('home.index', [
            'randomBooks' => new Collection(),
            'randomAuthors' => new Collection(),
        ]);

        $view->assertSeeTextInOrder([
            'Library',
            'Home',
            'Books',
            'Guest',
            'Login',
            'Register',
            'en',
            'EN (English)',
            'VI (Vietnamese',
        ]);
    }

    public function test_index_view_can_be_rendered_to_logged_in_user()
    {
        Auth::shouldReceive('guard->guest')
            ->once();

        $view = $this->view('home.index', [
            'randomBooks' => new Collection(),
            'randomAuthors' => new Collection(),
        ]);

        $view->assertSeeTextInOrder([
            'Library',
            'Home',
            'Books',
            'Dashboard',
            'Profile',
            'Borrow History',
            'Logout',
            'en',
            'EN (English)',
            'VI (Vietnamese',
        ]);
    }

}
