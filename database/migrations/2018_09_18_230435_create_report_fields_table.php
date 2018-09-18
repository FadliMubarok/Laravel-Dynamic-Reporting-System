<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('report_id')->unsigned();
            $table->integer('field_id')->unsigned();
            $table->foreign('report_id')->references('id')->on('reports');
            $table->foreign('field_id')->references('id')->on('fields');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_fields');
    }
}
