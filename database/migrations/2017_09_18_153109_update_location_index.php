<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateLocationIndex extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table(\App\Models\LocationIndex::TABLENAME, function(Blueprint $table) {
            $table->string('district', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table(\App\Models\LocationIndex::TABLENAME, function(Blueprint $table) {
            $table->dropColumn('district');
        });
    }

}
