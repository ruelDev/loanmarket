<?php

namespace App\Console\Commands;

use App\Models\ClientRecord;
use Illuminate\Console\Command;

class FetchLenderRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:lender-rates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch lender rates with API and store in database';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        ClientRecord::factory(1)->create();

        // $response = Http::get('https://jsonplaceholder.typicode.com/posts');


        // if ($response->ok()) {
        //     $data = $response->json();

        //     foreach ($data as $item) {
        //         ApiData::updateOrCreate(
        //             ['title' => $item['title']],
        //             ['content' => $item['body']]
        //         );
        //     }

        //     $this->info('Data successfully fetched and stored.');
        // } else {
        //     $this->error('Failed to fetch data.');
        // }
    }
}
