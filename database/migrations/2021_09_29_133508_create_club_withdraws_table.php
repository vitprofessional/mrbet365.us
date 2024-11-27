<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClubWithdrawsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('club_withdraws', function (Blueprint $table) {
            $table->id();
            $table->string('club')->nullable($value = true);
            $table->string('paymentType')->nullable($value = true);
            $table->string('amount')->nullable($value = true);
            $table->string('toNumber')->nullable($value = true);
            $table->string('rejectreson')->nullable($value = true);
            $table->string('trans_id')->nullable($value = true);
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
        Schema::dropIfExists('club_withdraws');
    }
}
