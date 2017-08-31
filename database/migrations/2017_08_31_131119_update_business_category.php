<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateBusinessCategory extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table(\App\Models\BusinessCategory::TABLENAME, function($table) {
            $table->integer('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
    Schema::table(\App\Models\BusinessCategory::TABLENAME, function(Blueprint $table) {
            $table->dropColumn('status');
        });
    }

}
