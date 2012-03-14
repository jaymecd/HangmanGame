<?php

namespace Game\Bundle\HangmanBundle\Event;

final class EventMapping
{
    /**
     * Describes event name when letter is about to guess
     * @var string
     */
    const onLetterTry = 'hangman.letter.try';

    /**
     * Describes event name when whole word is about to guess
     * @var string
     */
    const onWordTry   = 'hangman.word.try';
}
