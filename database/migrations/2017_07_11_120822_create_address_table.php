<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAddressTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('address', function(Blueprint $table)
		{
                    $table->binary('id', 16)->primary();
                    $table->timestamps();
                    $table->string('street_number', 45)->nullable();
                    $table->string('street')->nullable();
                    $table->string('address_additional')->nullable();
                    $table->string('po_box')->nullable();
                    $table->integer('postal_code')->nullable();
                    $table->string('city')->nullable();
                    $table->integer('id_country')->nullable()->index('fk_address_country_idx');
                    $table->float('latitude', 10, 0)->nullable();
                    $table->float('longitude', 10, 0)->nullable();
                    $table->string('label')->nullable();
                    $table->string('firstname')->nullable();
                    $table->string('lastname')->nullable();
                    $table->binary('id_location_index', 16)->index('fk_address_cities1_idx');
                    $table->binary('id_object_related', 16)->nullable();
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
		Schema::drop('address');
	}

}
