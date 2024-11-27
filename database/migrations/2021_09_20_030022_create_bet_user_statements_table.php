<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBetUserStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bet_user_statements', function (Blueprint $table) {
            $table->id();
            $table->string('user')->nullable($value = true);
            $table->string('prevBalance')->default = 0;
            $table->string('transAmount')->default = 0;
            $table->string('currentBalance')->default = 0;
            $table->string('note')->nullable($value = true);
            $table->string('transType')->nullable($value = true);
            $table->string('status')->nullable($value = true);
            $table->string('generateBy')->nullable($value = true);
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
        Schema::dropIfExists('bet_user_statements');
    }
}
