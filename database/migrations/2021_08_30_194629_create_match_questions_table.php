<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('match_questions', function (Blueprint $table) {
            $table->id();
            $table->string('catId')->nullable($value = true);
            $table->string('tournament')->nullable($value = true);
            $table->string('matchId')->nullable($value = true);
            $table->string('quesId')->nullable($value = true);
            $table->string('status')->nullable($value = true);
            //$table->string('')->nullable($value = true);
            //$table->string('')->nullable($value = true);
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
        Schema::dropIfExists('match_questions');
    }
}
