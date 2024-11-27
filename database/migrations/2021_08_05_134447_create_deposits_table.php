<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->string('user')->nullable($value = true);
            $table->string('method')->nullable($value = true);
            $table->string('amount')->nullable($value = true);
            $table->string('fromNumber')->nullable($value = true);
            $table->string('toNumber')->nullable($value = true);
            $table->string('skrillid')->nullable($value = true);
            $table->string('paypalid')->nullable($value = true);
            $table->string('rejectreson')->nullable($value = true);
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
        Schema::dropIfExists('deposits');
    }
}
