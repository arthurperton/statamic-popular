<?php

namespace ArthurPerton\Statamic\Addons\Popular\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
// use Illuminate\Support\Facades\Storage;
use Statamic\Facades\File;

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
        $file = storage_path('app/popular.sqlite');

        if (!File::exists($file)) {
            File::put($file, '');
        }


        config(['database.connections.popular' => [
            'driver' => 'sqlite',
            'database' => $file,
        ]]);

        $schema = Schema::connection('popular');

        if (!$schema->hasTable('pageviews')) {
            $schema->create('pageviews', function (Blueprint $table) {
                $table->id();
                $table->string('url')->index();
                $table->timestamp('timestamp')->index();
            });
        }

        $db = DB::connection('popular');

        $db->insert('insert into pageviews (url, timestamp) values (?, ?)', ['https://example.com/highway/to/hell', time()]);

        $results = $db->select('select url, count(*) as views from pageviews group by url');
        dd($results);

        return 0;
    }
}
