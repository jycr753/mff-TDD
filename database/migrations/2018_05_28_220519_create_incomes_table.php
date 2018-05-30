<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'incomes',
            function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('user_id')->references('id')->on('users');
                $table->unsignedInteger('category_id')->references('id')->on('categories');
                $table->timestamp('income_date')->nullable();
                $table->unsignedInteger('gross_amount')->default(0);
                $table->unsignedInteger('net_amount')->default(0);
                $table->text('description')->nullable();
                $table->timestamps();
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
        Schema::dropIfExists('incomes');
    }
}
