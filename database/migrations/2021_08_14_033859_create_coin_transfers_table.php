<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoinTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coin_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('user')->nullable($value = true);
            $table->string('c2cUser')->nullable($value = true);
            $table->string('amount')->nullable($value = true);
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
        Schema::dropIfExists('coin_transfers');
    }
}
