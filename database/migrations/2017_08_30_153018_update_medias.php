<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMedias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(\App\Models\EstablishmentMedia::TABLENAME, function($table)
        {
            $table->integer('status')->nullable();
        });
        Schema::table(\App\Models\CvMedia::TABLENAME, function($table)
        {
            $table->integer('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(\App\Models\EstablishmentMedia::TABLENAME, function($table)
        {
            $table->dropColumn('status');
        });
        Schema::table(\App\Models\CvMedia::TABLENAME, function($table)
        {
            $table->dropColumn('status');
        });
    }
}
