<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCallNumbersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('call_numbers', function(Blueprint $table)
		{
			$table->binary('id', 16)->primary();
                        $table->timestamps();
			$table->string('label')->nullable();
			$table->integer('type')->nullable();
			$table->boolean('main')->nullable();
			$table->integer('id_country')->index('fk_call_numbers_country_idx');
			$table->integer('prefix')->nullable();
			$table->string('number', 20)->nullable();
                        $table->binary('id_object_related', 16)->nullable()->index('fk_object_related_idx');
                        $table->integer('type_object_related')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('call_numbers');
	}

}
