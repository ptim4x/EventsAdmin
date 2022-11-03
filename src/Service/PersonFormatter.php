<?php

namespace App\Service;

use App\Entity\Person;
use App\Interface\FormatterInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Manage Person data formatter
 */
class PersonFormatter implements FormatterInterface
{
    public function __construct(
        private ValidatorInterface $validator
    )
    {}

    /**
     * Return a well formated Person array
     *
     * @param string $email
     * @param string $lastname
     * @param string $firstname
     * @return array
     */
    public function format(array $data) : array
    {
        $person = new Person();
        $person->setEmail($data[0])
                ->setLastname($data[1])
                ->setFirstname($data[2]);

        $errors = $this->validator->validateProperty($person, 'email');
        $email = (count($errors) > 0) ? '' : $person->getEmail();

        return [$person->getCivilite(), $email];
    }

}