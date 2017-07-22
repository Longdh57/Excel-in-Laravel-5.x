<?php

use App\Models\Book;
use Illuminate\Database\Seeder;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        foreach(range(1,15) as $index) {
            Book::create([
                'name' => $faker->sentence($nbWords = 6, $variableNbWords = true),
                'author' => $faker->name,
                'description' => $faker->text,
                'quantity' => rand(1, 20),
                'price' => rand(20, 100)*1000,
            ]);
        }
    }
}
