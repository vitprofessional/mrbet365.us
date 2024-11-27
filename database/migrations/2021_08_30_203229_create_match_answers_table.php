<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('match_answers', function (Blueprint $table) {
            $table->id();
            $table->string('quesId')->nullable($value = true);
            $table->string('answer')->nullable($value = true);
            $table->string('returnValue')->nullable($value = true);
            //$table->string('matchId')->nullable($value = true);
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
        Schema::dropIfExists('match_answers');
    }
}
