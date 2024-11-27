<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_users', function (Blueprint $table) {
            $table->id();
            $table->string('adminid')->nullable($value=true);
            $table->string('email')->unique();
            $table->string('plainpass')->nullable($value=true);
            $table->string('hashpass')->nullable($value=true);
            $table->string('verifycode')->nullable($value=true);
            $table->string('phone')->nullable($value=true);
            $table->string('company')->nullable($value=true);
            $table->string('rule')->nullable($value=true);
            $table->string('accountBalance')->nullable($value=true);
            $table->string('status')->nullable($value=true);
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
        Schema::dropIfExists('admin_users');
    }
}
