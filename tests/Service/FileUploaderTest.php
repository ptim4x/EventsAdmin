<?php

namespace App\Tests\service;

use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

class FileUploaderTest extends KernelTestCase
{
    protected FileUploader $fileUploader;

    protected function setUp(): void
    {
        // (1) boot the Symfony kernel
        self::bootKernel();

        // (2) store the service container
        $this->container = static::getContainer();

        // (3) run some service & test the result
        $this->fileUploader = $this->container->get(FileUploader::class);
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

    public function testUploadDirectoryNotEmpty(): void
    {
        $directory = $this->fileUploader->getUploadDirectory();
        $this->assertNotEmpty($directory);
    }

    public function testUploadDirectoryExists(): void
    {
        $directory = $this->fileUploader->getUploadDirectory();
        $this->assertFileExists($directory);
    }

    public function testOriginalSubDirectoryEmpty(): void
    {
        $directory = $this->fileUploader->getSubDirectory();
        $this->assertEmpty($directory);
    }

    public function testTargetDirectoryValueWithoutSubDirectory(): void
    {
        $uploadDirectory = $this->fileUploader->getUploadDirectory();
        $targetDirectory = $this->fileUploader->getTargetDirectory();
        $this->assertSame($uploadDirectory, $targetDirectory);
    }

    public function testTargetDirectoryValueWithSubDirectory(): void
    {
        $subDirPath = '/subdir';
        $uploadDirectory = $this->fileUploader->getUploadDirectory();
        $this->fileUploader->setSubDirectory($subDirPath);
        $targetDirectory = $this->fileUploader->getTargetDirectory();
        $this->assertSame($uploadDirectory . $subDirPath, $targetDirectory);
    }

    public function testTargetDirectoryWithSubDirectoryExist(): void
    {
        $subDirPath = $this->getParameter('presonlist_sub_directory');
        $targetDirectory = $this->fileUploader
            ->setSubDirectory($subDirPath)
            ->getTargetDirectory();
        $this->assertFileExists($targetDirectory);
    }

    public function testOriginalForcedExtensionEmpty(): void
    {
        $forcedExtension = $this->fileUploader->getForcedExtension();
        $this->assertEmpty($forcedExtension);
    }

    public function testForcedExtensionValue(): void
    {
        $extension = 'txt';
        $forcedExtension = $this->fileUploader
                                ->setForcedExtension($extension)
                                ->getForcedExtension();
        $this->assertSame($extension, $forcedExtension);
    }
}
