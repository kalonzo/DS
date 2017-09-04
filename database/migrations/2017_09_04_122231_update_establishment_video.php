<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEstablishmentVideo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE '.\App\Models\Establishment::TABLENAME.' ADD id_video BINARY(16) NULL;');
        DB::statement('CREATE INDEX fk_establishment_video_idx ON '.\App\Models\Establishment::TABLENAME.' (id_video);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP INDEX fk_establishment_video_idx ON '.\App\Models\Establishment::TABLENAME.';');
        DB::statement('ALTER TABLE '.\App\Models\Establishment::TABLENAME.' DROP id_video;');
    }
}
