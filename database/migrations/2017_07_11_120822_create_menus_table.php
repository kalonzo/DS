<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMenusTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('menus', function(Blueprint $table)
		{
			$table->binary('id', 16)->primary();
                        $table->timestamps();
			$table->string('name', 45)->nullable();
			$table->integer('status')->nullable();
			$table->boolean('is_daily_menu')->nullable();
			$table->date('start_date')->nullable();
			$table->date('end_date')->nullable();
			$table->integer('position')->nullable();
			$table->integer('id_establishment')->index('fk_menus_establishments1_idx');
			$table->integer('id_file')->index('fk_menus_medias1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('menus');
	}

}
