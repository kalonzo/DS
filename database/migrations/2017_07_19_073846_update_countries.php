<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCountries extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('countries', function(Blueprint $table) {
            $table->string('iso3', 3)->nullable();
            $table->integer('prefix')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('countries', function(Blueprint $table) {
            $table->dropColumn('iso3');
            $table->dropColumn('prefix');
        });
    }

}
