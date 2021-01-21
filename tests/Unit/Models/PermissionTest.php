<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Tests\ModelTestCase;
use App\Models\Permission;

class PermissionTest extends ModelTestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->model = new Permission();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->model);
    }

    public function test_model_configuration()
    {
        $this->assertEmpty($this->model->getGuarded());

        $this->assertSame('permissions', $this->model->getTable());
        $this->assertSame('id', $this->model->getKeyName());

        $this->assertEmpty($this->model->getDates());
    }

    public function test_permission_belongs_to_one_parent()
    {
        $this->assertBelongsTo('parent', Permission::class, 'parent_id');
    }

    public function test_permission_has_many_childs()
    {
        $this->assertHasMany('childs', Permission::class, 'parent_id');
    }

    public function test_permission_belongs_to_many_users()
    {
        $this->assertBelongsToMany('users', User::class, 'user_permissions', 'permission_id', 'user_id');
    }

    public function test_permission_breadcrumb_is_permission_name()
    {
        $name = 'test';
        $this->model->name = $name;

        $this->assertSame($name, $this->model->breadcrumb);
    }

}
