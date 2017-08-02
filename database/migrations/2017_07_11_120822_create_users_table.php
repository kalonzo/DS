<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->binary('id', 16)->primary();
                        $table->timestamps();
			$table->integer('status')->nullable();
			$table->integer('type')->nullable();
			$table->boolean('gender')->nullable();
                        $table->string('name');
			$table->string('lastname', 45)->nullable();
			$table->string('firstname', 45)->nullable();
			$table->string('email', 45)->nullable()->unique();
			$table->string('password')->nullable();
                        $table->rememberToken();
			$table->boolean('is_connected')->nullable();
			$table->binary('id_address', 16)->nullable();
			$table->binary('id_inbox', 16)->nullable();
			$table->float('longitude', 10, 0)->nullable();
			$table->float('latitude', 10, 0)->nullable();
			$table->binary('id_photo', 16)->nullable();
			$table->binary('id_company', 16)->nullable()->index('fk_users_company1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
