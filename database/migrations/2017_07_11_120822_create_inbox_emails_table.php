<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInboxEmailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('inbox_emails', function(Blueprint $table)
		{
			$table->binary('id', 16)->primary();
                        $table->timestamps();
			$table->integer('status')->nullable();
			$table->string('subject')->nullable();
			$table->text('content', 65535)->nullable();
			$table->binary('conversation_identifier', 16)->nullable();
			$table->integer('id_user_sender')->index('fk_inbox_email_users1_idx');
			$table->integer('id_user_recipient')->index('fk_inbox_email_users2_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('inbox_emails');
	}

}
