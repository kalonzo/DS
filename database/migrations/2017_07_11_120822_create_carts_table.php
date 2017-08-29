<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCartsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('carts', function(Blueprint $table)
		{
			$table->binary('id', 16)->primary();
                        $table->timestamps();
			$table->integer('status')->nullable();
			$table->float('price_HT', 10, 0)->nullable();
			$table->float('price_TTC', 10, 0)->nullable();
			$table->float('vat_amount', 10, 0)->nullable();
			$table->float('discount_amount', 10, 0)->nullable();
			$table->float('discount_percent', 10, 0)->nullable();
			$table->float('shipping_amount', 10, 0)->nullable();
			$table->float('total_price', 10, 0)->nullable();
                        $table->binary('id_user', 16)->index('cart_id_user_idx')->nullable();
                        $table->string('id_session', 255)->index('cart_id_session_idx')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('carts');
	}

}
