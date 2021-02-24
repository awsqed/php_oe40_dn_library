<?php

namespace Tests;

use Mockery;

abstract class ControllerTestCase extends TestCase
{

    protected function mockRepository($mockClass)
    {
        $mock = Mockery::mock($mockClass);
        $this->app->instance($mockClass, $mock);

        return $mock;
    }

}
