<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEtsMedia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE '.\App\Models\EstablishmentMedia::TABLENAME.' ADD id_establishment BINARY(16) NULL;');
        DB::statement('CREATE INDEX fk_media_ets_idx ON '.\App\Models\EstablishmentMedia::TABLENAME.' (id_establishment);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP INDEX fk_media_ets_idx ON '.\App\Models\EstablishmentMedia::TABLENAME.';');
        DB::statement('ALTER TABLE '.\App\Models\EstablishmentMedia::TABLENAME.' DROP id_establishment;');
    }
}
