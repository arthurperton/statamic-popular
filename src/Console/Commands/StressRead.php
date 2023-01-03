<?php

namespace ArthurPerton\Popular\Console\Commands;

use ArthurPerton\Popular\Facades\Pageviews;
use Illuminate\Console\Command;

class StressRead extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'popular:stress-read {--frequency= : Number of reads per second}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Keeps reading the pageviews file';

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
        $frequency = $this->option('frequency') ?? 1;

        $sleep = 1E6 / $frequency;

        $i = 0;
        while ($i < 1E10) {

            $items = Pageviews::all();
            $count = count($items);
            // $counts = $items->join(', ');

            echo "$i -> $count\n";

            $i++;

            usleep($sleep);
        }

        return 0;
    }
}
