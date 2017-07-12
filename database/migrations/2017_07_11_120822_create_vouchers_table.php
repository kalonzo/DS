<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVouchersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('vouchers', function(Blueprint $table)
		{
			$table->binary('id', 16)->primary();
                        $table->timestamps();
			$table->integer('status')->nullable();
			$table->float('priceTTC', 10, 0)->nullable();
			$table->date('end_date')->nullable();
			$table->integer('id_establishment')->index('fk_vouchers_establishments1_idx');
			$table->integer('id_buyable_item')->index('fk_vouchers_buyable_items1_idx');
			$table->integer('id_bill')->index('fk_vouchers_bills1_idx');
			$table->integer('id_user')->index('fk_vouchers_users1_idx');
			$table->integer('id_currency')->index('fk_vouchers_currencies1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('vouchers');
	}

}
