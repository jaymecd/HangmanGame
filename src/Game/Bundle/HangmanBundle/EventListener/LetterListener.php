<?php

namespace Game\Bundle\HangmanBundle\EventListener;

use Symfony\Component\EventDispatcher\Event;

class LetterListener
{
    public function __construct()
    {
    }

    public function onLetterTry(Event $event)
    {
        $letter = $event->letter;

        file_put_contents('/tmp/letter.log', $letter.PHP_EOL, FILE_APPEND);
    }
}
