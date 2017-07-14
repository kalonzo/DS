<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLinkCvComputingSkillTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('link_cv_computing_skill', function(Blueprint $table)
		{
			$table->binary('id', 16)->primary();
                        $table->timestamps();
			$table->binary('id_computing_skill', 16)->index('fk_computing_skills_has_cv_computing_skills1_idx');
			$table->binary('id_cv', 16)->index('fk_computing_skills_has_cv_cv1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('link_cv_computing_skill');
	}

}
