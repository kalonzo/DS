<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGeographicalZonesCoordinateBorderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('geographical_zones_coordinate_border', function(Blueprint $table)
		{
			$table->binary('id', 16)->primary();
                        $table->timestamps();
			$table->float('latitude', 10, 0)->nullable();
			$table->float('longitude', 10, 0)->nullable();
			$table->integer('id_geographical_zone')->index('fk_geographical_zones_coordinate_border_geographical_zones1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('geographical_zones_coordinate_border');
	}

}
