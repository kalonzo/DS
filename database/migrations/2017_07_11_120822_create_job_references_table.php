<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateJobReferencesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('job_references', function(Blueprint $table)
		{
			$table->binary('id', 16)->primary();
                        $table->timestamps();
			$table->string('lastname')->nullable();
			$table->string('firstname')->nullable();
			$table->string('company')->nullable();
			$table->string('phone_prefix', 5)->nullable();
			$table->string('phone_number', 20)->nullable();
			$table->integer('position')->nullable();
			$table->binary('id_cv', 16)->index('fk_job_references_cv1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('job_references');
	}

}
