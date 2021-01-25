<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\UserPermission;

class UserPermissionTest extends TestCase
{

    protected $model;

    public function setUp(): void
    {
        parent::setUp();
        $this->model = new UserPermission();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->model);
    }

    public function test_model_configuration()
    {
        $this->assertEmpty($this->model->getGuarded());

        $this->assertSame('user_permissions', $this->model->getTable());
        $this->assertSame('id', $this->model->getKeyName());

        $this->assertTrue($this->model->getIncrementing());

        $this->assertEmpty($this->model->getDates());
    }

}
