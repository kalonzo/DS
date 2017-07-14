<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmployeesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('employees', function(Blueprint $table)
		{
			$table->binary('id', 16)->primary();
                        $table->timestamps();
			$table->string('lastname', 45)->nullable();
			$table->string('firstname', 45)->nullable();
			$table->integer('status')->nullable();
			$table->binary('id_photo', 16)->nullable();
			$table->string('position', 45)->nullable();
			$table->binary('id_establishment', 16)->index('fk_employees_establishments1_idx');
			$table->binary('id_job_type', 16)->nullable()->index('fk_employees_job1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('employees');
	}

}
