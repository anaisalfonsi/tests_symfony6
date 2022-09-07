<?php

namespace App\Tests\Entity;

use App\Entity\InvitationCode;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class InvitationCodeTest extends KernelTestCase
{

    public function getEntity() : InvitationCode
    {
        return (new InvitationCode())
        ->setCode('12345')
        ->setDescription('Description de test')
        ->setExpireAt(new \DateTime());
    }

    public function assertHasErrors(InvitationCode $code, int $number = 0)
    {
        $error = static::getContainer()->get('validator')->validate($code);

        $this->assertCount($number, $error);
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
}