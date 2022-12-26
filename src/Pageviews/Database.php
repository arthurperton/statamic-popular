<?php

namespace ArthurPerton\Popular\Pageviews;

use Carbon\Carbon;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\QueryException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Statamic\Facades\File;
use Statamic\Facades\Path;

class Database
{
    protected $path;
    protected $connectionName = 'popular';

    public function __construct()
    {
        $this->path = Path::assemble(config('popular.database', database_path('popular')), 'pageviews.sqlite');

        config(['database.connections.popular' => [
            'driver' => 'sqlite',
            'database' => $this->path,
        ]]);
    }

    public function path(): string
    {
        return $this->path;
    }

    public function exists(): bool
    {
        return File::exists($this->path);
    }

    public function create($overwrite = false)
    {
        if (! $overwrite && $this->exists()) {
            return;
        }

        $this->db()->disconnect();

        File::put($this->path, '');

        $schema = Schema::connection($this->connectionName);

        $schema->create('pageview', function (Blueprint $table) {
            $table->string('entry')->index();
            $table->timestamp('timestamp')->index();
        });

        $this->db()->statement('PRAGMA journal_mode=WAL;');
    }

    public function delete()
    {
        File::delete($this->path);
    }

    public function addPageview($entry, $timestamp = null)
    {
        $timestamp = $timestamp ?? Carbon::now()->timestamp;

        $this->query(function ($db) use ($entry, $timestamp) {
            return $db->insert('INSERT INTO pageview (entry, timestamp) VALUES (?, ?)', [$entry, $timestamp]);
        });
    }

    public function getGroupedPageviews()
    {
        $result = $this->query(function ($db) {
            return $db->select('SELECT rowid FROM pageview ORDER BY rowid DESC LIMIT 1');
        });

        if (! $result) {
            return null;
        }

        $lastId = (string) $result[0]->rowid;

        $results = $this->query(function ($db) use ($lastId) {
            return $db->select('SELECT entry, COUNT(*) AS views FROM pageview WHERE rowid <= ? GROUP BY entry', [$lastId]);
        });

        $pageviews = collect($results)->mapWithKeys(function ($result) {
            return [$result->entry => $result->views];
        })->all();

        return [$pageviews, $lastId];
    }

    public function deletePageViews($lastId)
    {
        $this->query(function ($db) use ($lastId) {
            return $db->delete('DELETE FROM pageview WHERE rowid <= ?', [$lastId]);
        });
    }

    public function deletePageViewsForEntry($id)
    {
        $this->query(function ($db) use ($id) {
            return $db->delete('DELETE FROM pageview WHERE entry = ?', [$id]);
        });
    }

    protected function query(callable $callback, $retry = true)
    {
        try {
            return $callback($this->db());
        } catch (QueryException $e) {
            Log::error("The temporary pageviews database for the Popular addon seems to be corrupt and will be re-created now. Original exception: $e");

            $this->create(true);

            if ($retry) {
                return $this->query($callback, false);
            }
        }
    }

    public function db(): ConnectionInterface
    {
        return DB::connection($this->connectionName);
    }
}
