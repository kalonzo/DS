<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEstablishmentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('establishments', function(Blueprint $table)
		{
			$table->binary('id', 16)->primary();
                        $table->timestamps();
			$table->integer('status')->nullable();
			$table->integer('business_status')->nullable();
			$table->string('name')->nullable();
			$table->string('profile_condition', 45)->nullable();
			$table->string('email')->nullable();
			$table->binary('id_address', 16);
			$table->float('DS_ranking', 10, 0)->nullable();
			$table->binary('id_logo', 16)->nullable()->index('fk_establishments_establishment_medias1_idx');
			$table->float('star', 10, 0)->nullable();
			$table->integer('nb_last_week_visits')->nullable();
			$table->boolean('accept_voucher')->nullable();
			$table->boolean('accept_booking')->nullable();
			$table->string('site_url')->nullable();
			$table->text('description', 65535)->nullable();
			$table->float('average_price_min', 10, 0)->nullable();
			$table->float('average_price_max', 10, 0)->nullable();
			$table->binary('id_banking_info', 16)->nullable();
			$table->binary('id_user_owner', 16)->index('fk_establishments_users1_idx');
			$table->integer('id_business_type')->index('fk_establishments_business_types1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('establishments');
	}

}
