<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Faker instance
        $faker = Faker::create();

        // Fetch last inserted id from the DB
        $lastInsetedId = DB::table('books')->max('id');

        // Starting from the last id, we insert 10 new book data in the DB
        for ($i = $lastInsetedId; $i < $lastInsetedId + 10; $i++) {
            DB::table('books')->insert(
                [
                    "id" => $i + 1,
                    "isbn" => $faker->isbn13(),
                    "title" => $faker->sentence(),
                    "author" => $faker->name(),
                    "published_date" => $faker->dateTimeThisDecade('+5 years'),
                    "description" => $faker->paragraph(2),
                    "price" => $faker->randomFloat(2, 10, 200),
                    "created_at" => $faker->date(),
                    "updated_at" => $faker->date(),
                ]
            );
        }
        $this->command->info("Books table filled with default rows");
    }
}
