<?php

namespace App\Tests\Repository;

use App\Repository\UserRepository;
use App\DataFixtures\UserFixtures;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryTest extends KernelTestCase
{


    /** @var AbstractDatabaseTool */
    protected $databaseTool;


    public function setUp() : void
    {
        parent::setUp();

        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
    }


    public function testCount()
    {

        $this->databaseTool->loadFixtures([
            UserFixtures::class
        ]);

        $usersCount = static::getContainer()->get(UserRepository::class)->count([]);       
        
        $this->assertEquals(10, $usersCount);
    }

    protected function tearDown() : void
    {
        parent::tearDown();
        unset($this->databaseTool);
    }
}