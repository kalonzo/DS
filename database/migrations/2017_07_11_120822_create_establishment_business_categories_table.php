<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEstablishmentBusinessCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('establishment_business_categories', function(Blueprint $table)
		{
			$table->binary('id', 16);
			$table->binary('id_establishment', 16)->index('fk_establishments_has_establishment_attribute_categories_es_idx1');
			$table->binary('id_business_category', 16)->index('fk_establishments_has_establishment_attribute_categories_es_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('establishment_business_categories');
	}

}
