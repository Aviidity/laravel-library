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
        $faker = Faker::create('en_US');

        // Fetch last inserted id from the DB
        $lastInsetedId = DB::table('books')->max('id');

        // Starting from the last id, we insert 10 new book data in the DB
        for ($i = $lastInsetedId; $i < $lastInsetedId + 10; $i++) {

            $imageName = $faker->image('public/images' ,300,500);
            $imagePath = str_replace('public/','',$imageName);

            DB::table('books')->insert(
                [
                    "id" => $i + 1,
                    "title" => $faker->text(20),
                    "author" => $faker->name(),
                    "published_date" => $faker->dateTimeThisDecade('+5 years'),
                    "description" => $faker->paragraph(2),
                    "picture" => $imagePath,
                    "price" => $faker->randomFloat(2, 10, 200),
                    "created_at" => $faker->date(),
                    "updated_at" => $faker->date(),
                ]
            );
        }
        $this->command->info("Books table filled with default rows");
    }
}
