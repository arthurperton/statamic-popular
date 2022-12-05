<?php

namespace ArthurPerton\Popular\Console\Commands;

use ArthurPerton\Popular\Pageviews\Database;
use Illuminate\Console\Command;
use Statamic\Facades\Entry;

class Stress extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'popular:stress {--frequency= : Number of pageviews added per second}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Keeps adding lots of pageviews';

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
    public function handle(Database $database)
    {
        $frequency = $this->option('frequency') ?? 1;

        $sleep = 1E6 / $frequency;

        $ids = Entry::whereCollection('pages')->map->id()->all();
        $count = count($ids);

        $i = 0;
        while ($i < 1E10) {
            $id = $ids[$i % $count];
            // echo "$id\n";
            echo "$i\n";

            $database->addPageview($id);

            $i++;

            usleep($sleep);
        }

        return 0;
    }
}
