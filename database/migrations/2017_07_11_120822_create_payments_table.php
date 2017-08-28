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
			$table->binary('id_user', 16)->index('fk_payments_users1_idx');
			$table->binary('id_payment_method', 16)->index('fk_payments_payment_methods1_idx');
			$table->binary('id_bill', 16)->index('fk_payments_bills1_idx')->nullable();
                        $table->binary('id_cart', 16)->index('fk_payment_id_cart_idx');
                        $table->integer('id_currency')->index('fk_payment_id_currency_idx');
                        $table->integer('id_transaction')->index('payment_id_transaction_idx')->nullable();
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
