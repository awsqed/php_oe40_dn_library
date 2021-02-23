<?php

namespace Tests\Unit\Models;

use Mockery;
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
        $this->assertBelongsTo('allParents', Permission::class, 'parent_id');
        $this->assertEmpty($this->model->parentArray());
    }

    public function test_permission_has_many_childs()
    {
        $this->assertHasMany('childs', Permission::class, 'parent_id');
        $this->assertHasMany('allChilds', Permission::class, 'parent_id');
        $this->assertEmpty($this->model->childArray());
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

    public function test_permission_can_get_all_parents()
    {
        $model = Mockery::mock(Permission::class .'[__get]');
        $model->shouldReceive('__get')
                ->once()
                ->with('allParents')
                ->andReturn(new Permission());

        $this->assertNotEmpty($model->parentArray());
    }

    public function test_permission_can_get_all_childs()
    {
        $model = Mockery::mock(Permission::class .'[__get]');
        $model->shouldReceive('__get')
                ->once()
                ->with('allChilds')
                ->andReturn(collect([new Permission()]));

        $this->assertNotEmpty($model->childArray());
    }

}
