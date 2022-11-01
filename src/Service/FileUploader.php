<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * Manage File Upload
 */
class FileUploader
{
    /**
     * FileUploader constructor with auto-binding properties
     *
     * @param string $uploadDirectory
     * @param SluggerInterface $slugger
     * @param string $subDirectory
     * @param string $forcedExtension
     */
    public function __construct(
        private string $uploadDirectory, 
        private SluggerInterface $slugger,
        private string $subDirectory = '',
        private string $forcedExtension = '',
    ) {}

    /**
     * Store uploaded file and return its filepath
     *
     * @param UploadedFile $file 
     * @return ?string filepath
     */
    public function upload(UploadedFile $file) : ?string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename . '-' . uniqid() . '.' . ( $this->forcedExtension ? : $file->guessExtension() );

        
        try {
            $file->move($this->getTargetDirectory(), $fileName);
        } catch (FileException $e) {
            return null;
        }

        return $this->getTargetDirectory() . DIRECTORY_SEPARATOR .  $fileName;
    }

    /**
     * Get the complete target directory
     */
    public function getTargetDirectory()
    {
        return $this->uploadDirectory . ( $this->subDirectory ? : '' );
    }
    

    /**
     * Set the value of subDirectory
     */
    public function setSubDirectory($subDirectory): self
    {
        $this->subDirectory = $subDirectory;

        return $this;
    }

    /**
     * Get the value of subDirectory
     */
    public function getSubDirectory()
    {
        return $this->subDirectory;
    }

    /**
     * Get the value of uploadDirectory
     */
    public function getUploadDirectory()
    {
        return $this->uploadDirectory;
    }

    /**
     * Set the value of forcedExtension
     *
     * @param string $forcedExtension
     *
     * @return self
     */
    public function setForcedExtension(string $forcedExtension): self
    {
        $this->forcedExtension = $forcedExtension;

        return $this;
    }

    /**
     * Get the value of forcedExtension
     *
     * @return string
     */
    public function getForcedExtension(): string
    {
        return $this->forcedExtension;
    }
}