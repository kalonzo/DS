<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDefaultAutoincrementPosition extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
       DB::unprepared('
           USE `dinerscope`;
           UPDATE `establishment_medias` SET position = 0 WHERE position IS NULL;
       ');
       
       //add binary value to ID, not NULL AUTO_INCREMENT
       DB::unprepared('ALTER TABLE `establishment_medias` CHANGE `position` `position` INT(11) NOT NULL;');
       
       //Pseudo autoincrement, since not on primary index.
       //If the inserted position is NULL, Trigger finds the MAX position currently in DB and sets the
       //position to the the max position + 1
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
    public function down()
    {
        //removes new null contrain
        DB::unprepared('ALTER TABLE `establishment_medias` CHANGE `position` `position` INT(11) NULL;');
        //Drops the trigger
        DB::unprepared('
                USE `dinerscope`;
                DROP TRIGGER IF EXISTS dinerscope.maxIncrement;
            ');
    }
}
