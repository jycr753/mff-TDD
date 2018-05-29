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
                $table->timestamp('income_date')->nullable();
                $table->string('income_type', 50)->nullable();
                $table->unsignedInteger('gross_amount')->default(0);
                $table->unsignedInteger('net_amount')->default(0);
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
