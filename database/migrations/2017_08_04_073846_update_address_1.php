<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddress1 extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('address', function(Blueprint $table) {
            $table->string('department', 255)->nullable();
            $table->string('region',255)->nullable();
            $table->string('district',255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('address', function(Blueprint $table) {
            $table->dropColumn('department');
            $table->dropColumn('region');
            $table->dropColumn('district');
        });
    }

}
