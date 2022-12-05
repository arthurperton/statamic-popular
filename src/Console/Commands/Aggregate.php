<?php

namespace ArthurPerton\Popular\Console\Commands;

use ArthurPerton\Popular\Pageviews\Aggregator;
use Illuminate\Console\Command;

class Aggregate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'popular:aggregate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Aggregates the pageviews for the Popular addon';

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
        return (new Aggregator)->aggregate() ? 0 : 1;
    }
}
