<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('email', 120)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->tinyInteger('enabled')->default(0);
            $table->timestamp('last_login')->nullable();
            $table->string('password');
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('phone', 64)->nullable();
            $table->string('profile_image')->nullable();
            $table->string('biography', 1000)->nullable();
            $table->enum('gender', ['m','f','o'])->nullable()->comment('m => Male, f => Female, o => Other');
            $table->string('locale', 8)->nullable();
            $table->string('timezone', 64)->nullable();
            $table->rememberToken();
            $table->string('email_token')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('admins');
    }
}
