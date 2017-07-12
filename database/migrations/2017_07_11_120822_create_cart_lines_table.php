<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCartLinesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cart_lines', function(Blueprint $table)
		{
			$table->binary('id', 16)->primary();
                        $table->timestamps();
			$table->string('designation')->nullable();
			$table->integer('qty')->nullable();
			$table->float('unit_price_HT', 10, 0)->nullable();
			$table->float('unit_price_TTC', 10, 0)->nullable();
			$table->float('vat_rate', 10, 0)->nullable();
			$table->float('price_HT', 10, 0)->nullable();
			$table->float('price_TTC', 10, 0)->nullable();
			$table->float('discount_amount', 10, 0)->nullable();
			$table->float('discount_percent', 10, 0)->nullable();
			$table->float('net_price', 10, 0)->nullable();
			$table->integer('id_cart')->index('fk_cart_lines_carts1_idx');
			$table->integer('id_buyable_item')->index('fk_cart_lines_buyable_item1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cart_lines');
	}

}
