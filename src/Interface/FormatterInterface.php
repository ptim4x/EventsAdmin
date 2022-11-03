<?php

namespace App\Interface;

interface FormatterInterface
{
    public function format(array $data): array;
}