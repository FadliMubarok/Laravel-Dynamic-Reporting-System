<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRuleConditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rule_conditions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rule_id')->unsigned();
            $table->integer('field_id')->unsigned();
            $table->string('type');
            $table->string('value');
            $table->foreign('rule_id')->references('id')->on('rules');
            $table->foreign('field_id')->references('id')->on('fields');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rule_conditions');
    }
}
