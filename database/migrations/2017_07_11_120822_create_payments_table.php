<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaymentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('payments', function(Blueprint $table)
		{
			$table->binary('id', 16)->primary();
                        $table->timestamps();
			$table->integer('status')->nullable();
			$table->float('amount', 10, 0)->nullable();
			$table->integer('id_user')->index('fk_payments_users1_idx');
			$table->integer('id_payment_method')->index('fk_payments_payment_methods1_idx');
			$table->integer('id_bill')->index('fk_payments_bills1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('payments');
	}

}
