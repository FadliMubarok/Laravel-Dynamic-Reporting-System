<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class WebsitesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach (range(1,1000) as $index) {
            DB::table('websites')->insert([
                'name' => $faker->domainWord,
                'domain' => $faker->domainName,
                'created_at' => $faker->dateTimeThisDecade()
            ]);
        }
    }
}
