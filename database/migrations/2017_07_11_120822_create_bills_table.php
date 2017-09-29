<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBillsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bills', function(Blueprint $table)
		{
                    $table->binary('id', 16)->primary();
                    $table->timestamps();
                    $table->integer('status')->nullable();
                    $table->string('title', 20)->nullable();
                    $table->string('lastname')->nullable();
                    $table->string('firstname')->nullable();
                    $table->string('company_name', 45)->nullable();
                    $table->string('pro_phone', 45)->nullable();
                    $table->dateTime('end_date')->nullable();
                    $table->dateTime('start_date')->nullable();
                    $table->string('phone_number', 20)->nullable();
                    $table->string('email', 90)->nullable();
                    $table->binary('id_user', 16)->index('fk_bills_users1_idx');
                    $table->binary('id_cart', 16)->index('fk_bills_carts1_idx');
                    $table->binary('id_contract', 16)->nullable()->index('fk_bills_contracts1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('bills');
	}

}
