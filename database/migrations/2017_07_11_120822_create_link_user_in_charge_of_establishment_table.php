<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLinkUserInChargeOfEstablishmentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('link_user_in_charge_of_establishment', function(Blueprint $table)
		{
			$table->binary('id', 16)->primary();
                        $table->timestamps();
			$table->binary('id_user', 16)->index('fk_users_has_establishments_users1_idx');
			$table->binary('id_establishment', 16)->index('fk_users_has_establishments_establishments1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('link_user_in_charge_of_establishment');
	}

}
