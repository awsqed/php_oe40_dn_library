<?php

namespace Tests;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

abstract class ModelTestCase extends TestCase
{

    protected function assertBelongsTo($relation, $related, $foreignKey)
    {
        $belongsTo = $this->model->$relation();

        $this->assertInstanceOf(BelongsTo::class, $belongsTo);
        $this->assertInstanceOf($related, $belongsTo->getRelated());
        $this->assertSame($foreignKey, $belongsTo->getForeignKeyName());
    }

    protected function assertHasMany($relation, $related, $foreignKey)
    {
        $hasMany = $this->model->$relation();

        $this->assertInstanceOf(HasMany::class, $hasMany);
        $this->assertInstanceOf($related, $hasMany->getRelated());
        $this->assertSame($foreignKey, $hasMany->getForeignKeyName());
    }

    protected function assertBelongsToMany($relation, $related, $pivotTable, $foreignKey, $relatedKey, $pivotColumns = [])
    {
        $belongsToMany = $this->model->$relation();

        $this->assertInstanceOf(BelongsToMany::class, $belongsToMany);
        $this->assertInstanceOf($related, $belongsToMany->getRelated());
        $this->assertSame($pivotTable, $belongsToMany->getTable());
        $this->assertSame($foreignKey, $belongsToMany->getForeignPivotKeyName());
        $this->assertSame($relatedKey, $belongsToMany->getRelatedPivotKeyName());
        $this->assertSame($pivotColumns, $belongsToMany->getPivotColumns());
    }

    protected function assertMorphOne($relation, $related, $foreignKey)
    {
        $morphOne = $this->model->$relation();

        $this->assertInstanceOf(MorphOne::class, $morphOne);
        $this->assertInstanceOf($related, $morphOne->getRelated());

        $this->assertSame($foreignKey, $morphOne->getForeignKeyName());
    }

    protected function assertMorphMany($relation, $related, $foreignKey)
    {
        $morphMany = $this->model->$relation();

        $this->assertInstanceOf(MorphMany::class, $morphMany);
        $this->assertInstanceOf($related, $morphMany->getRelated());

        $this->assertSame($foreignKey, $morphMany->getForeignKeyName());
    }

}
