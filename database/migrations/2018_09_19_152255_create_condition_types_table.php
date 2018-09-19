<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;

class CreateConditionTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('condition_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('label');
            $table->json('available_in');
            $table->timestamps();
        });
        DB::table('condition_types')->insert([
            'name' => 'equals',
            'label' => 'Equals',
            'available_in' => json_encode(['text', 'number']),
            'created_at' => Carbon::now()
        ]);
        DB::table('condition_types')->insert([
            'name' => 'contains',
            'label' => 'Contains',
            'available_in' => json_encode(['text']),
            'created_at' => Carbon::now()
        ]);
        DB::table('condition_types')->insert([
            'name' => 'starts_with',
            'label' => 'Starts with',
            'available_in' => json_encode(['text']),
            'created_at' => Carbon::now()
        ]);
        DB::table('condition_types')->insert([
            'name' => 'ends_with',
            'label' => 'Ends with',
            'available_in' => json_encode(['text']),
            'created_at' => Carbon::now()
        ]);
        DB::table('condition_types')->insert([
            'name' => 'less_then',
            'label' => 'Less then',
            'available_in' => json_encode(['number', 'date']),
            'created_at' => Carbon::now()
        ]);
        DB::table('condition_types')->insert([
            'name' => 'less_then_or_equal',
            'label' => 'Less then or equal to',
            'available_in' => json_encode(['number', 'date']),
            'created_at' => Carbon::now()
        ]);
        DB::table('condition_types')->insert([
            'name' => 'greater_then',
            'label' => 'Greater then',
            'available_in' => json_encode(['number', 'date']),
            'created_at' => Carbon::now()
        ]);
        DB::table('condition_types')->insert([
            'name' => 'greater_then_or_equal',
            'label' => 'Greater then or equal to',
            'available_in' => json_encode(['number', 'date']),
            'created_at' => Carbon::now()
        ]);
        DB::table('condition_types')->insert([
            'name' => 'year_equal',
            'label' => 'Year equal to',
            'available_in' => json_encode(['date']),
            'created_at' => Carbon::now()
        ]);
        DB::table('condition_types')->insert([
            'name' => 'month_equal',
            'label' => 'Month equal to',
            'available_in' => json_encode(['date']),
            'created_at' => Carbon::now()
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('condition_types');
    }
}
