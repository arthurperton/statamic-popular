<?php

namespace ArthurPerton\Popular\Console\Commands;

use ArthurPerton\Popular\Pageviews\Database;
use Illuminate\Console\Command;

class CreateDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'popular:create-database {--f|force : Overwrite database if it already exists}';

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
    public function handle(Database $database)
    {
        if ($database->exists()) {
            if ($this->option('force')) {
                $this->info('Creating the database.');
            } else {
                $this->info('The database already exists. Use the --force option to replace the existing database with a fresh new empty one.');
            }
        }

        $database->create(true);

        return 0;
    }
}
