<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PostImportCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'postImport:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import posts from api';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $url = "https://sq1-api-test.herokuapp.com/posts";
            $response= Http::acceptJson()->get($url);

            if (!$response->successful()){
                $response->throw();
            }

            if($response->ok() && $response->successful()){
                $results = collect($response->json());
                if($results->has('data')){
                    $data = (array) $results->get('data');
                    $chucksData = array_chunk( array_map(function($item){
                        return array_merge($item,[
                            'user_id' => 1,
                            'updated_at' => now(),
                            'created_at' => now(),

                        ]);
                    }, $data), 500);

                    foreach($chucksData as $posts){
                        Post::insertOrIgnore($posts);
                    }
                }
                return 0;
            }else{
                Log::error('Import job post error: '. json_encode($response));
            }
        } catch (Exception $e) {
            Log::error('Import job post error: ' . json_encode($e));
        }
    }
}
