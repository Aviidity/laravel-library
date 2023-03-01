<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        // An array filled with ALL the books IDs fetched from the DB
        $bookIds = DB::table('books')->pluck('id')->toArray();

        // For every book from the array, we generate a random amount of categories it will have
        foreach ($bookIds as $bookId) {

            $randomCategoriesAmount = rand(1, 3);
            
            // An array filled with SOME categories IDs based on the amount generated
            // The inRandomOrder() method is used to order the results of the query randomly
            $categoryIds = DB::table('categories')->inRandomOrder()->limit($randomCategoriesAmount)->pluck('id')->toArray();

            foreach ($categoryIds as $categoryId) {

                DB::table('book_category')->insert(
                    [
                        'book_id' => $bookId,
                        'category_id' => $categoryId,
                    ]
                );
            }
        }
    }
}
