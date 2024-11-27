<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserBetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_bets', function (Blueprint $table) {
            $table->id();
            $table->string('user')->nullable($value = true);
            $table->string('betOption')->nullable($value = true);
            $table->string('betAnswer')->nullable($value = true);
            $table->string('betOn')->nullable($value = true);
            $table->string('betAmount')->nullable($value = true);
            $table->string('betRate')->nullable($value = true);
            $table->string('winAnswer')->nullable($value = true);
            $table->string('club')->nullable($value = true);
            $table->string('userProfit')->nullable($value = true);
            $table->string('siteProfit')->nullable($value = true);
            $table->string('partialAmount')->nullable($value = true);
            $table->string('partialRate')->nullable($value = true);
            $table->string('status')->nullable($value = true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_bets');
    }
}
