<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMedia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(\App\Models\EstablishmentMedia::TABLENAME, function(Blueprint $table) {
            $table->integer('type_use')->index('media_type_use_idx');
        });
        Schema::table(\App\Models\CvMedia::TABLENAME, function(Blueprint $table) {
            $table->integer('type_use')->index('media_type_use_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(\App\Models\EstablishmentMedia::TABLENAME, function(Blueprint $table) {
            $table->dropColumn('type_use');
        });
        Schema::table(\App\Models\CvMedia::TABLENAME, function(Blueprint $table) {
            $table->dropColumn('type_use');
        });
    }
}
