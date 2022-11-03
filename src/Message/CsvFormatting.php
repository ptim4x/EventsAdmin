<?php

namespace App\Message;

class CsvFormatting
{
    public function __construct(
        // csv full path file
        private string $path,
        // formated file recipient email 
        private string $email,
        // formatter service class
        private string $formatter
    )
    {}

    /**
     * Get the value of path
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set the value of path
     */
    public function setPath($path): self
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     */
    public function setEmail($email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of formatter
     */
    public function getformatter()
    {
        return $this->formatter;
    }

    /**
     * Set the value of formatter
     */
    public function setformatter($formatter): self
    {
        $this->formatter = $formatter;

        return $this;
    }
}