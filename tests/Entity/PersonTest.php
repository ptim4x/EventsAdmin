<?php

namespace App\Tests\service;

use App\Entity\Person;
use PHPUnit\Framework\TestCase;

class PersonTest extends TestCase
{
    public function testPersonEmail(): void
    {
        $person = new Person();
        $person->setEmail('example@symfony.com');

        $this->assertEquals($person->getEmail(), 'example@symfony.com');
    }

    public function testPersonCivilite(): void
    {
        $person = new Person();
        $person->setLastname('Nom')
            ->setLastname('Prenom');

        // rule : civilite = uppercase(lastname) . ' ' . firstname
        $this->assertEquals($person->getCivilite(), 'NOM Prenom');
    }

    // ...
}
