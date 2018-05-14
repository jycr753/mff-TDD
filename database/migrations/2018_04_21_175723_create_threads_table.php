<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThreadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'threads',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('slug')->unique()->nullable();
                $table->unsignedInteger('user_id');
                $table->unsignedInteger('channel_id');
                $table->unsignedInteger('replies_count')->default(0);
                $table->unsignedInteger('visits')->default(0);
                $table->string('title');
                $table->text('body');
                $table->unsignedInteger('best_reply_id')->nullable();
                $table->timestamps();

                // This is another way to delete with refercning a foreign relations
                // We will not do this, we have to change the migration sequence 
                // and make sure replies table is created
                // $table->foreign('best_reply_id')
                //     ->references('id')
                //     ->on('replies')
                //     ->onDelete('set null');

            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('threads');
    }
}
