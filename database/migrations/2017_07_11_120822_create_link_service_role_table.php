<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLinkServiceRoleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('link_service_role', function(Blueprint $table)
		{
			$table->binary('id', 16)->primary();
                        $table->timestamps();
			$table->integer('id_role')->index('fk_role_has_services_role1_idx');
			$table->integer('id_service')->nullable()->index('fk_role_has_services_services1_idx');
			$table->integer('id_user')->nullable()->index('fk_link_service_role_users1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('link_service_role');
	}

}
