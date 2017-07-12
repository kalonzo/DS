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
			$table->string('title', 20)->nullable();
			$table->string('name')->nullable();
			$table->string('prename')->nullable();
			$table->string('company_name', 45)->nullable();
			$table->string('pro_phone', 45)->nullable();
			$table->date('end_date')->nullable();
			$table->dateTime('start_date')->nullable();
			$table->string('phone_number', 20)->nullable();
			$table->string('email', 90)->nullable();
			$table->integer('id_condition')->nullable();
			$table->integer('id_user')->index('fk_bills_users1_idx');
			$table->integer('id_cart')->index('fk_bills_carts1_idx');
			$table->integer('id_contract')->index('fk_bills_contracts1_idx');
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
