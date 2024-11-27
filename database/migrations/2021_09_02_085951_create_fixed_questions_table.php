<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFixedQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixed_questions', function (Blueprint $table) {
            $table->id();
            $table->string('catId')->nullable($value = true);
            $table->string('tournament')->nullable($value = true);
            $table->string('matchId')->nullable($value = true);
            $table->string('quesId')->nullable($value = true);
            $table->string('status')->nullable($value = true);
            $table->string('teamA')->nullable($value = true);
            $table->string('teamB')->nullable($value = true);
            $table->string('draw')->nullable($value = true);
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
        Schema::dropIfExists('fixed_questions');
    }
}
