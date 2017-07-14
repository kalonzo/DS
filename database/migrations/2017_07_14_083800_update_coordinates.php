<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateCoordinates extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::table('establishments', function(Blueprint $table)
            {
                    $table->float('latitude', 20, 0)->nullable();
                    $table->float('longitude', 20, 0)->nullable();
            });
            Schema::table('address', function($table)
            {
                $table->float('latitude', 20, 0)->nullable()->change();
                $table->float('longitude', 20, 0)->nullable()->change();
            });
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
            Schema::table('establishments', function(Blueprint $table)
            {
                    $table->dropColumn('latitude');
                    $table->dropColumn('longitude');
            });
            Schema::table('address', function($table)
            {
                $table->float('latitude', 10, 0)->nullable()->change();
                $table->float('longitude', 10, 0)->nullable()->change();
            });
	}

}
