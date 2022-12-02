<?php

namespace ArthurPerton\Statamic\Addons\Popular\Pageviews;

use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Statamic\Facades\File;

class Database
{
    // TODO handle errors (e.g. create database again)

    protected $path;
    protected $connection;
    // protected $db;

    public function __construct()
    {
        $this->path = database_path('app/popular.sqlite');
        $this->connection = 'popular';
        $this->create();
    }

    public function exists(): bool
    {
        return File::exists($this->path);
    }

    public function create($overwrite = false)
    {
        if (!$overwrite && $this->exists()) {
            return;
        }

        // if (!File::exists($this->path)) {
        File::put($this->path, '');
        // }

        $schema = Schema::connection($this->connection);

        // if (!$schema->hasTable('pageviews')) {
        $schema->create('pageviews', function (Blueprint $table) {
            $table->string('entry')->index();
            $table->timestamp('timestamp')->index();
        });
        // }

        $db = DB::connection($this->connection);
        $db->statement('PRAGMA journal_mode=WAL;');
    }

    public function delete()
    {
        File::delete($this->path);
    }

    public function addPageview($entry, $timestamp = null)
    {
        $this->db()->insert('INSERT INTO pageviews (entry, timestamp) VALUES (?, ?)', [$entry, $timestamp ?? time()]);
    }

    public function getGroupedPageviews()
    {
        $result = $this->db()->select('SELECT rowid FROM pageviews ORDER BY rowid DESC LIMIT 1');

        if (!$result) {
            return null;
        }

        $lastId = (string) $result[0]->rowid;

        $results = $this->db()->select('SELECT entry, COUNT(*) AS views FROM pageviews WHERE rowid <= ? GROUP BY entry', [$lastId]);

        return [$results, $lastId];
    }

    public function deletePageViews($lastId)
    {
        $this->db()->delete('DELETE FROM pageviews WHERE rowid <= ?', [$lastId]);
    }

    protected function db(): ConnectionInterface
    {
        return DB::connection($this->connection); // TODO cache?
    }
}
