<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDishesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dishes', function(Blueprint $table)
		{
			$table->binary('id', 16)->primary();
                        $table->timestamps();
			$table->string('name', 45)->nullable();
			$table->text('description', 65535)->nullable();
			$table->integer('status')->nullable();
			$table->float('price', 10, 0)->nullable();
			$table->string('currency', 10)->nullable();
			$table->date('start_date')->nullable();
			$table->date('end_date')->nullable();
			$table->integer('position')->nullable();
			$table->binary('id_establishment', 16)->index('fk_menus_establishments1_idx');
			$table->binary('id_photo', 16)->nullable()->index('fk_dishes_medias1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('dishes');
	}

}
