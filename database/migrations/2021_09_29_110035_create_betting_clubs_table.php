<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBettingClubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('betting_clubs', function (Blueprint $table) {
            $table->id();
            $table->string('fullname')->nullable($value = true);
            $table->string('email')->unique();
            $table->string('clubid')->nullable($value = true);
            $table->string('plainpassword')->nullable($value = true);
            $table->string('hashpassword')->nullable($value = true);
            $table->string('phone')->nullable($value = true);
            $table->string('country')->nullable($value = true);
            $table->string('verifycode')->nullable($value = true);
            $table->string('balance')->default(0);
            $table->string('status')->default(5);
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
        Schema::dropIfExists('betting_clubs');
    }
}
