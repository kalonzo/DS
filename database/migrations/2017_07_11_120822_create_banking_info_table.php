<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBankingInfoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('banking_info', function(Blueprint $table)
		{
			$table->binary('id', 16)->primary();
                        $table->timestamps();
			$table->string('label')->nullable();
			$table->string('iban', 45)->nullable();
			$table->string('bic', 45)->nullable();
			$table->string('swift', 45)->nullable();
			$table->string('bank_name', 45)->nullable();
			$table->integer('id_address_bank')->nullable();
			$table->string('account_owner_lastname', 75)->nullable();
			$table->string('account_owner_firstname', 45)->nullable();
			$table->integer('id_establishment')->index('fk_banking_info_establishments1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('banking_info');
	}

}
