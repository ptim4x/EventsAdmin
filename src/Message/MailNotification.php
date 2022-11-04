<?php

namespace App\Message;

/**
 * Send email with file attachment async message
 */
class MailNotification
{
    public function __construct(
        // full path file for mail attachment
        private string $path,
        // recipient email address
        private string $email,
        // processing timestamp
        private int $prossessingTime,
        // delete local file when email is sent
        private bool $fileToDelete = true,
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
     * Get the value of prossessingTime
     *
     * @return int
     */
    public function getProssessingTime(): int
    {
        return $this->prossessingTime;
    }

    /**
     * Set the value of prossessingTime
     *
     * @param int $prossessingTime
     *
     * @return self
     */
    public function setProssessingTime(int $prossessingTime): self
    {
        $this->prossessingTime = $prossessingTime;

        return $this;
    }

    /**
     * Get the value of fileToDelete
     *
     * @return bool
     */
    public function isFileToDelete(): bool
    {
        return $this->fileToDelete;
    }

    /**
     * Set the value of fileToDelete
     *
     * @param bool $fileToDelete
     *
     * @return self
     */
    public function setFileToDelete(bool $fileToDelete): self
    {
        $this->fileToDelete = $fileToDelete;

        return $this;
    }
}