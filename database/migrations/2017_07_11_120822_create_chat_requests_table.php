<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChatRequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('chat_requests', function(Blueprint $table)
		{
			$table->binary('id', 16)->primary();
                        $table->timestamps();
			$table->text('message', 65535)->nullable();
			$table->integer('status')->nullable();
			$table->binary('id_user_sender', 16)->index('fk_chat_requests_users1_idx');
			$table->binary('id_service_target', 16)->nullable()->index('fk_chat_requests_services1_idx');
			$table->binary('id_user_target', 16)->nullable()->index('fk_chat_requests_users2_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('chat_requests');
	}

}
