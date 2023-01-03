<?php

namespace ArthurPerton\Popular\Pageviews;

use Illuminate\Support\Facades\Log;
use Statamic\Facades\File;
use Statamic\Facades\Path;

class LockingFile
{
    protected $filename;

    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    public function read()
    {
        if ($data = $this->readString()) {
            $data = unserialize($data);
        }

        return $data;
    }

    public function readString()
    {
        if (! $this->open()) {
            return false;
        }

        $serialized = $this->readStringFromStream();

        $this->close();

        return $serialized;
    }

    public function write($data)
    {
        return $this->writeString(serialize($data));
    }

    public function writeString($string)
    {
        if (! $this->open()) {
            return false;
        }

        $this->writeStringToStream($string);

        $this->close();

        return true;
    }

    public function modify(callable $callback)
    {
        if (! $this->open()) {
            return false;
        }

        $data = $this->readDataFromStream();

        $data = $callback($data);

        $this->writeDataToStream($data);

        $this->close();

        return true;
    }

    protected function open()
    {
        File::makeDirectory(Path::directory($this->filename));

        if (! $this->stream = fopen($this->filename, 'c+')) {
            dd("Unable to open file {$this->filename}");

            return false;
        }

        if (! flock($this->stream, LOCK_EX)) {
            $this->close();

            Log::debug("Couldn't get the lock!");

            return false;
        }

        return true;
    }

    protected function readDataFromStream()
    {
        $serialized = $this->readStringFromStream();

        return unserialize($serialized);
    }

    protected function writeDataToStream($data)
    {
        $this->writeStringToStream(serialize($data));
    }

    protected function readStringFromStream()
    {
        return fgets($this->stream);
    }

    protected function writeStringToStream($string)
    {
        ftruncate($this->stream, 0);
        rewind($this->stream);
        fwrite($this->stream, $string);
        fflush($this->stream);
    }

    protected function close()
    {
        fclose($this->stream); // NOTE this releases the lock too.
    }
}
