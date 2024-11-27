<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminBalanceUsesHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_balance_uses_histories', function (Blueprint $table) {
            $table->id();
            $table->string('adminid')->nullable($value = true);
            $table->string('amount')->nullable($value = true);
            $table->string('trnsId')->nullable($value = true);
            $table->string('trnsType')->nullable($value = true);
            $table->string('userId')->nullable($value = true);
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
        Schema::dropIfExists('admin_balance_uses_histories');
    }
}
