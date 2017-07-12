<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContractsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contracts', function(Blueprint $table)
		{
			$table->binary('id', 16)->primary();
                        $table->timestamps();
			$table->string('number', 100)->nullable();
			$table->dateTime('start_date')->nullable();
			$table->dateTime('end_date')->nullable();
			$table->integer('id_user_in_charge')->index('fk_contracts_users1_idx');
			$table->integer('id_establishment_customer')->index('fk_contracts_establishments1_idx');
			$table->integer('id_user_customer')->index('fk_contracts_users2_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contracts');
	}

}
