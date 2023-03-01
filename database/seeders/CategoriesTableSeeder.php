<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Faker instance
        $faker = Faker::create();

        // Fetch last inserted id from the DB
        $lastInsertedId = DB::table('categories')->max('id');

        // Starting from the last id, we insert 10 new categories data in the DB
        for($i = $lastInsertedId; $i < $lastInsertedId + 10; $i++){
            DB::table('categories')->insert(
                [
                    "id" => $i + 1,
                    "name" => $faker->name(),
                    "created_at" => $faker->date(),
                    "updated_at" => $faker->date()
                ]
            );
        }
    }
}
