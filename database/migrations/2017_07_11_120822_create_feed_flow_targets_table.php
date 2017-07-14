<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFeedFlowTargetsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('feed_flow_targets', function(Blueprint $table)
		{
			$table->binary('id', 16)->primary();
                        $table->timestamps();
			$table->binary('id_feed_flow', 16)->index('fk_feed_flow_targets_feed_flows1_idx');
			$table->binary('id_user', 16)->nullable()->index('fk_feed_flow_targets_users1_idx');
			$table->binary('id_service', 16)->nullable()->index('fk_feed_flow_targets_services1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('feed_flow_targets');
	}

}
