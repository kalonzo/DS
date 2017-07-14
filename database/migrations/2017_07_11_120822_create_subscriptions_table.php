<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubscriptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('subscriptions', function(Blueprint $table)
		{
			$table->binary('id', 16)->primary();
                        $table->timestamps();
			$table->float('priceTTC', 10, 0)->nullable();
			$table->date('start_date')->nullable();
			$table->date('end_date')->nullable();
			$table->date('close_date')->nullable();
			$table->binary('id_establishment', 16)->index('fk_subscription_establishments1_idx');
			$table->binary('id_user', 16)->index('fk_subscription_users1_idx');
			$table->binary('id_bill', 16)->index('fk_subscriptions_bills1_idx');
			$table->binary('id_buyable_item', 16)->index('fk_subscriptions_buyable_item1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('subscriptions');
	}

}
