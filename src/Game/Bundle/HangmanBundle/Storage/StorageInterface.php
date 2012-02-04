<?php

namespace Game\Bundle\HangmanBundle\Storage;

interface StorageInterface
{
    public function read($key);

    public function write($key, $value);
}