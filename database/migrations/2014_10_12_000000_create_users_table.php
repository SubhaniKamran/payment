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
            $table->enum('role',['admin','merchant'])->default('merchant');
            $table->enum('status', ['unverified', 'verified'])->default('unverified');
            $table->string('firstname');
            $table->string('lastname')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->decimal('credit_limit', 10, 2)->nullable();
            $table->decimal('credit_balance', 10, 2)->nullable();
            $table->string('stripe_customer_id')->nullable();
            $table->string('stripe_card_id')->nullable();
            $table->string('card_number')->nullable();
            $table->string('card_exp_month')->nullable();
            $table->string('card_cvc')->nullable();
            $table->string('card_exp_year')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

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
