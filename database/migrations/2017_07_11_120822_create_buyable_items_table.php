<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBuyableItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('buyable_items', function(Blueprint $table)
		{
			$table->binary('id', 16)->primary();
                        $table->timestamps();
			$table->string('designation')->nullable();
			$table->integer('status')->nullable();
			$table->integer('type')->nullable();
			$table->float('unit_price_HT', 10, 0)->nullable();
			$table->float('unit_price_TTC', 10, 0)->nullable();
			$table->float('vat_rate', 10, 0)->nullable();
			$table->float('price_HT', 10, 0)->nullable();
			$table->float('price_TTC', 10, 0)->nullable();
			$table->float('discount_amount', 10, 0)->nullable();
			$table->float('discount_percent', 10, 0)->nullable();
			$table->float('net_price', 10, 0)->nullable();
			$table->binary('id_object', 16)->nullable();
			$table->integer('type_object')->nullable();
			$table->text('description', 65535)->nullable();
			$table->date('start_date')->nullable();
			$table->date('end_date')->nullable();
			$table->integer('id_business_type')->nullable()->index('fk_buyable_item_business_types1_idx');
			$table->binary('id_geographical_zone', 16)->nullable()->index('fk_buyable_items_geographical_zones1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('buyable_items');
	}

}
