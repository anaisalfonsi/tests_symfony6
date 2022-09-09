<?php

namespace App\Tests\Entity;

use App\Entity\InvitationCode;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;


class InvitationCodeTest extends KernelTestCase
{
    /**
     * @var AbstractDatabaseTool
     */
    protected $databaseTool;

    public function setUp(): void
    {
        parent::setUp();

        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
    }
    
    public function getEntity() : InvitationCode
    {
        return (new InvitationCode())
        ->setCode('12345')
        ->setDescription('Description de test')
        ->setExpireAt(new \DateTime());
    }

    public function assertHasErrors(InvitationCode $code, int $number = 0)
    {
        $errors = static::getContainer()->get('validator')->validate($code);

        $messages = [];
        
        /** @var ConstraintViolation $error */
        foreach($errors as $error) {
            $messages[] = $error->getPropertyPath() . ' => ' . $error->getMessage();
        }
        $this->assertCount($number, $errors, implode(', ', $messages));

        $this->assertCount($number, $errors);
    }


    public function testValidEntity() 
    {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalidCodeEntity() 
    {
        $this->assertHasErrors($this->getEntity()->setCode('1234'), 1);
        $this->assertHasErrors($this->getEntity()->setCode('1b345'), 1);
    }

    public function testInvalidBlankCodeEntity()
    {
        $this->assertHasErrors($this->getEntity()->setCode(''), 1);
    }

    public function testInvalidBlankDescriptionEntity()
    {
        $this->assertHasErrors($this->getEntity()->setDescription(''), 1);
    }

    public function testInvalidUsedCodeEntity()
    {
        $this->databaseTool->loadAliceFixture([
            dirname(__DIR__) . '/Fixtures/invitation_codes.yml'
        ]);

        $this->assertHasErrors($this->getEntity()->setCode("54321"), 1);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->databaseTool);
    }
}