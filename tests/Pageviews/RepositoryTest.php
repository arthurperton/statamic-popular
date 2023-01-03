<?php

namespace Tests\UserState;

use ArthurPerton\Popular\Pageviews\Repository;
use Statamic\Facades\Path;
use Tests\TestCase;

class RepositoryTest extends TestCase
{
    protected $filename;

    protected function setUp(): void
    {
        parent::setUp();

        config(['popular.files' => storage_path('popular')]);

        $this->filename = Path::assemble(config('popular.files'), 'pageviews');

        @unlink($this->filename);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        @unlink($this->filename);
    }

    /**
     * @test
     */
    public function it_adds_new_pageviews()
    {
        $repository = $this->createRepository();

        $repository->addMultiple(['one' => 1, 'two' => 2]);

        $this->assertEquals(['one' => 1, 'two' => 2], $repository->all()->all());
    }

    /**
     * @test
     */
    public function it_updates_existing_pageviews()
    {
        $repository = $this->createRepository();

        $repository->addMultiple(['one' => 1, 'two' => 2, 'three' => 3]);

        $this->assertEquals(['one' => 1, 'two' => 2, 'three' => 3], $repository->all()->all());

        $repository->addMultiple(['one' => 3, 'three' => 4, 'four' => 4]);

        $this->assertEquals(['one' => 4, 'two' => 2, 'three' => 7, 'four' => 4], $repository->all()->all());
    }

    /**
     * @test
     */
    public function it_sets_pageviews()
    {
        $repository = $this->createRepository();

        $repository->setMultiple(['one' => 1, 'two' => 2, 'three' => 3]);

        $this->assertEquals(['one' => 1, 'two' => 2, 'three' => 3], $repository->all()->all());

        $repository->setMultiple(['one' => 3, 'three' => 4, 'four' => 4]);

        $this->assertEquals(['one' => 3, 'two' => 2, 'three' => 4, 'four' => 4], $repository->all()->all());
    }

    /**
     * @test
     */
    public function it_deletes_pageviews()
    {
        $repository = $this->createRepository();

        $repository->setMultiple(['one' => 1, 'two' => 2, 'three' => 3]);

        $this->assertEquals(['one' => 1, 'two' => 2, 'three' => 3], $repository->all()->all());

        $repository->deleteMultiple(['one', 'two', 'foo']);

        $this->assertEquals(['three' => 3], $repository->all()->all());
    }

    /**
     * @test
     */
    public function it_gets_pageviews()
    {
        $repository = $this->createRepository();

        $repository->setMultiple(['one' => 1, 'two' => 2, 'three' => 3]);

        $this->assertEquals(1, $repository->get('one'));
        $this->assertEquals(2, $repository->get('two'));
        $this->assertEquals(3, $repository->get('three'));
        $this->assertEquals(0, $repository->get('foo'));
    }

    private function createRepository()
    {
        return new Repository();
    }
}
