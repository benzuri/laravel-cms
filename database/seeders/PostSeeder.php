<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Iron Man - Tony Stark',
                'slug' => 'iron-man-tony-stark',
                'description' => 'Genius. Billionaire. Philanthropist. Tony Stark\'s confidence is only matched by his high-flying abilities as the hero called Iron Man.',
                'image' => 'https://cdn.marvel.com/content/1x/002irm_ons_crd_03.jpg',
                'category_post_id' => 1
            ],
            [
                'title' => 'Captain America - Steve Rogers',
                'slug' => 'captain-america-steve-rogers',
                'description' => 'Recipient of the Super Soldier serum, World War II hero Steve Rogers fights for American ideals as one of the world\'s mightiest heroes and the leader of the Avengers.',
                'image' => 'https://cdn.marvel.com/content/1x/003cap_ons_crd_03.jpg',
                'category_post_id' => 1
            ],
            [
                'title' => 'Thor - Thor Odinson',
                'slug' => 'thor-thor-odinson',
                'description' => 'The son of Odin uses his mighty abilities as the God of Thunder to protect his home Asgard and planet Earth alike.',
                'image' => 'https://cdn.marvel.com/content/1x/004tho_ons_crd_04.jpg',
                'category_post_id' => 1
            ],
            [
                'title' => 'Spider Man - Peter Parker',
                'slug' => 'spider-man-peter-parker',
                'description' => 'Bitten by a radioactive spider, Peter Parker\'s arachnid abilities give him amazing powers he uses to help others, while his personal life continues to offer plenty of obstacles.',
                'image' => 'https://cdn.marvel.com/content/1x/005smp_ons_crd_02.jpg',
                'category_post_id' => 1
            ],
            [
                'title' => 'Hulk - Bruce Banner',
                'slug' => 'hulk-bruce-banner',
                'description' => 'Dr. Bruce Banner lives a life caught between the soft-spoken scientist he’s always been and the uncontrollable green monster powered by his rage.',
                'image' => 'https://cdn.marvel.com/content/1x/006hbb_ons_crd_03.jpg',
                'category_post_id' => 1
            ],
            [
                'title' => 'War machine - James Rhodes',
                'slug' => 'war-machine-james-rhodes',
                'description' => 'Military veteran James Rhodes is ready for combat in his advanced armor, adding a formidable arsenal to Tony Stark-created designs.  ',
                'image' => 'https://cdn.marvel.com/content/1x/042wmr_ons_crd_04.jpg',
                'category_post_id' => 1
            ],
            [
                'title' => 'Star Lord - Peter Quill',
                'slug' => 'star-lord-peter-quill',
                'description' => 'Leader of the Guardians of the Galaxy, Peter Quill, known as Star-Lord, brings a sassy sense of humor while protecting the universe from any and all threats.',
                'image' => 'https://cdn.marvel.com/content/1x/021slq_ons_crd_03.jpg',
                'category_post_id' => 2
            ],
            [
                'title' => 'Gamora',
                'slug' => 'gamora',
                'description' => 'Raised by Thanos to be a living weapon, Gamora seeks redemption as a member of the Guardians of the Galaxy, putting her extraordinary fighting abilities to good use.',
                'image' => 'https://cdn.marvel.com/content/1x/022gam_ons_crd_02.jpg',
                'category_post_id' => 2
            ],
            [
                'title' => 'Drax',
                'slug' => 'drax',
                'description' => 'Drax uses his super strength and combat skills to destroy any enemies of the galaxy.',
                'image' => 'https://cdn.marvel.com/content/1x/025drx_ons_crd_03.jpg',
                'category_post_id' => 2
            ],
            [
                'title' => 'Rocket',
                'slug' => 'rocket',
                'description' => 'As the weapons and tactical expert of the Guardians of the Galaxy, Rocket risks his hide to defend the cosmos.',
                'image' => 'https://cdn.marvel.com/content/1x/023rra_ons_crd_04.jpg',
                'category_post_id' => 2
            ],
            [
                'title' => 'Groot',
                'slug' => 'groot',
                'description' => 'This sentient alien tree branches out of his comfort zone to help the Guardians of the Galaxy keep the people of the universe safe.',
                'image' => 'https://cdn.marvel.com/content/1x/024grt_ons_crd_02.jpg',
                'category_post_id' => 2
            ],
            [
                'title' => 'Mantis',
                'slug' => 'mantis',
                'description' => 'Mantis uses her powers to protect the galaxy against those who would seek to harm it.',
                'image' => 'https://cdn.marvel.com/content/1x/045mts_ons_crd_03.jpg',
                'category_post_id' => 2
            ]
        ];
        
        DB::table('posts')->insert($posts);
    }
}
