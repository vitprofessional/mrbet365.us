<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClubStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('club_statements', function (Blueprint $table) {
            $table->id();
            $table->string('club')->nullable($value = true);
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
        Schema::dropIfExists('club_statements');
    }
}
