<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBorrowRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('borrow_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('book_id')->constrained();
            $table->date('from');
            $table->date('to');
            $table->string('note')->nullable();
            $table->boolean('status')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamp('returned_at')->nullable();
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('borrow_requests');
    }
}
