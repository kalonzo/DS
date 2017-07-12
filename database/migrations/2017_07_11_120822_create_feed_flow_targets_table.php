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
			$table->integer('id_feed_flow')->index('fk_feed_flow_targets_feed_flows1_idx');
			$table->integer('id_user')->nullable()->index('fk_feed_flow_targets_users1_idx');
			$table->integer('id_service')->nullable()->index('fk_feed_flow_targets_services1_idx');
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
