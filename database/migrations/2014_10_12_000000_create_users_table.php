<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('password');
            $table->string('plan_package')->nullable();
            $table->integer('count')->default(0);
            $table->integer('achievements')->default(0)->nullable();
            $table->enum('user_type',['free_user','premium_user'])->default('free_user')->comment("free_user|premium_user");
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
            
        });
    }
    
    // $table->enum('badge_1', ['none', 'pass','achieved'])->default('none')->comment("none|pass|achieved");
    // $table->enum('badge_2', ['none', 'pass','achieved'])->default('none')->comment("none|pass|achieved");
    // $table->enum('badge_3', ['none', 'pass','achieved'])->default('none')->comment("none|pass|achieved");
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
