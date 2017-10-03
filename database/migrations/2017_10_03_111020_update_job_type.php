<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateJobType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('job_types');
        Schema::create('job_types', function(Blueprint $table)
        {
                $table->integer('id')->primary();
                $table->timestamps();
                $table->string('name')->nullable();
                $table->integer('id_business_type')->index('fk_job_types_business_types1_idx');
        });
        SchemaExtended\Schema::table(\App\Models\Employee::TABLENAME, function(Blueprint $table) {
            $table->dropColumn('id_job_type');
        });        
        SchemaExtended\Schema::table(\App\Models\Employee::TABLENAME, function(Blueprint $table) {
            $table->integer('id_job_type')->nullable()->index('fk_employees_job1_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
