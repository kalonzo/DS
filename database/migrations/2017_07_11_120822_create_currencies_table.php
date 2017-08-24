<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCurrenciesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('currencies', function(Blueprint $table)
		{
                        $table->integer('id')->primary();
                        $table->timestamps();
			$table->string('symbol', 5)->nullable();
			$table->string('short_label', 5)->nullable();
			$table->string('label', 100)->nullable();
			$table->float('rate', 10, 0)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('currencies');
	}

}
