<?php

namespace App\Observers;

use App\Models\Author;
use Illuminate\Support\Facades\DB;

class AuthorObserver
{

    public function deleting(Author $author)
    {
        DB::transaction(function () use ($author) {
            $author->imageRelation()->delete();
            $author->books()->delete();
            $author->followers()->delete();
        });
    }

}
