<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBookingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bookings', function(Blueprint $table)
		{
			$table->binary('id', 16)->primary();
                        $table->timestamps();
			$table->integer('status')->nullable();
			$table->string('lastname', 45)->nullable();
			$table->string('firstname', 45)->nullable();
			$table->string('email', 45)->nullable();
			$table->string('phone_number', 45)->nullable();
			$table->dateTime('datetime_reservation')->nullable();
			$table->string('comment', 45)->nullable();
			$table->integer('nb_adults')->nullable();
			$table->integer('nb_children')->nullable();
			$table->float('latitude', 10, 0)->nullable();
			$table->float('longitude', 10, 0)->nullable();
			$table->binary('id_user', 16)->index('fk_bookings_users1_idx');
			$table->binary('id_establishment', 16)->index('fk_bookings_establishments1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('bookings');
	}

}
