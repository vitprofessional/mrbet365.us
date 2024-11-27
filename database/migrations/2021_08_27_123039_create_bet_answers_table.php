<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBetAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bet_answers', function (Blueprint $table) {
            $table->id();
            $table->string('catId')->nullable($value = true);
            $table->string('optId')->nullable($value = true);
            $table->string('optType')->nullable($value = true);
            $table->string('optVal')->nullable($value = true);
            $table->string('returnVal')->nullable($value = true);
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
        Schema::dropIfExists('bet_answers');
    }
}
