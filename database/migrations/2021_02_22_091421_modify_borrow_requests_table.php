<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyBorrowRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('borrow_requests', function(Blueprint $table) {
            $table->smallInteger('status')->default(-1)->change();
            $table->timestamp('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('borrow_requests', function(Blueprint $table) {
            $table->boolean('status')->nullable()->change();
            $table->dropColumn('updated_at');
        });
    }
}
