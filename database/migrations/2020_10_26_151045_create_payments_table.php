<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('bill_type_id');
            $table->enum('status', ['paid', 'unpaid'])->default('unpaid');
            $table->dateTime('paid_at')->nullable();
            $table->decimal('amount_received', 10, 2);
            $table->decimal('admin_commission', 8, 2);
            $table->decimal('merchant_commission', 8, 2);
            $table->string('customer_name');
            $table->string('bill_account_number');
            $table->string('invoice');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('bill_type_id')->references('id')->on('bill_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
