<?php

use Illuminate\Database\Seeder;

class FieldsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fields')->insert([
            'model' => 'website',
            'name' => 'name',
            'label' => 'Name',
            'type' => 'text'
        ]);
        DB::table('fields')->insert([
            'model' => 'website',
            'name' => 'domain',
            'label' => 'Domain',
            'type' => 'text'
        ]);
        DB::table('fields')->insert([
            'model' => 'website',
            'name' => 'created_at',
            'label' => 'Created at',
            'type' => 'date'
        ]);
        DB::table('fields')->insert([
            'model' => 'website',
            'name' => 'updated_at',
            'label' => 'Updated at',
            'type' => 'date'
        ]);
    }
}
