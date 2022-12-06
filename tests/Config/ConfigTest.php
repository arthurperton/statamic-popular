<?php

namespace Tests\UserState;

use ArthurPerton\Popular\Config\Config;
use Tests\TestCase;

class ConfigTest extends TestCase
{
    /**
     * @test
     */
    public function it_includes_all_collections_by_default()
    {
        $config = new Config();

        $this->assertTrue($config->collectionIncluded('included'));
    }

    /**
     * @test
     */
    public function it_excludes_collections()
    {
        config(['popular.exclude_collections' => ['excluded']]);

        $config = new Config();

        $this->assertTrue($config->collectionIncluded('included'));
        $this->assertFalse($config->collectionIncluded('excluded'));
    }

     /**
     * @test
     */
    public function it_excludes_collections_with_wildcards()
    {
        config(['popular.exclude_collections' => ['excluded*']]);

        $config = new Config();

        $this->assertTrue($config->collectionIncluded('included'));
        $this->assertFalse($config->collectionIncluded('excluded'));
        $this->assertFalse($config->collectionIncluded('excludedtoo'));
        $this->assertFalse($config->collectionIncluded('excludedthree'));
    }

    /**
     * @test
     */
    public function it_includes_collections()
    {
        config(['popular.include_collections' => ['included']]);

        $config = new Config();

        $this->assertTrue($config->collectionIncluded('included'));
        $this->assertFalse($config->collectionIncluded('excluded'));
    }

    /**
     * @test
     */
    public function it_includes_collections_with_wildcards()
    {
        config(['popular.include_collections' => ['included*']]);

        $config = new Config();

        $this->assertTrue($config->collectionIncluded('included'));
        $this->assertTrue($config->collectionIncluded('includedtoo'));
        $this->assertTrue($config->collectionIncluded('includedthree'));
        $this->assertFalse($config->collectionIncluded('excluded'));
    }
}
