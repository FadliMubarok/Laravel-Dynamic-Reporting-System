<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_rules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('report_id')->unsigned();
            $table->integer('rule_id')->unsigned();
            $table->foreign('report_id')->references('id')->on('reports');
            $table->foreign('rule_id')->references('id')->on('rules');
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
        Schema::dropIfExists('report_rules');
    }
}
