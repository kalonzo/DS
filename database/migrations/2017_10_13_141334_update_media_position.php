<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMediaPosition extends Migration
{
    /**
     * Run the migrations.
     * Sets current Null in establishment_medias position to 0
     * sets position to NOT NULL
     * Creates Trigger to look at incoming inserts with Null positions and set them to last
     *  
     * @return void
     */
    public function up() { /* SQL version, in case of issues
     */
        DB::table('establishment_medias')
                ->whereNull('position')
                ->update(['position' => 0]);
        
        DB::unprepared('ALTER TABLE `establishment_medias` CHANGE `position` `position` INT(11) NOT NULL;');
        
        DB::unprepared('
            USE `dinerscope`;
            DELIMITER $$
            DROP TRIGGER IF EXISTS dinerscope.maxIncrement$$
            USE `dinerscope`$$
            CREATE TRIGGER maxIncrement BEFORE INSERT ON establishment_medias 
            FOR EACH ROW 
            BEGIN
                IF NEW.position IS NULL THEN 
                SET NEW.position = 1+(SELECT MAX(position) FROM establishment_medias); 
                END IF;
            END$$
            DELIMITER ;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {

        //removes new null contrain
        Schema::table('establishment_medias', function($table) {
            $table->integer('position', 11)->nullable()->change();
        });
        //Drops the trigger
        DB::unprepared('
                USE `dinerscope`;
                DROP TRIGGER IF EXISTS dinerscope.maxIncrement;
            ');
    }

}
