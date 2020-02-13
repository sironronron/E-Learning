<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

use Faker\Provider\Youtube;

class CourseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $faker->addProvider(new Youtube($faker));

        for ($i = 0; $i < 100; $i++) {
            App\Models\Course\Course::create([
                'teacher_id' => 6,
                'title' => $faker->sentence(2),
                'slug' => str_slug($faker->sentence(2), '-'),
                'excerpt' => $faker->sentence(25),
                'description' => $faker->realText(1300),
                'category_id' => $faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]),
                'status' => 'PENDING',
                'approved' => 0,
                'language' => 'English',
                'level' => $faker->randomElement(['BEGINNER', 'ADVANCE', 'INTERMEDIATE']),
                'top_course' => 0,
                'free_course' => 1,
                'price' => null,
                'has_discount' => 0,
                'image' => $faker->image("public/uploads/faker/", 446, 251, null, false),
                'image_public_id' => "Course Images/fklte52y9uvfrdvibcja",
                'course_overview_provider' => "Youtube",
                "course_overview_url" => $faker->youtubeUri(),
                "featured" => $faker->randomElement([0, 1]),
                "meta_keywords" => "Keyword 1, Keyword 2, Keyword 3",
                'meta_description' => $faker->sentence(150)
            ]);
        }
    }
}
