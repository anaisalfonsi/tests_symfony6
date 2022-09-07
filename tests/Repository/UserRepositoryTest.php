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


    public function testCount()
    {

        self::bootKernel();

        $this->databaseTool->loadFixtures([
            'App\DataFixtures\UserFixtures'
        ]);

/*         $usersCount = static::getContainer()->get(UserRepository::class)->count([]);
 */
        $usersCount = $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get(UserRepository::class)->count([]);       
        
        $this->assertEquals(10, $usersCount);
    }
}