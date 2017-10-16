<?php

use App\Models\Establishment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateEstablishmentThumbnail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE '.Establishment::TABLENAME.' ADD id_thumbnail BINARY(16) NULL;');
        DB::statement('CREATE INDEX fk_ets_thumbnail_idx ON '.Establishment::TABLENAME.' (id_thumbnail);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP INDEX fk_ets_thumbnail_idx ON '.Establishment::TABLENAME.';');
        DB::statement('ALTER TABLE '.Establishment::TABLENAME.' DROP id_thumbnail;');
    }
}
