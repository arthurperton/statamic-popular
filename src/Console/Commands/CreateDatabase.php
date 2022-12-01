<?php

namespace ArthurPerton\Statamic\Addons\Popular\Console\Commands;

use ArthurPerton\Statamic\Addons\Popular\Pageviews\Database;
use Illuminate\Console\Command;

class CreateDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'popular:create-database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates the sqlite database for the Popular addon';

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
        $database = new Database(); // TODO facade / inject?
        $database->create();

        // for ($i = 0; $i < 10000; $i++) {
        //     $database->addPageview('abcdefg' . str_pad($i % 100, 3, '0', STR_PAD_LEFT));
        // }

        // echo (new Aggregator)->aggregate() ? 'aggregation successful' : 'aggregation failed';

        // dd((new Repository)->all());

        return 0;
    }
}
