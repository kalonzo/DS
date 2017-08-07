<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEstablishmentMediasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('establishment_medias', function(Blueprint $table)
		{
			$table->binary('id', 16)->primary();
                        $table->timestamps();
			$table->integer('type')->nullable();
			$table->string('filename')->nullable();
			$table->string('extension', 5)->nullable();
			$table->float('size', 10, 0)->nullable();
			$table->integer('width')->nullable();
			$table->integer('height')->nullable();
			$table->string('local_path')->nullable();
			$table->integer('position')->nullable();
			$table->binary('id_gallery', 16)->nullable()->index('fk_medias_galleries1_idx');
			$table->binary('id_draft_media', 16)->nullable()->index('fk_establishment_medias_establishment_medias1_idx');
                        $table->binary('id_object_related', 16)->index('fk_establishment_medias_object_related_idx');
                        $table->boolean('public')->nullable();
                        $table->string('drive',255)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('establishment_medias');
	}

}
