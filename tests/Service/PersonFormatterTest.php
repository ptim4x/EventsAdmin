<?php

namespace App\Tests\service;

use App\Service\PersonFormatter;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

class PersonFormatterTest extends KernelTestCase
{
    protected PersonFormatter $personFormatter;

    protected function setUp(): void
    {
        // (1) boot the Symfony kernel
        self::bootKernel();

        // (2) store the service container
        $this->container = static::getContainer();

        // (3) run some service & test the result
        $this->personFormatter = $this->container->get(PersonFormatter::class);
    }
    
    /**
     * Gets a container parameter by its name.
     */
    protected function getParameter(string $name): array|bool|string|int|float|\UnitEnum|null
    {
        if (!$this->container->has('parameter_bag')) {
            throw new ServiceNotFoundException('parameter_bag.', null, null, [], sprintf('The "%s::getParameter()" method is missing a parameter bag to work properly. Did you forget to register your controller as a service subscriber? This can be fixed either by using autoconfiguration or by manually wiring a "parameter_bag" in the service locator passed to the controller.', static::class));
        }

        return $this->container->get('parameter_bag')->get($name);
    }

    public function testArrayLengthOk(): void
    {
        $formatted = $this->personFormatter->format([1,2,3]);
        $this->assertCount(2, $formatted);
    }

    public function testArrayLengthError(): void
    {
        $this->expectException(\Exception::class);
        $this->personFormatter->format([1,2]);
    }

    // ...
}
