<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Container\Container;
use Illuminate\Database\Seeder;
use Faker\Generator;

use Log;

class DatabaseSeeder extends Seeder
{
    protected $faker;

     /**
     * Get a new Faker instance.
     *
     * @return \Faker\Generator
     */
    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }

    /**
     * Create a new seeder instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->faker = $this->withFaker();
    }

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        # URL List - we want a finite number of urls to choose from, 
        # this is so we have more chances of creating the same url for different sources
        # allowing us to group together same urls
        $iter = 0;
        $urlList = [];
        while($iter<100){
            $urlList[] = $this->faker->url();
            $iter++;
        }

        # Start creating 
        $iter = 0;
        $unqUrlList = []; # We'll keep our unique urls here

        while($iter<300){  
            # Let's get a url from our finite list of urls
            $urlIndex = rand(0,count($urlList)-1);
            $url = $urlList[$urlIndex];

            try{
                if( isset($unqUrlList[$url]) ){ 
                # The url was already encountered before, then:
                    if( $unqUrlList[$url][1] < 3 ){
                        # Create a Sub article with a reference to the Lead's id
                        $article = \App\Models\Article::create([
                            'source' => ucfirst($this->faker->word()),
                            'url'    => $url,
                            'lead_article_id' => $unqUrlList[$url][0]
                        ]);
                        $unqUrlList[$url][1] +=1;
                    }
                }else{ 
                # Meaning this is the first url of its linkeness, then:
                    # Create a normal article
                    $article = \App\Models\Article::create([
                        'source' => ucfirst($this->faker->word()),
                        'url'    => $url,
                    ]);
                    # Add a new unique url to our list, with a reference to its id
                    $unqUrlList[$url] = [ $article->id, 1 ];
                   
                }
            }catch(\Exception $e){
                Log::info('Error ...'.$e->getMessage());
            }
            $iter++;
        }
       
    }
}
