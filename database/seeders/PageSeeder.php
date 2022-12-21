<?php

namespace Database\Seeders;

use Faker\Provider\Lorem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages=['Hakkımızda','Kariyer','Vizyonumuz','Misyonumuz'];
        $count=0;
        $faker=Faker::create();
        foreach ($pages as $page) {
            $count++;
            DB::table('pages')->insert([
                'title'=>$page,
                'slug'=>Str::slug($page),
                'image'=>$faker->imageUrl(800, 400, 'cats', true, 'Codeigneter Hocası'),
                'content'=>'There are many variations of passages of Lorem Ipsum available, but the majority
                have suffered alteration in some form, by injected humour, or randomised words which dont look even slightly believable.
                If you are going to use a passage of Lorem Ipsum, you need to be sure there isnt anything
                embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet
                tend to repeat predefined chunks as necessary, making this the first true generator on the Internet.
                It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures,
                to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition,
                injected humour, or non-characteristic words etc.',
                'order'=>$count,
                'created_at'=>now(),
                'updated_at'=>now(),
            ]);
        }
    }
}
