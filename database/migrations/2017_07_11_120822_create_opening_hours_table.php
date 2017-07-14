<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOpeningHoursTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('opening_hours', function(Blueprint $table)
		{
			$table->binary('id', 16)->primary();
                        $table->timestamps();
			$table->integer('day')->nullable();
			$table->time('start_time')->nullable();
			$table->time('end_time')->nullable();
			$table->date('start_date')->nullable();
			$table->date('end_date')->nullable();
			$table->binary('id_establishment', 16)->index('fk_opening_hours_establishments1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('opening_hours');
	}

}
